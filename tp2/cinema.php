<?php
include_once(__DIR__ . '/../configuracion/funciones.php'); //cargo las funciones que voy a ir usando
$datos = data_submitted(); //traigo los datos del formulario
$controlCine = new cineEj2; //hago una instancia del usuario
$mensaje = $controlCine->mostrarDatos($datos); //mando los datos del formulario a la funcion del controlador
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="/css/style.css">

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>

    <div class="container alert alert-success my-4 w-auto h-auto" role="alert">
        <div class="card-header">
        <h1>Resolucion ejercicio n° 2</h1>
        </div>

        <div class="card-body">
            <h5 class="text-primary">La pelicula introducida es:</h5>
            <p class="card-text">
                <?php
                echo $mensaje;
                ?>
            </p>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <a href="../tp2/ejercicio2.php" class="btn btn-secondary">Volver</a>
        </div>
    </div>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

</body>

</html>