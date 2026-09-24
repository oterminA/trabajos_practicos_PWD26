<?php
/*
Atributos de resenia:
-id
-nombreUsuario
-comentario
-puntaje

Facade o fachada: es una clase que ofrece una interfaz estática hacia los servicios disponibles dentro del contenedor de servicios del framework.

!!!muchas de las funciones están copiadas del repo de la profe Clau !!!
*/

namespace App\Models;

use Illuminate\Support\Facades\Storage; //importa o "conecta" la fachada (facade) de almacenamiento para gestionar archivos
use Illuminate\Http\UploadedFile; // que importa una clase para gestionar archivos que los usuarios suben a través de formularios web
use RuntimeException; //esto es de js


class ReseniaModel
{
    private string $archivo;

    public function __construct(
        ?string $archivo = null,
    ) {
        $this->archivo = $archivo ?? storage_path('app/public/resenias.json');
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
            'idPelicula' => $datos['idPelicula']
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
    public function buscarReseniaXPelicula($idPelicula): array
    {
        $reseniasFiltradas = [];
        $resenias = $this->obtenerTodas();

        foreach ($resenias as $resenia) {
            if (isset($resenia['idPelicula']) && (int) $resenia['idPelicula'] === (int) $idPelicula) {
            $reseniasFiltradas[] = $resenia;
        }
        }

        return $reseniasFiltradas;
    }
}
