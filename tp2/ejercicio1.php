<!-- Ejercicio 1
a) Crear una nueva página php con un formulario HTML de login en la que solicitan el usuario y la
password para loguearse. Los datos del formulario son enviados a un script verificaPass.php en el que
contienen un arreglo asociativo por cada usuario del sistema. El arreglo asociativo tiene como claves:
“usuario” y “clave”. El script debe visualizar un mensaje de bienvenida si los datos ingresados
coinciden con alguno de los almacenados en el arreglo y en caso contrario un mensaje de error.-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="/css/style.css">

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>

    <div class="container my-4 w-auto h-auto text-center">
        <div class="card">
            <div class="card-header">
                <h1>Ejercicio n° 1</h1>
            </div>
            <div class="card-body">
                <h2 data-bs-toggle="tooltip" title="Usuarios y claves: {caro!-01010101}, {usuario*-contrasen1a}, {mengano-mengano01}">Member login</h2>

                <form action="verificaPass.php" method="POST" onsubmit="return noRepetir()">
                    <div class="input-group mb-3">
                        <span class=" input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <input type="text" class="form-control usuario" id="exampleFormControlInput1" name="usuario" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{3,10}" minlength="3" maxlength="10" placeholder="Username">
                    </div>

                    <div class="input-group mb-3">
                        <span class=" input-group-text">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        <input type="password" id="inputPassword6" class="form-control clave" aria-describedby="passwordHelpInline" name="clave" required minlength="8" pattern="[A-Za-z0-9]" placeholder="Password">
                    </div>

                    <span class="form-text">
                        <p class="text-danger pVista"></p>
                    </span>

                    <div class=" d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="submit" class="btn btn-success boton">Login</button>
                        <button type="reset" class="btn btn-danger">Borrar</button>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="/tp2/inicio_tp2.php" class="btn btn-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>

    <script src="../js/verificaciones.js"></script>
</body>

</html>