<!-- Ejercicio 8
La empresa de Cine Cinem@s tiene establecidas diferentes tarifas para las entradas, en
función de la edad y de la condición de estudiante del cliente. Desea que sean los propios
clientes los que puedan calcular el valor de sus entradas a través de una página web. Si
es estudiante o menor de 12 años el precio es de $160, si es estudiante y mayor o igual
de 12 años el precio es de $180, en cualquier otro caso el precio es de $300. Diseñar un
formulario que solicite la edad y permita ingresar si se trata de un estudiante o no. Con
un botón enviar los datos a un script encargado de realizar el cálculo y visualizarlo.
Agregar un botón para limpiar el formulario y volver a consultar. -->
    <link rel="stylesheet" href="/css/style.css">
    <title>Ejercicio 8</title>

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>

    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Ejercicio n° 8</h1>
            <h2>Autogestión del costo de las entradas para el cine</h2>
            <form action="cine.php" method="POST" class="form-contenedor">
                <label for="">Ingrese su edad</label>
                <input type="number" required name="edad">
                <label>¿Es estudiante?</label>
                <label for="">Si</label>
                <input type="radio" name="rta" value="si" required>
                <label for="">No</label>
                <input type="radio" name="rta" value="no" required>

                <button type="reset" class="btn-borrar">Limpiar campos</button>
                <button type="submit" class="btn-enviar">Ver costo de entrada</button>
                <a href="/tp1/inicio_tp1.php" class="btn-volver">Volver al índice de ejercicios</a>
            </form>

        </div>
    </main>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

</body>

</html>