<!-- Ejercicio 1
Confeccionar un formulario que solicite un número. Al pulsar el botón de enviar debe
llamar a un script –vernumero.php- y visualizar un mensaje que indique si el número
enviado fue: positivo, cero o negativo. Añadir un link, a la página que visualiza la
respuesta, que permita volver a la página anterior. -->
    <link rel="stylesheet" href="/css/style.css">
    <title>Ejercicio 1</title>

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>

    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Ejercicio n° 1</h1>
            <form action="vernumero.php" method="GET" class="form-contenedor">
                <label for="">Ingresá un numero</label>
                <input type="number" name="numero" value="Ej: 5" required>
                <button type="reset" class="btn-borrar">Limpiar campo</button>
                <button type="submit" class="btn-enviar">Consultar numero</button>
            <a href="/tp1/inicio_tp1.php" class="btn-volver"  >Volver al índice de ejercicios</a>
            </form>
        </div>
    </main>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

</body>

</html>