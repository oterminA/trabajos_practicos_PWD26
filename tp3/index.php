<?php
require_once __DIR__ . '/controllers/PeliculaController.php';

$controller = new PeliculaController();
$accion = $_GET['action'] ?? 'listar';

switch ($accion) {
    case 'listar':
        $controller->index();
        break;
    case 'detalle':
        $controller->detalle();
        break;
    case 'cienciaFiccion':
        $controller->cienciaFiccion();
        break;
    case 'nueva':
        $controller->nueva();
        break;
    case 'guardar':
        $controller->guardar();
        break;
    case 'mostrarDatosEdicion':
        $controller->mostrarDatosEdicion();
        break;
    case 'guardarDatosEditados':
        $controller->guardarDatosEditados();
        break;
    case 'borrar':
        $controller->borrar();
        break;
    case 'buscar':
        $controller->buscar();
        break;
    case 'mostrarGeneros':
        $controller->mostrarGeneros();
        break;
    default:
        http_response_code(404);
        include __DIR__ . ('/views/mi404.php'); //el html que hice para mostrar el 404 temporal
}
