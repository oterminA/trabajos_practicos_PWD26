<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Películas</title>
    <style>
        body { font-family: Arial; max-width: 900px; margin: 40px auto; padding: 0 20px; }
        nav { display: flex; gap: 10px; margin-bottom: 25px; }
        .boton { padding: 9px 14px; border: 1px solid #bbb; border-radius: 6px; text-decoration: none; }
        article { border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin: 15px 0; display: flex; gap: 20px; align-items: center; }
        .poster, .sin { width: 120px; height: 170px; border-radius: 6px; flex: 0 0 120px; }
        .poster { object-fit: cover; }
        .sin { background: #eee; display: flex; align-items: center; justify-content: center; color: #777; }
        a { color: #2457a6; }
    </style>
</head>
<body>
    <h1>Catálogo de películas</h1>

    <nav>
        <a class="boton" href="index.php?action=listar">Todas</a>
        <a class="boton" href="index.php?action=cienciaFiccion">Ciencia ficción</a>
        <a class="boton" href="index.php?action=nueva">+ Agregar película</a>
    </nav>

    <?php foreach ($peliculas as $pelicula): ?>
        <article>
            <?php if (!empty($pelicula['imagen'])): ?>
                <img
                    class="poster"
                    src="uploads/<?= htmlspecialchars($pelicula['imagen']) ?>"
                    alt="Poster de <?= htmlspecialchars($pelicula['titulo']) ?>"
                >
            <?php else: ?>
                <div class="sin">Sin imagen</div>
            <?php endif; ?>

            <div>
                <h2><?= htmlspecialchars($pelicula['titulo']) ?></h2>
                <p><?= htmlspecialchars($pelicula['genero']) ?> · <?= (int) $pelicula['anio'] ?></p>
                <a href="index.php?action=detalle&id=<?= (int) $pelicula['id'] ?>">Ver detalle</a>
                <a href="index.php?action=mostrarDatosEdicion&id=<?= (int) $pelicula['id'] ?>">Editar datos</a>

            </div>
        </article>
    <?php endforeach; ?>
</body>
</html>
