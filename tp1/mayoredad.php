<?php
include_once 'funciones.php';
$nombre = $_POST["nombre"] ?? '';
$apellido = $_POST["apellido"] ?? '';
$edad = $_POST["edad"] ?? '';
$direccion = $_POST["direccion"] ?? '';

$nombre = trim($nombre);
$apellido = trim($apellido);
$direccion = trim($direccion);
$edad = (int) $edad;
$esMayorEdad = esMayor($edad);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Resolucion ejercicio 4</title>
</head>

<body>
    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Resolucion</h1>
            <?php if ($nombre === '' || $edad === '' || $direccion === '' || $apellido === ''): ?>
                <p class="error">Los campos no pueden estar vacíos</p>
            <?php else: ?>
                <?php
                if ($esMayorEdad) {
                    $texto = "mayor";
                } else {
                    $texto = "menor";
                }
                ?>
                <p class="resultado">Hola soy <?php echo $nombre . " " .  $apellido ?>, soy <?php echo $texto ?> de edad y vivo en <?php echo $direccion ?></p>
            <?php endif; ?>
            <a href="/tp1/ejercicio4.html" class="btn-volver">Volver atrás</a>
        </div>
    </main>
</body>

</html>