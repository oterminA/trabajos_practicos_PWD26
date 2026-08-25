<?php
include_once(__DIR__ . '/../configuracion/funciones.php'); //cargo las funciones que voy a ir usando
$datos = data_submitted(); //traigo los datos del formulario
$controlUsuario = new usuarioEj1; //hago una instancia del usuario
$encontrado = $controlUsuario->usuarioExistente($datos); //recupero el boolean de esa funcion
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="/css/style.css">
<title>Resolucion ejercicio 1</title>

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>

    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Resolucion</h1>
            <?php if ($encontrado): ?>
                <div class="alert alert-success" role="alert">
                    Usuario correcto.
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Usuario incorrecto.
                </div>
            <?php endif; ?>
            <a href="/tp2/ejercicio1.php" class="btn-volver">Volver atrás</a>
        </div>
    </main>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

</body>

</html>