<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Películas</title>
    <style>
        body {
            font-family: Arial;
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        nav {
            display: flex;
            gap: 10px;
        }

        .boton,
        .btn,
        #buscar {
            padding: 9px;
            border: 1px solid #bbb;
            border-radius: 6px;
            text-decoration: none;
        }

        article {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin: 15px 0;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .poster,
        .sin {
            width: 120px;
            height: 170px;
            border-radius: 6px;
            flex: 0 0 120px;
        }

        .poster {
            object-fit: cover;
        }

        .sin {
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #777;
        }

        a,
        .btn {
            color: #2457a6;
            text-decoration: none;
        }

    </style>
</head>

<body>
    <h1>Catálogo de películas</h1>
    <form action="index.php?action=buscar" method="POST">
        <input type="search" name="buscar" id="buscar" placeholder="Buscar película por su título exacto" style="width: 300px;">
        <button type="submit" class="boton btn btn-outline-light">Buscar</button>
    </form>
    <hr>
    <nav>
        <a class="btn btn-outline-light" href="index.php?action=nueva">+ Agregar película</a>

        <form action="index.php" method="GET" id="formGenero">
            <!-- puse get porque con post no funcionaba -->
            <input type="hidden" name="action" value="mostrarGeneros">
            <!-- eso tengo que ponerlo así porque si lo meto en el index no funciona la parte del js -->
            <select class="btn btn-outline-light boton" name="genero" id="selectGenero">
                <option value="" selected>Todos los géneros</option>
                <?php foreach ($generos as $gen): ?>
                    <!-- $generos lo traigo desde la funcion que es llamada en mostrarGeneros y el submit se hace desde el js porque no queria poner el boton de filtrar porque se veia raro -->
                    <!-- me habia olvidado de revisar que si no se apretaba ningun genero en especifico igual se muestren todos en todos los generos -->
                    <option value="<?= htmlspecialchars($gen) ?>" <?= (isset($_GET['genero']) && $_GET['genero'] === $gen) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($gen) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </nav>


    <?php foreach ($peliculas as $pelicula): ?>
        <article>
            <!-- reviso que exista una pelicula -->
            <?php if ($pelicula['titulo'] == ''): ?>
                <div class="alert alert-warning" role="alert">
                    Esa película no existe en el catálogo
                </div>

            <?php else: ?>
                <!-- se revisa que exista una imagen -->
                <?php if (!empty($pelicula['imagen'])): ?>
                    <img
                        class="poster"
                        src="uploads/<?= htmlspecialchars($pelicula['imagen']) ?>"
                        alt="Poster de <?= htmlspecialchars($pelicula['titulo']) ?>">
                <?php else: ?>
                    <div class="sin">Sin imagen</div>
                <?php endif; ?>

                <div>
                    <h2><?= htmlspecialchars($pelicula['titulo']) ?></h2>
                    <p><?= htmlspecialchars($pelicula['genero']) ?> · <?= (int) $pelicula['anio'] ?></p>
                    <a href="index.php?action=detalle&id=<?= (int) $pelicula['id'] ?>">| Ver detalle |</a>
                    <a href="index.php?action=mostrarDatosEdicion&id=<?= (int) $pelicula['id'] ?>">| Editar datos |</a>
                    <a href="index.php?action=borrar&id=<?= (int) $pelicula['id'] ?>" onclick="return confirm('¿Estás seguro de que querés eliminar esta película?');">| Borrar |</a>
                    <!-- no sé si está bien hacer así lo del alert -->
                </div>
            <?php endif; ?>

        </article>
    <?php endforeach; ?>
    <p><a href="/index.php">← Volver a inicio</a></p>


    <!-- ESTO TENDRIA QUE IR APARTE PERO TENGO QUE HACER OTRO SCRIPT PORQUE TIRA ERROR POR LAS VARIABLES DECLARADAS EN OTROS ARCHIVOS Y QUE NO ESTÁN ACÁ -->
    <script>
        // recupero las variables que voy a necesitar
        let select = document.querySelector("#selectGenero");
        let formulario = document.querySelector("#formGenero");

        select.addEventListener('change', function() {
            // cuando el select cambie se hace submit en el formulario que seria lo mismo que poner un button type=submit pero se hace acá para poder hacer lo que me parece mejor a mi
            formulario.submit();
        });
    </script>
</body>

</html>