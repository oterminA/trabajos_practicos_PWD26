<?php
include_once 'funciones.php';
$nombre = $_POST["nombre"] ?? '';
$apellido = $_POST["apellido"] ?? '';
$edad = $_POST["edad"] ?? '';
$direccion = $_POST["direccion"] ?? '';
$genero = $_POST["genero"] ?? '';
$estudios = $_POST["est"] ?? '';
$deportes = empty($_POST["opciones"]);

$nombre = trim($nombre);
$apellido = trim($apellido);
$direccion = trim($direccion);
$edad = (int) $edad;
$genero = darGenero($genero); //guardo lo que ya devuelva la variable según la elección desde el html
$estudios = estudioAlcanzado($estudios); //guardo lo que ya devuelva la variable segun la eleccion desde el html
$cantidad = cuantosDeportes($deportes);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Resolucion ejercicio 6</title>
</head>

<body>
    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Resolucion</h1>
            <?php if ($nombre === '' || $edad === '' || $direccion === '' || $apellido === '' || $genero === '' || $estudios === ''): ?>
                <p class="error">Los campos no pueden estar vacíos</p>
            <?php else: ?>
                <?php if ($edad > 18) : ?>
                    <p class="resultado">Hola soy <?php echo $nombre . " " .  $apellido ?>, soy mayor de edad y vivo en <?php echo $direccion ?>. Me identifico con el genero <?php echo $genero ?> y mi nivel de estudios es <?php echo $estudios ?>. Tambien practico <?php echo $cantidad ?> deporte(s)</p>
                <?php else: ?>
                    <p class="resultado">Hola soy <?php echo $nombre . " " .  $apellido ?>, soy menor de edad y vivo en <?php echo $direccion ?>. Me identifico con el genero <?php echo $genero ?> y mi nivel de estudios es <?php echo $estudios ?>. Tambien practico <?php echo $cantidad ?> deporte(s)</p>
                    </p>
                <?php endif; ?>
            <?php endif; ?>
            <a href="/tp1/ejercicio6.html" class="btn-volver">Volver atrás</a>
        </div>
    </main>
</body>

</html>