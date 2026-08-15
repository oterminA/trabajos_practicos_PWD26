<?php
include_once 'funciones.php';
$numeroA = $_POST["numeroA"] ?? '';
$numeroB = $_POST["numeroB"] ?? '';
$operacion = $_POST["operacion"] ?? '';
$resultado = hacerOperacion($operacion, $numeroA, $numeroB); //pasa algo raro cuando es division x cero
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Resolucion ejercicio 7</title>
</head>

<body>
    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Resolucion</h1>
            <?php if ($numeroA === '' || $numeroB === ''): ?>
                <p class="error">Los campos no pueden estar vacíos</p>
            <?php else: ?>
                <?php if ($resultado === -1): ?>
                    <p class="error">No se puede dividir por cero</p>
                <?php else: ?>
                    <p class="resultado">El resultado de la <?php echo $operacion ?> es <?php echo $resultado ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <a href="/tp1/ejercicio7.html" class="btn-volver">Volver atrás</a>
        </div>
    </main>
</body>

</html>