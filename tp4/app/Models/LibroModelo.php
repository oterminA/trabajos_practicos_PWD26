<?php
namespace App\Models;

use Illuminate\Support\Facades\Storage; //importa o "conecta" la fachada (facade) de almacenamiento para gestionar archivos
use Illuminate\Http\UploadedFile; // que importa una clase para gestionar archivos que los usuarios suben a través de formularios web
use RuntimeException; //esto es de js

class LibroModelo
{
    private string $archivo;

    public function __construct(
        ?string $archivo = null,
        private readonly string $disk = 'public',
    ) {
        $this->archivo = $archivo ?? storage_path('app/public/libros.json'); //acá es donde guardo el script json
    }

    /**
     * @return array<int, array{id: int, titulo: string, genero: string, anio: int, sinopsis: string, imagen: ?string}>
     */
    public function obtenerTodos(): array
    {
        return $this->obtenerDatos();
    }

    /**
     * @return array{id: int, titulo: string, genero: string, anio: int, sinopsis: string, imagen: ?string}|null
     */
    public function obtenerPorId(int $id): ?array
    {
        foreach ($this->obtenerDatos() as $libro) {
            if ((int) $libro['id'] === $id) {
                return $libro;
            }
        }

        return null;
    }

    /**
     * @return array<int, array{id: int, titulo: string, genero: string, anio: int, sinopsis: string, imagen: ?string}>
     */
    public function obtenerPorGenero(string $genero): array
    {
        return array_values(array_filter(
            $this->obtenerDatos(),
            fn(array $libro): bool => $libro['genero'] === $genero,
        ));
    }


    /**
     * @param  array{titulo: string, genero: string, anio: int, sinopsis: string}  $datos
     */
    public function agregar(array $datos, UploadedFile $imagen): void
    {
        $libros = $this->obtenerDatos();
        $ids = array_column($libros, 'id');

        $libros[] = [
            'id' => empty($ids) ? 1 : max($ids) + 1,
            'titulo' => $datos['titulo'],
            'autor' => $datos['autor'],
            'genero' => $datos['genero'],
            'anio' => $datos['anio'],
            'sinopsis' => $datos['sinopsis'],
            'imagen' => $imagen->store('libros', $this->disk),
        ];

        $this->guardarDatos($libros);
    }

    public function urlImagen(?string $ruta): ?string
    {
        if ($ruta === null || $ruta === '') {
            return null;
        }

        return Storage::url($ruta);
    }

    /**
     * @return array<int, array{id: int, titulo: string, genero: string, anio: int, sinopsis: string, imagen: ?string}>
     */
    private function obtenerDatos(): array
    {
        if (! file_exists($this->archivo)) {
            return [];
        }

        $contenido = file_get_contents($this->archivo);
        $datos = json_decode($contenido ?: '[]', true);

        return is_array($datos) ? $datos : [];
    }

    /**
     * @param  array<int, array{id: int, titulo: string, genero: string, anio: int, sinopsis: string, imagen: ?string}>  $libros
     */
    private function guardarDatos(array $libros): void
    {
        $directorio = dirname($this->archivo);

        if (! is_dir($directorio) && ! mkdir($directorio, 0755, true)) {
            throw new RuntimeException('No se pudo crear el directorio de datos.');
        }

        file_put_contents(
            $this->archivo,
            json_encode($libros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX,
        );
    }

    /**
     * esta funcion edita los datos de la libro deseada
     * recibe un arreglo con los datos editados de la libro
     * retorna true/false si se edita la libro elegida
     */
    public function editarExistentes($id, $datos, $imagen)
    {
        $libros = $this->obtenerDatos(); //recuepro todas las libros
        $encontrado = false; //bandera en valor por defecto

        foreach ($libros as $i => $libro) { //acá lo que hago es iterar las libros hasta coincidir con la libro que estoy buscando por id y después voy actualizando los datos(con datos nuevos o los existentes que quedaron)
            if ((int) $libro['id'] === (int) $id) {
                $libros[$i]['titulo']      = $datos['titulo'];
                $libros[$i]['autor']      = $datos['autor'];
                $libros[$i]['genero']      = $datos['genero'];
                $libros[$i]['anio']        = (int) $datos['anio'];
                $libros[$i]['sinopsis'] = $datos['sinopsis'];

                if ($imagen !== null) { //si la imagen no es null
                    if (!empty($libro['imagen'])) { //y la libro tiene como valor una imagen
                        Storage::disk($this->disk)->delete($libro['imagen']); //borro la imagen que tenia
                    }
                    $libros[$i]['imagen'] = $imagen->store('libros', $this->disk); //y acá cargo con una nueva imagen(que puede ser nueva o la vieja que tenia)
                }
                $encontrado = true; //cambio el valor de la variable
            }
        }

        //acá aparentemente tengo que usar la funcion que hizo la profe esta vez
        if ($encontrado) {
            $this->guardarDatos($libros);
        }
        return $encontrado;
    }

    /**
     * esta funcion elimina la libro deseada
     * recibe un arreglo con los datos de la libro
     * retorna boolean
     */
    public function delete($id)
    {
        //creo que esta funcion puede hacerse más sencilla pero asi me salio a mi xd
        $libros = $this->obtenerDatos(); //recuper todas las libros
        $borrada = false; //bandera en falso

        foreach ($libros as $i => $libro) { //itero por cada libro hasta encontrar la necesaria
            if ((int) $libro['id'] === $id) {
                //estp es para borrar la imagen de la peli si se tenia una, yo lo hacia con unlink pero acá uso delete q busca y elimina el archivo directamente en la carpeta correcta sin necesidad de armar rutas
                if (!empty($libro['imagen'])) {
                    Storage::disk($this->disk)->delete($libro['imagen']);
                }
                unset($libros[$i]);
                $borrada = true;
            }
        }
        if ($borrada) {
            $this->guardarDatos(array_values($libros));
        }
        return $borrada;
    }

    /**
     * esta funcion busca una libro por el titulo
     * recibe un string que es el titulo de la libro
     * retorna la libro encontrada
     */
    public function buscar($titulo)
    {
        //si quisiese que la busqueda sea independiente de mayusculas y minisculas, tendria que uar mb_stripos creo
        return array_values(array_filter(
            $this->obtenerDatos(),
            fn(array $p): bool => $p['titulo'] === $titulo
        ));
    }

    /**
     * esta funcion filtra y guarda los generos no repetidos de las libros
     * retorna el arreglo reindexado y sin repeticiones de generos
     */
    public function obtenerGeneros()
    {
        //aparentemente array_column extrae en un solo paso todos los valores bajo la clave 'genero'
        $generos = array_column($this->obtenerDatos(), 'genero');

        $resultado = array_values(array_unique($generos)); //se supone que esto elimina los valores repetidos
        return $resultado;
    }

    /**
     *
     */
    public function obtenerPorAutor(string $autor): array
    {
        return array_values(array_filter(
            $this->obtenerDatos(),
            fn(array $libro): bool => $libro['autor'] === $autor,
        ));
    }

    /**
     * esta funcion filtra y guarda los autores no repetidos de las libros
     * retorna el arreglo reindexado y sin repeticiones de autores
     */
    public function obtenerAutores()
    {
        //aparentemente array_column extrae en un solo paso todos los valores bajo la clave 'autores'
        $autores = array_column($this->obtenerDatos(), 'autor');

        $resultado = array_values(array_unique($autores)); //se supone que esto elimina los valores repetidos
        return $resultado;
    }
}
