<?php
include_once(__DIR__ . '/../configuracion/funciones.php'); //cargo las funciones que voy a ir usando
$datos = data_submitted(); //traigo los datos del formulario
$controlPortada = new portadaEj4;
$subiendoPortada = $controlPortada->recibirImagen($datos['portada']); //acá se guarad un array con un boolean, mensaje, contenido y link a donde se guardó
$fueSubida = $subiendoPortada['exito']; //recupero el valor boolean(true se subió)
$contenido = $subiendoPortada['contenido'];
$mensaje = $subiendoPortada['mensaje'];

//PREGUNTA: está bien llamar a ese controlador o debería hacer uno para este script?
$controlCine = new cineEj2; //hago una instancia del usuario
$fichaTecnica = $controlCine->mostrarDatos($datos); //mando los datos del formulario a la funcion del controlador
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="/css/style.css">

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>


    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <h1>Resolución Ejercicio n° 5</h1>
            </div>

            <div class="card-body " >
                <?php if ($fueSubida): ?>
                    <div class="card mb-3 alert alert-success" role="alert">
                        <div class="row g-0 align-items-center">

                            <div class="col-md-4 text-center p-2">
                                <img src="<?php echo $contenido; ?>" class="img-fluid rounded-1" alt="portada de la película" style="max-height: 350px; width: 100%; object-fit: cover;">
                            </div>

                            <div class="col-md-8">
                                <div class="card-body">
                                    <h4 class="card-title fw-bold">La película elegida es:</h4>
                                    <div class="card-text">
                                        <?php echo $fichaTecnica; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $mensaje; ?>
                    </div>
                <?php endif; ?>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-3">
                    <a href="../tp2/ejercicio5.php" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>

    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>
</body>

</html>