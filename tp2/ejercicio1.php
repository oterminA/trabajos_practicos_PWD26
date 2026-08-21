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

     <main class=" contenedor-main">
<div class="contenedor">
    <h1>Ejercicio n° 1</h1>
    <h2>Iniciar sesión</h2>
    <form action="verificaPass.php" method="POST" class="form-contenedor" onclick="return noRepetir()">

        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Usuario</label>
            <input type="text" class="form-control usuario" id="exampleFormControlInput1" name="usuario" required pattern="[a-z]{3,10}" minlength="3" maxlength="10">
        </div>

        <div class="mb-3">
            <label for="inputPassword6" class="col-form-label">Contraseña</label>
            <input type="password" id="inputPassword6" class="form-control clave" aria-describedby="passwordHelpInline" name="clave" required minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
        </div>

        <span class="form-text">
            <p class="text-danger pVista"></p>
        </span>

        <button type="submit" class="btn btn-success boton">Ingresar</button>
        <button type="reset" class="btn btn-danger">Limpiar campos</button>
        <a href="/tp2/inicio_tp2.php" class="btn-volver">Volver al índice de ejercicios</a>
    </form>
</div>
</main>
<?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

<script src="../js/verificaciones.js"></script>
</body>

</html>