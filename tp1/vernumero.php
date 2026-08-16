<?php
$numero = $_POST["numero"] ?? ''; //se guarda el valor del input number que puso el user y viajó en el post y reviso tambien si no vino nada
$numero = (int) $numero; //me aseguro que sea entero
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
            <?php
            if ($numero > 0) {
                $tipo = "positivo";
            } elseif ($numero) {
                $tipo = "negativo";
            } else {
                $tipo = "cero";
            }
            ?>
            <p class="resultado">El número ingresado es <?php echo $numero ?> y es <?php echo $tipo ?>.</p>

            <a href="/tp1/ejercicio1.html" class="btn-volver">Volver atrás</a>
        </div>
    </main>
</body>

</html>