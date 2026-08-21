<?php
$suma = 0; //variable inicializada en cero
$arregloDias = $_GET; //el arreglo que llega por post lo recupero acá como para hacerlo más ordenado
foreach ($arregloDias as $dia => $horas) { //recorro el arreglo para sumar las horas
    $suma = $suma + $horas;
}
?>
    <link rel="stylesheet" href="/css/style.css">
    <title>Resolucion ejercicio 2</title>

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>

    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Resolucion</h1>
                <p class="resultado">La cantidad de horas en las que cursa Programación Web Dinámica son: <?php echo $suma ?> hora(s).</p>
            <a href="/tp1/ejercicio2.php" class="btn-volver"  >Volver atrás</a>
        </div>
    </main>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

</body>

</html>