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

        form {
            margin-top: 20px;
        }

        nav {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .boton,
        .btn,
        #buscar {
            padding: 9px 14px;
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
            margin: 5px;
        }
    </style>
</head>

<body>
    <h1>Catálogo de películas</h1>
    <form action="index.php?action=buscar" method="POST">
        <input type="search" name="buscar" id="buscar" placeholder="Buscar película por su título exacto" style="width: 300px;">
        <button type="submit" class="btn btn-outline-secondary">Buscar</button>
    </form>
    <hr>
    <nav>
        <a class="boton btn btn-outline-secondary" href="index.php?action=listar">Todas</a>
        <a class="boton btn btn-outline-secondary" href="index.php?action=cienciaFiccion">Ciencia ficción</a>
        <a class="boton btn btn-outline-secondary" href="index.php?action=nueva">+ Agregar película</a>
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
</body>

</html>