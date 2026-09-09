<?php
require_once __DIR__ . '/../models/PeliculaModel.php';

class PeliculaController
{
    private PeliculaModel $modelo; //atributo

    public function __construct()
    {
        $this->modelo = new PeliculaModel();
    }

    public function index(): void
    {
        $peliculas = $this->modelo->obtenerTodas(); //desde el modelo se va a esta funcion que trae todas las peliculas
        $generos = $this->modelo->obtenerGeneros(); //ESTO TIENE QUE ESTAR PARA MOSTRAR LO DEL EJERCICIO4
        require __DIR__ . '/../views/peliculas.php'; //y con esto se redirige a peliculas.php con lo que esté guardado en $peliculas
    }

    public function detalle(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; //desde peliculas se trae el id para buscarlo en obtenerporid
        $pelicula = $this->modelo->obtenerPorId($id); //se guardan los datos de esa pelicula
        require __DIR__ . '/../views/detalle.php'; // y se lo manda a detale.php
    }

    public function cienciaFiccion(): void
    {
        $peliculas = $this->modelo->obtenerPorGenero('Ciencia ficción'); //guarda acá las peliculas filtradas usando esa funcion desde el modelo
        require __DIR__ . '/../views/peliculas.php'; //eso se manda e peliculas.php
    }

    public function nueva(): void
    {
        $errores = []; //arreglo vacio para meter los errores que surjan
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
        //esta función ya venia hecha pero modularicé algunas partes
        $errores = []; //arreglo vacio para meter los errores que surjan
        $datos = [ //traigo los datos que vienen desde el formulario en nueva
            'titulo' => trim($_POST['titulo'] ?? ''),
            'genero' => trim($_POST['genero'] ?? ''),
            'anio' => trim($_POST['anio'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
        ];

        $errores = array_merge( //acá guardo en errores el rejunte de los errores que vienen desde las otras funciones que validan datos
            $this->datosNulos($datos), //acá valido que los datos no estén vacíos
            $this->validarAnio($datos['anio']) //acá valido que el año sea correcto según ciertos parámetros
        );

        $imagen = $_FILES['imagen'] ?? null;
        $resImagen = $this->validarImagen($imagen, true); //proqeu estoy mandando un boolean para decirle a la funcion si es o no obligatoria la imagen para poder reutilizarla
        //de acá traigo el tipo de la imagen y los errores

        if (!empty($resImagen['errores'])) { //si esa fucnion trae errores
            $errores = array_merge($errores, $resImagen['errores']); //le sumo los errores a la variable de errores
        }

        if ($errores) {
            require __DIR__ . '/../views/nueva.php';
        } else {
            $nombreImagen = $this->modelo->guardarImagen($imagen, $resImagen['tipo']); //acá guardo el nombre de la imagen que retorna esa funcion

            $this->modelo->agregar([ //al modelo le mando los datos que tienen que pasarse al json
                'titulo' => $datos['titulo'],
                'genero' => $datos['genero'],
                'anio' => $datos['anio'],
                'descripcion' => $datos['descripcion'],
                'imagen' => $nombreImagen,
            ]);

            header('Location: index.php?action=listar'); //redirecciono 
            exit;
        }
    }


    /**
     * esta funcion revisa que no existan datos nulos o vacios desde algun formulario
     * recibe un array
     * retorna un array de string errores
     */
    public function datosNulos($datos)
    {
        $errores = [];
        if ($datos['titulo'] === '') {
            $errores[] = 'El título es obligatorio.';
        }

        if ($datos['genero'] === '') {
            $errores[] = 'El género es obligatorio.';
        }

        if ($datos['descripcion'] === '') {
            $errores[] = 'La descripción es obligatoria.';
        }
        return $errores;
    }

    /**
     * esta funcion valida que el año sea correcto segun ciertos parametros
     * recibe un entero
     * retorna un arreglo de string errores
     */
    public function validarAnio($anio)
    {
        $errores = [];
        $fecha = filter_var($anio, FILTER_VALIDATE_INT);
        $max = (int) date('Y') + 5;

        if ($fecha === false || $fecha < 1895 || $fecha > $max) {
            $errores[] = "El año debe estar entre 1895 y {$max}.";
        }

        return $errores;
    }


    /**
     * esta funcion valida que la imagen tenga el tamaño correcto, extension aceptada y demás
     * recibe una imagen y un boolean indicando si es obligatoria de pedir o no
     * retorna un arreglo que trae string errores y el tipo de extension de la imagen
     */
    public function validarImagen($imagen, $esObligatoria = false)
    {
        $resultado = [ //arreglo vacio para guardar errores y el tipo de extension
            'errores' => [],
            'tipo' => null
        ];

        $errorCarga = $imagen['error'] ?? UPLOAD_ERR_NO_FILE; //por si la imagen trae un error

        //acá puse muchos if/elseif/else porque la alternativa era usar multiples retornos
        if ($errorCarga === UPLOAD_ERR_NO_FILE || empty($imagen['tmp_name'])) {
            if ($esObligatoria) {
                $resultado['errores'][] = 'Debe seleccionar una imagen válida.'; //por si es obligatoria la imagen, por ejemplo en el formulario de nueva
            }
        } else if ($errorCarga === UPLOAD_ERR_INI_SIZE || $errorCarga === UPLOAD_ERR_FORM_SIZE) {
            $resultado['errores'][] = 'La imagen supera el peso máximo permitido por el servidor.';
        } else if ($errorCarga !== UPLOAD_ERR_OK) {
            $resultado['errores'][] = 'Ocurrió un error al subir la imagen.';
        } else {
            if ($imagen['size'] > 300 * 1024) {
                $resultado['errores'][] = 'La imagen no puede superar los 300KB.'; //por si se supera el tamaño de la imagen 
            }

            if (!file_exists($imagen['tmp_name'])) { //me fijo si el archivo existe en esa ruta
                $resultado['errores'][] = 'El archivo temporal no se pudo procesar.';
            }

            if (empty($resultado['errores'])) { //si no tengo errores
                $finfo = new finfo(FILEINFO_MIME_TYPE); //chequeo lo del formato
                $tipo = $finfo->file($imagen['tmp_name']); //gurado el formato que tenga la imagen

                if (!in_array($tipo, ['image/jpeg', 'image/png', 'image/webp'], true)) {
                    $resultado['errores'][] = 'El archivo debe ser JPG, PNG o WEBP.'; //valido que el formato de la imagen sea el que está entre esos
                } else {
                    $resultado['tipo'] = $tipo; //guardo el tipo correcto
                }
            }
        }

        return $resultado; //retorno el tipo y los errores para la funcion que los pide
    }

    /**
     * esta funcion consulta al modelo y trae los datos existentes de la pelicula que se quiere editar
     * recibe el id de la pelicula a mostrar
     * retorna los datos de la pelicula en un array
     */
    public function mostrarDatosEdicion()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; //recupero el id de la peli
        $pelicula = $this->modelo->obtenerPorId($id); //busco en el modelo los datos de esa pelicula y los guardo aca para mostrar en la vista
        require __DIR__ . '/../views/editar.php';
    }


    /**
     * esta funcion recibe los nuevos y opcionales datos y los manda al modelo para modificar el json
     * recibe un arreglo por post de los datos de la pelicula
     * retorna nada pero guarda los cambios hechos
     */
    public function guardarDatosEditados()
    {
        $id = (int) ($_POST['id'] ?? 0); //recupero el id de la pelicula que está en el json
        $peliculaActual = $this->modelo->obtenerPorId($id); //traigo los datos de la pelicula actual, la que busco

        $datos = [ //guardo en un array los datos que vienen desde el editar.php
            'id' => $id,
            'titulo' => trim($_POST['titulo'] ?? ''),
            'genero' => trim($_POST['genero'] ?? ''),
            'anio' => trim($_POST['anio'] ?? ''),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
        ];

        $errores = [];

        if ($datos['anio'] !== '') { //si anio no viene vacio
            $errores = array_merge($errores, $this->validarAnio($datos['anio'])); //guardo la validacion de año
        }

        $imagen = $_FILES['imagen'] ?? null;
        $resImagen = $this->validarImagen($imagen, false); // false = opcional al editar

        if (!empty($resImagen['errores'])) {
            $errores = array_merge($errores, $resImagen['errores']);
        }

        if (!empty($errores)) { //si hay errores mando al editar
            $pelicula = array_merge($peliculaActual, $datos);
            require __DIR__ . '/../views/editar.php';
        } else {
            $nombreImagen = $peliculaActual['imagen'] ?? '';
            if ($resImagen['tipo'] !== null) {
                $nombreImagen = $this->modelo->guardarImagen($imagen, $resImagen['tipo']);
                // die("hasta acá llega");
            }

            $this->modelo->editarExistentes([
                'id' => $datos['id'],
                'titulo' => $datos['titulo'] !== '' ? $datos['titulo'] : $peliculaActual['titulo'],
                'genero' => $datos['genero'] !== '' ? $datos['genero'] : $peliculaActual['genero'],
                'anio' => $datos['anio'] !== '' ? (int)$datos['anio'] : $peliculaActual['anio'],
                'descripcion' => $datos['descripcion'] !== '' ? $datos['descripcion'] : $peliculaActual['descripcion'],
                'imagen' => $nombreImagen,
            ]);
            // die("hasta acá llega");

            header('Location: index.php?action=listar');
            exit;
        }
    }

    /**
     * esta funcion llama a una del modelo para borrar la pelicula elegida
     * recibe el id de la pelicula a borrar
     * retorna nada porque la pelicula fue borrada
     */
    public function borrar()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0; //desde peliculas se trae el id para buscarlo en obtenerporid
        $pelicula = $this->modelo->obtenerPorId($id); //se guardan los datos de esa pelicula
        $this->modelo->eliminar($pelicula); //llamo a la funcion del modelo
        header('Location: index.php?action=listar'); //redirecciono al index
        exit;
    }

    /**
     * esta funcion la uso para buscar una pelicula
     * entra el titulo de la pelicula
     *retorno la pelicula buscada o vacio si no hay nada
     */
    public function buscar()
    {
        $titulo = trim($_POST['buscar'] ?? ''); //desde la vista recupero el nombre a buscar
        $resultado = $this->modelo->buscar($titulo); //se lo mando al modelo para que lo busque y guardo el resultado acá
        if (empty($resultado)) { //si desde el modelo no se devolvió algo es porque quizas no existe
            $peliculas = [['titulo' => '']]; //entonces guardo como vacio el titulo
        } else { //si se devolvió algo lo paso para que se vea en la vista
            $peliculas = $resultado;
        }
        require __DIR__ . '/../views/peliculas.php';
        // die("quedé acá");
    }

    /**
     * esta funcion ocupa una del modelo para filtrar los generos de las peliculas
     */
    public function mostrarGeneros()
    {
        $generoSeleccionado = $_POST['genero'] ?? $_GET['genero'] ?? ''; //por post o get recibo el genero elegido(puse pots en caso de que lo cambie y no me de cuenta de que no actualicé esta parte)
        if ($generoSeleccionado !== '') { //si se eligió un genero
            $peliculas = $this->modelo->obtenerPorGenero($generoSeleccionado); //llamo a esta funcion del modelo que busca el genero que se necesita
        } else { //si no se eligió nada entonces se llaman a odas las peliculas
            $peliculas = $this->modelo->obtenerTodas();
        }

        $generos = $this->modelo->obtenerGeneros(); //en lo que le mando a la vista muestro todos los generos
        require __DIR__ . '/../views/peliculas.php';
    }
}
