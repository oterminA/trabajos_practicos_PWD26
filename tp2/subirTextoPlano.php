<?php
include_once(__DIR__ . '/../configuracion/funciones.php'); //cargo las funciones que voy a ir usando
$datos = data_submitted(); //traigo los datos del formulario
$controlArchivo = new archivoEj3;
$subiendoArchivo = $controlArchivo->recibirArchivo($datos); //acá se guarad un array con un boolean, mensaje y link a donde se guardó
$fueSubido = $subiendoArchivo['exito']; //recupero el valor boolean(true se subió)
$contenidoTexto = htmlspecialchars($subiendoArchivo['contenido']);
$mensaje = $subiendoArchivo['mensaje'];
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="/css/style.css">

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>

    <div class="container card my-4 w-auto h-auto">
        <div class="card-header">
            <h1>Resolucion ejercicio 4</h1>
        </div>

        <div class="card-body ">
            <?php if ($fueSubido): ?>
                <div class="alert alert-success" role="alert">
                    <p class="mb-2"><?php echo $mensaje; ?></p>
                </div>
                <div class="alert alert-secondary" role="alert">
                    <p class="mb-2 fw-bold fs-5 text-decoration-underline">El contenido del archivo subido es: </p>
                    <p class="mb-2"><?php echo $contenidoTexto; ?></p>
                </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
            <p class="mb-2"><?php echo $mensaje; ?></p>
        </div>

    <?php endif; ?>
    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
        <a href="../tp2/ejercicio4.php" class="btn btn-secondary">Volver</a>
    </div>
    </div>

    </div>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

</body>

</html>