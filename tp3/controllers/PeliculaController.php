<?php
require_once __DIR__ . '/../models/PeliculaModel.php';

class PeliculaController
{
    private PeliculaModel $modelo;

    public function __construct()
    {
        $this->modelo = new PeliculaModel();
    }

    public function index(): void
    {
        $peliculas = $this->modelo->obtenerTodas();
        require __DIR__ . '/../views/peliculas.php';
    }

    public function detalle(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $pelicula = $this->modelo->obtenerPorId($id);
        require __DIR__ . '/../views/detalle.php';
    }

    public function cienciaFiccion(): void
    {
        $peliculas = $this->modelo->obtenerPorGenero('Ciencia ficción');
        require __DIR__ . '/../views/peliculas.php';
    }

    public function nueva(): void
    {
        $errores = [];
        $datos = [
            'titulo' => '',
            'genero' => '',
            'anio' => '',
            'descripcion' => '',
        ];

        require __DIR__ . '/../views/nueva.php';
    }

    public function guardar(): void
    {
        $datos = [
            'titulo' => trim($_POST['titulo'] ?? ''),
            'genero' => trim($_POST['genero'] ?? ''),
            'anio' => trim($_POST['anio'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
        ];

        $errores = [];

        if ($datos['titulo'] === '') {
            $errores[] = 'El título es obligatorio.';
        }

        if ($datos['genero'] === '') {
            $errores[] = 'El género es obligatorio.';
        }

        $anio = filter_var($datos['anio'], FILTER_VALIDATE_INT);
        $max = (int) date('Y') + 5;

        if ($anio === false || $anio < 1895 || $anio > $max) {
            $errores[] = "El año debe estar entre 1895 y {$max}.";
        }

        if ($datos['descripcion'] === '') {
            $errores[] = 'La descripción es obligatoria.';
        }

        $imagen = $_FILES['imagen'] ?? null;
        $tipo = null;

        if (!$imagen || ($imagen['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            $errores[] = 'Debe seleccionar una imagen válida.';
        } else {
            if ($imagen['size'] > 2 * 1024 * 1024) {
                $errores[] = 'La imagen no puede superar los 2 MB.';
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $tipo = $finfo->file($imagen['tmp_name']);

            if (!in_array($tipo, ['image/jpeg', 'image/png', 'image/webp'], true)) {
                $errores[] = 'El archivo debe ser JPG, PNG o WEBP.';
            }
        }

        if ($errores) {
            require __DIR__ . '/../views/nueva.php';
            return;
        }

        $nombreImagen = $this->modelo->guardarImagen($imagen, $tipo);

        $this->modelo->agregar([
            'titulo' => $datos['titulo'],
            'genero' => $datos['genero'],
            'anio' => $anio,
            'descripcion' => $datos['descripcion'],
            'imagen' => $nombreImagen,
        ]);

        header('Location: index.php?action=listar');
        exit;
    }

    /**
     * esta funcion consulta al modelo y trae los datos existentes de la pelicula que se quiere editar
     */
    public function mostrarDatosEdicion()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; //recupero el id de la peli
        $pelicula = $this->modelo->obtenerPorId($id); //busco en el modelo los datos de esa pelicula y los guardo aca para mostrar en la vista
        require __DIR__ . '/../views/editar.php';
    }


    /**
     * esta funcion recibe los nuevos y opcionales datos y los manda al modelo para modificar el json
     */
    public function guardarDatosEditados()
    {
        //REVISAR QUE HAY DATOS EN ESTA FUNCION Y EN LA DE GUARDAR QUE PUEDEN MODULARIZARSE(verificar año, validar la imagen, etc)
        $errores = [];
        $datos = [
            'id' => $_POST['id'],
            'titulo' => trim($_POST['titulo']),
            'genero' => trim($_POST['genero']),
            'anio' => trim($_POST['anio']),
            'descripcion' => trim($_POST['descripcion']),
        ];
        $anio = filter_var($datos['anio'], FILTER_VALIDATE_INT);
        $max = (int) date('Y') + 5;

        if ($anio === false || $anio < 1895 || $anio > $max) {
            $errores[] = "El año debe estar entre 1895 y {$max}.";
        }

        $imagen = $_FILES['imagen'] ?? null;
        $tipo = null;

        if ($imagen['size'] > 2 * 1024 * 1024) {
            $errores[] = 'La imagen no puede superar los 2 MB.';
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $tipo = $finfo->file($imagen['tmp_name']);

        if (!in_array($tipo, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            $errores[] = 'El archivo debe ser JPG, PNG o WEBP.';
        }

        if ($errores) {
            require __DIR__ . '/../views/editar.php';
        } else {
            $nombreImagen = $this->modelo->guardarImagen($imagen, $tipo);

            $this->modelo->editarExistentes([
                'id' => $datos['id'],
                'titulo' => $datos['titulo'],
                'genero' => $datos['genero'],
                'anio' => $anio,
                'descripcion' => $datos['descripcion'],
                'imagen' => $nombreImagen,
            ]);

            header('Location: index.php?action=listar');
            exit;
        }
    }
}
