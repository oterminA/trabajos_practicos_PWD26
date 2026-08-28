<!-- Ejercicio 4
Crear un formulario que permita subir un archivo. En el servidor se deberá controlar que el tipo
esperado sea txt (texto plano), si es correcto deberá abrir el archivo y mostrar su contenido en un
textarea-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="/css/style.css">

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>
    <div class="container my-4 w-auto h-auto">
        <div class="card shadow-sm">
            <div class="card-header ">
                <h1>Ejercicio n° 4</h1>
            </div>
            <div class="card-body p-4">
                <div>
                    <h4 class="text-warning fw-bold fs-5"><i class="bi bi-upload"></i> Subir archivo</h4>

                </div>

                <form action="subirTextoPlano.php" method="POST" class="row g-3" onsubmit="return validarArchivo()" enctype="multipart/form-data">
                    <div class="mb-3">
                        <p class="fw-semibold">El archivo tiene que ser un texto plano '.txt'</p>
                        <input class="form-control archivo" type="file" name="archivo" required accept=".txt, text/plain">
                        <!-- si pongo el accept es necesario validar con js que sea ese formato? -->
                    </div>
                    <p class="error text-center"></p>
                    
                    <div class=" d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="submit" class="btn btn-info boton">Enviar</button>
                        <button type="reset" class="btn btn-light">Borrar</button>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="/tp2/inicio_tp2.php" class="btn btn-secondary">Volver</a>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>

    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>
    <script src="../js/verificaciones.js"></script>
</body>

</html>