<!-- Ejercicio 2
Diseñar un formulario que permita cargar las películas de la empresa Cinem@s. La lista de géneros
tiene los siguientes datos: Comedia, Drama, Terror, Románticas, Suspenso, Otras.-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="/css/style.css">

<body>
    <?php include_once(__DIR__ . '/../estructura/header.php'); ?>
    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-header bg-light border-bottom text-info fw-bold fs-5">
                <i class="bi bi-pencil-square me-2"></i>Cinem@s
            </div>
            <div class="card-body p-4">
                <form action="cinema.php" method="POST" class="row g-3" onsubmit="return validarAnio()">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Titulo</label>
                        <input type="text" class="form-control" placeholder="Titulo" name="titulo" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Actores</label>
                        <input type="text" class="form-control" placeholder="Actores" name="actores" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Director</label>
                        <input type="text" class="form-control" placeholder="Director" name="director" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Guión</label>
                        <input type="text" class="form-control" placeholder="Guión" name="guion" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Producción</label>
                        <input type="text" class="form-control" placeholder="Producción" name="produccion" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Año</label>
                        <input type="number" class="form-control anio" placeholder="Año" name="anio" maxlength="4">
                        <p class="error"></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Nacionalidad</label>
                        <input type="text" class="form-control" placeholder="Nacionalidad" name="nacionalidad" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-secondary">Género</label>

                        <select class="form-select row-md-6" required name="genero">
                            <option selected value="comedia">Comedia</option>
                            <option value="terror">Terror</option>
                            <option value="romantica">Romantica</option>
                            <option value="suspenso">Suspenso</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-secondary">Duración</label>
                        <input type="number" class="form-control" placeholder="Duracion" name="duracion" maxlength="3" required>
                        <p class="text-secondary">(minutos)</p>
                    </div>
                    <div class="col-md-8">
                        <p class="fw-bold text-secondary">Restricciones de edad</p>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="restriccion" value="todos" checked required ">
                            <label class="form-check-label">
                                Todo público
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="restriccion" value="may7" required>
                            <label class="form-check-label">
                                Mayores de 7 años
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="restriccion" value="may18" required>
                            <label class="form-check-label">
                                Mayores de 18 años
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold text-secondary">Sinopsis</label>
                        <textarea class="form-control" rows="3" required name="sinopsis"></textarea>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
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

    <?php include_once(__DIR__ . '/../estructura/footer.php'); ?>
<script src="../js/verificaciones.js"></script>
</body>

</html>