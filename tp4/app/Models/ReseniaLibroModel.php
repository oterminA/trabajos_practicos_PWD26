<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage; //importa o "conecta" la fachada (facade) de almacenamiento para gestionar archivos
use Illuminate\Http\UploadedFile; // que importa una clase para gestionar archivos que los usuarios suben a través de formularios web
use RuntimeException; //esto es de js


class ReseniaLibroModel
{
    private string $archivo;

    public function __construct(
        ?string $archivo = null,
    ) {
        $this->archivo = $archivo ?? storage_path('app/public/reseniasLibro.json'); //acá se guarda el script json
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
        foreach ($this->obtenerDatos() as $resenia) {
            if ((int) $resenia['id'] === $id) {
                return $resenia;
            }
        }

        return null;
    }

    /**
     * @param  array{titulo: string, genero: string, anio: int, descripcion: string}  $datos
     */
    public function agregar(array $datos): void
    {
        $resenias = $this->obtenerDatos();
        $ids = array_column($resenias, 'id');

        $resenias[] = [
            'id' => empty($ids) ? 1 : max($ids) + 1,
            'nombreUsuario' => $datos['nombreUsuario'],
            'comentario' => $datos['comentario'],
            'puntaje' => $datos['puntaje'],
            'idLibro' => $datos['idLibro']
        ];

        $this->guardarDatos($resenias);
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
     * @param  array<int, array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}>  $resenias
     */
    private function guardarDatos(array $resenias): void
    {
        $directorio = dirname($this->archivo);

        if (! is_dir($directorio) && ! mkdir($directorio, 0755, true)) {
            throw new RuntimeException('No se pudo crear el directorio de datos.');
        }

        file_put_contents(
            $this->archivo,
            json_encode($resenias, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX,
        );
    }



    /**
     * esta funcion filtra las reseñas que coincidan con el id de la pelicula en cuestion
     * creo que asi no era como decia la profe pero no me acuerdo como era que ella queria xd
     * recibe el id de una pelicula
     * retorna un arreglo vacio o lleno con las reseñas filtradas que pertenecen a esa peli
     */
    public function buscarReseniaXPelicula($idLibro): array
    {
        $reseniasFiltradas = []; //arreglo vacio
        $resenias = $this->obtenerTodas(); //recupero todas las reseñas

        foreach ($resenias as $resenia) { //itero sobre las reseñas
            if (isset($resenia['idLibro']) && (int) $resenia['idLibro'] === (int) $idLibro) { //si existe la variable que busco y coinciden los ids
            $reseniasFiltradas[] = $resenia; //voy metiendo esa reseña en un array de reseñas
        }
        }
        return $reseniasFiltradas; //retorno el arreglo vacio o lleno con las reseñas de esa pelicula
    }

        /**
     * esta funcion filtra las reseñas que coincidan con el id de la pelicula en cuestion
     * creo que asi no era como decia la profe pero no me acuerdo como era que ella queria xd
     * recibe el id de una pelicula
     * retorna un arreglo vacio o lleno con las reseñas filtradas que pertenecen a esa peli
     */
    public function buscarReseniaXLibro($idLibro): array
    {
        $librosFiltrados = []; //arreglo vacio
        $libros = $this->obtenerTodas(); //recupero todas las reseñas

        foreach ($libros as $libro) { //itero sobre las reseñas
            if (isset($libro['idLibro']) && (int) $libro['idLibro'] === (int) $idLibro) { //si existe la variable que busco y coinciden los ids
            $librosFiltrados[] = $libro; //voy metiendo esa reseña en un array de reseñas
        }
        }
        return $librosFiltrados; //retorno el arreglo vacio o lleno con las reseñas de esa pelicula
    }
}

