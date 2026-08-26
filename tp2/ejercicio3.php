<!-- Ejercicio 3
Crear un formulario HTML que permite subir un archivo. En el servidor se deberá controlar, antes de
guardar el archivo, que los tipos validos son .doc o pdf y además el tamaño máximo permitido es de
2mb. En caso que se cumplan las condiciones mostrar un link al archivo cargado, en caso contrario
mostrar un mensaje indicando el problema.-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="/css/style.css">

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>
    <div class="container my-4 w-auto h-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-light border-bottom text-primary fw-bold fs-5">
                <i class="bi bi-upload"></i> Subir archivo
            </div>
            <div class="card-body p-4">
                <form action="subirArchivo.php" method="POST" class="row g-3" onsubmit="return validarArchivo()" enctype="multipart/form-data">
                    <div class="mb-3">
                        <p class="fw-semibold text-center">Los tipos de archivos validos son '.doc' o '.pdf'</p>
                        <input class="form-control archivo" type="file" name="archivo" required accept=".pdf, application/pdf, .doc">
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