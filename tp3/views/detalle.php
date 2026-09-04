<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Detalle</title>
    <style>
        body { font-family: Arial; max-width: 750px; margin: 40px auto; }
        .poster { max-width: 250px; max-height: 360px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>
    <?php if ($pelicula): ?>
        <?php if (!empty($pelicula['imagen'])): ?>
            <img
                class="poster"
                src="uploads/<?= htmlspecialchars($pelicula['imagen']) ?>"
                alt="Poster de <?= htmlspecialchars($pelicula['titulo']) ?>"
            >
        <?php endif; ?>

        <h1><?= htmlspecialchars($pelicula['titulo']) ?></h1>
        <p><strong>Género:</strong> <?= htmlspecialchars($pelicula['genero']) ?></p>
        <p><strong>Año:</strong> <?= (int) $pelicula['anio'] ?></p>
        <p><?= nl2br(htmlspecialchars($pelicula['descripcion'])) ?></p>
    <?php else: ?>
        <h1>Película no encontrada</h1>
    <?php endif; ?>

    <p><a href="index.php?action=listar">← Volver</a></p>
</body>
</html>
