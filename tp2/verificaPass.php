<?php
include_once(__DIR__ . '/../configuracion/funciones.php'); //cargo las funciones que voy a ir usando
$datos = data_submitted(); //traigo los datos del formulario
$controlUsuario = new usuarioEj1(); //hago una instancia del usuario
$esUsuario = $controlUsuario->usuarioExistente($datos);

?>
    <link rel="stylesheet" href="/css/style.css">
    <title>Resolucion ejercicio 1</title>

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>

    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Resolucion</h1>
                <p class="resultado">La cantidad de horas en las que cursa Programación Web Dinámica son: <?php echo $suma ?> hora(s).</p>
            <a href="/tp2/ejercicio1.php" class="btn-volver"  >Volver atrás</a>
        </div>
    </main>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

</body>

</html>