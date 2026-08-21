<!-- Ejercicio 2
Crear una página php que contenga un formulario HTML que permita ingresar las horas
de cursada, de la materia Programación Web Dinámica, por cada día de la semana.
Enviar los datos del formulario por el método Get a otra página php que los reciba y
complete un array unidimensional. Visualizar por pantalla la cantidad total de horas que
se cursan por semana. -->
    <link rel="stylesheet" href="/css/style.css">
    <title>Ejercicio 2</title>

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>

    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Ejercicio n° 2</h1>
            <h2>Ingresar las horas de cursada de PWD</h2>
            <form action="horascursada.php" method="GET" class="form-contenedor">
                <!-- <label for="">Nombre estudiante</label> -->
                <!-- <input type="text" required max="10" min="3" name="nombre"> -->
                <label for="">Lunes</label>
                <input type="number" required name="horasL" step="0.01">
                <label for="">Martes</label>
                <input type="number" required name="horasM" step="0.01">
                <label for="">Miércoles</label>
                <input type="number" required name="horasMi" step="0.01">
                <label for="">Jueves</label>
                <input type="number" required name="horasJ" step="0.01">
                <label for="">Viernes</label>
                <input type="number" required name="horasV" step="0.01"> 
                <button type="reset" class="btn-borrar">Limpiar campos</button>
                <button type="submit" class="btn-enviar">Enviar</button>
            <a href="/tp1/inicio_tp1.php" class="btn-volver"  >Volver al índice de ejercicios</a>
            </form>

        </div>
    </main>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

</body>

</html>