<!-- Ejercicio 1
a) Crear una nueva página php con un formulario HTML de login en la que solicitan el usuario y la
password para loguearse. Los datos del formulario son enviados a un script verificaPass.php en el que
contienen un arreglo asociativo por cada usuario del sistema. El arreglo asociativo tiene como claves:
“usuario” y “clave”. El script debe visualizar un mensaje de bienvenida si los datos ingresados
coinciden con alguno de los almacenados en el arreglo y en caso contrario un mensaje de error.-->
<link rel="stylesheet" href="/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="/css/style.css>
<title>Ejercicio 1</title>

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>
    <main class="contenedor-main">
        <div class="contenedor">
            <h1>Ejercicio n° </h1>
            <h2>Inicio de sesión</h2>
            <form action="mostrardatos.php" method="POST" class="form-contenedor">
            <a href="/tp1/inicio_tp1.php" class="btn-volver">Volver al índice de ejercicios</a>
            </form>
        </div>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

</body>

</html>