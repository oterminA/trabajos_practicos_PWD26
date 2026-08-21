<?php
//NO ESTARÍA FUNCIONANDO LA PARTE DE COBRAR 180$
$edad = $_POST["edad"] ?? '';
$esEstudiante = $_POST["rta"] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>Resolucion ejercicio 8</title>
</head>

<body>
    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Resolucion</h1>
            <?php if ($esEstudiante === '' || $edad === ''): ?>
                <p class="error">Los campos no pueden estar vacios.</p>
            <?php else: ?>
                <?php
                if (($esEstudiante === "si") || ($edad < 12)) {
                    $costo = 160;
                } elseif (($esEstudiante === "si") && ($edad >= 12)) {
                    $costo = 180;
                } else {
                    $costo = 300;
                }
                ?>
            <p class="resultado">El costo de su entrada es de $<?php echo $costo ?></p>
            <?php endif ?>
            <a href="/tp1/ejercicio8.php" class="btn-volver">Volver atrás</a>
        </div>
    </main>
</body>

</html>