<?php

class PeliculaModel
{
    private string $archivo;
    private string $directorioImagenes;

    public function __construct()
    {
        $this->archivo = __DIR__ . '/../data/peliculas.json';
        $this->directorioImagenes = __DIR__ . '/../uploads/';
    }

    private function obtenerDatos(): array
    {
        if (!file_exists($this->archivo)) {
            return [];
        }

        $contenido = file_get_contents($this->archivo);
        $datos = json_decode($contenido ?: '[]', true);

        return is_array($datos) ? $datos : [];
    }

    public function obtenerTodas(): array
    {
        return $this->obtenerDatos();
    }

    public function obtenerPorId(int $id): ?array
    {
        foreach ($this->obtenerDatos() as $pelicula) {
            if ((int) $pelicula['id'] === $id) {
                return $pelicula;
            }
        }

        return null;
    }

    public function obtenerPorGenero(string $genero): array
    {
        return array_values(array_filter(
            $this->obtenerDatos(),
            fn($p) => $p['genero'] === $genero
        ));
    }

    public function guardarImagen(array $archivo, string $tipo): string
    {
        if (!is_dir($this->directorioImagenes)) {
            mkdir($this->directorioImagenes, 0777, true);
        }

        $extensiones = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($extensiones[$tipo])) {
            throw new RuntimeException('Tipo de imagen no permitido.');
        }

        $nombre = uniqid('pelicula_', true) . '.' . $extensiones[$tipo];

        if (!move_uploaded_file($archivo['tmp_name'], $this->directorioImagenes . $nombre)) {
            throw new RuntimeException('No se pudo guardar la imagen.');
        }

        return $nombre;
    }

    public function agregar(array $pelicula): void
    {
        $peliculas = $this->obtenerDatos();
        $ids = array_column($peliculas, 'id');
        $pelicula['id'] = empty($ids) ? 1 : max($ids) + 1;
        $peliculas[] = $pelicula;

        file_put_contents(
            $this->archivo,
            json_encode($peliculas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );
    }


    /**
     * esta funcion edita los datos de la pelicula deseada
     */
    public function editarExistentes($arreglo)
    {
        $peliculas = $this->obtenerDatos(); //traigo el arreglo completo de peliculas
        $id = $arreglo['id'];
        $titulo = $arreglo['titulo'];
        $genero = $arreglo['genero'];
        $anio = $arreglo['anio'];
        $descripcion = $arreglo['descripcion'];
        $imagen = $arreglo['imagen'];

        foreach ($peliculas as $pelicula) {
            if ($pelicula['id'] === $id) {
                $pelicula['titulo'] = $titulo;
                $pelicula['genero'] = $genero;
                $pelicula['anio'] = $anio;
                $pelicula['descripcion'] = $descripcion;
                $pelicula['imagen'] = $imagen;
            }
        }
        file_put_contents(
            $this->archivo,
            json_encode($peliculas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );
    }
}
