<?php
/*
Atributos de pelicula:
-titulo
-genero
-anio
-descripcion
-imagen (nombre)
-id

Facade o fachada: es una clase que ofrece una interfaz estática hacia los servicios disponibles dentro del contenedor de servicios del framework.

!!!muchas de las funciones están copiadas del repo de la profe Clau !!!
*/

namespace App\Models;

use Illuminate\Support\Facades\Storage; //importa o "conecta" la fachada (facade) de almacenamiento para gestionar archivos
use Illuminate\Http\UploadedFile; // que importa una clase para gestionar archivos que los usuarios suben a través de formularios web
use RuntimeException; //esto es de js


class PeliculaModelo
{
    //voy a mantener los atributos y constructor casi iguales
    private string $archivo;
    private string $disk;

    public function __construct()
    {
        $this->archivo = storage_path('app/public/peliculas.json');
        $this->disk = 'public';
    }

    /**
     * @return array<int, array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}>
     */
    public function obtenerTodas(): array
    {
        return $this->obtenerDatos();
    }

    /**
     * @return array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}|null
     */
    public function obtenerPorId(int $id): ?array
    {
        foreach ($this->obtenerDatos() as $pelicula) {
            if ((int) $pelicula['id'] === $id) {
                return $pelicula;
            }
        }

        return null;
    }

    /**
     * @return array<int, array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}>
     */
    public function obtenerPorGenero(string $genero): array
    {
        return array_values(array_filter(
            $this->obtenerDatos(),
            fn(array $pelicula): bool => $pelicula['genero'] === $genero,
        ));
    }

    /**
     * @param  array{titulo: string, genero: string, anio: int, descripcion: string}  $datos
     */
    public function agregar(array $datos, UploadedFile $imagen): void
    {
        $peliculas = $this->obtenerDatos();
        $ids = array_column($peliculas, 'id');

        $peliculas[] = [
            'id' => empty($ids) ? 1 : max($ids) + 1,
            'titulo' => $datos['titulo'],
            'genero' => $datos['genero'],
            'anio' => $datos['anio'],
            'descripcion' => $datos['descripcion'],
            'imagen' => $imagen->store('peliculas', $this->disk),
        ];

        $this->guardarDatos($peliculas);
    }

    public function urlImagen(?string $ruta): ?string
    {
        if ($ruta === null || $ruta === '') {
            return null;
        }

        return Storage::disk('public')->url($ruta);
    }

    /**
     * @return array<int, array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}>
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
     * @param  array<int, array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}>  $peliculas
     */
    private function guardarDatos(array $peliculas): void
    {
        $directorio = dirname($this->archivo);

        if (! is_dir($directorio) && ! mkdir($directorio, 0755, true)) {
            throw new RuntimeException('No se pudo crear el directorio de datos.');
        }

        file_put_contents(
            $this->archivo,
            json_encode($peliculas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX,
        );
    }

    /**
     * esta funcion edita los datos de la pelicula deseada
     * recibe un arreglo con los datos editados de la pelicula
     * retorna true/false si se edita la pelicula elegida
     */
    public function editarExistentes($id, $datos, ?UploadedFile $imagen = null)
    {
        $peliculas = $this->obtenerDatos();
        $encontrado = false;

        foreach ($peliculas as $i => $pelicula) {
            if ((int) $pelicula['id'] === $id) {

                $peliculas[$i]['titulo'] = $datos['titulo'];
                $peliculas[$i]['genero'] = $datos['genero'];
                $peliculas[$i]['anio'] = (int) $datos['anio'];
                $peliculas[$i]['descripcion'] = $datos['descripcion'];
                if ($imagen !== null) {
                    if (!empty($peliculas[$i]['imagen'])) {
                        Storage::disk($this->disk)->delete($peliculas[$i]['imagen']);
                    }
                    $peliculas[$i]['imagen'] = $imagen->store('peliculas', $this->disk);
                }
            }
            $encontrado = true;
        }

        //acá aparentemente tengo que usar la funcion que hizo la profe esta vez
        if ($encontrado) {
            $this->guardarDatos($peliculas);
        }
        return $encontrado;
    }

    /**
     * esta funcion elimina la pelicula deseada
     * recibe un arreglo con los datos de la pelicula
     * retorna boolean
     */
    public function delete($id)
    {
        $peliculas = $this->obtenerDatos();
        $borrada = false;

        foreach ($peliculas as $i => $pelicula) {
            if ((int) $pelicula['id'] === $id) {
                //estp es para borrar la imagen de la peli si se tenia una, yo lo hacia con unlink pero acá uso delete q busca y elimina el archivo directamente en la carpeta correcta sin necesidad de armar rutas
                if (!empty($pelicula['imagen'])) {
                    Storage::disk($this->disk)->delete($pelicula['imagen']);
                }
                unset($peliculas[$i]);
                $borrada = true;
            }
        }
        if ($borrada) {
            $this->guardarDatos(array_values($peliculas));
        }
        return $borrada;
    }

    /**
     * esta funcion busca una pelicula por el titulo
     * recibe un string que es el titulo de la pelicula
     * retorna la pelicula encontrada
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
     * esta funcion filtra y guarda los generos no repetidos de las peliculas
     * retorna el arreglo reindexado y sin repeticiones de generos
     */
    public function obtenerGeneros()
    {
        //aparentemente array_column extrae en un solo paso todos los valores bajo la clave 'genero'
        $generos = array_column($this->obtenerDatos(), 'genero');

        $resultado = array_values(array_unique($generos)); //se supone que esto elimina los valores repetidos
        return $resultado;
    }
}
