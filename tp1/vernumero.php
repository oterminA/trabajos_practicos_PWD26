<?php
$numero = $_POST["numero"] ?? ''; //se guarda el valor del input number que puso el user y viajó en el post y reviso tambien si no vino nada
$numero = trim($numero); //le saco los espacios
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Resolucion ejercicio 1</title>
</head>

<body>
    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Resolucion</h1>
            <?php if ($numero > 0): ?>
                <p class="resultado">El número ingresado es <?php echo $numero ?> y es un numero positivo.</p>
            <?php elseif ($rol === 'editor'): ?>
                <p class="resultado">El número ingresado es <?php echo $numero ?> y es un numero positivo.</p>

            <?php endif; ?>
            <a href="/tp1/ejercicio1.html" class="btn-volver" target="_blank">Volver atrás</a>
        </div>
    </main>
</body>

</html>