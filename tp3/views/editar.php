<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Editar película</title>
    <style>
        body {
            font-family: Arial;
            max-width: 700px;
            margin: 40px auto;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 8px;
            margin-top: 5px;
        }

        textarea {
            min-height: 100px;
        }

        .errores {
            background: #fee;
            border: 1px solid #d88;
            padding: 12px 18px;
        }

        button {
            margin-top: 20px;
            padding: 10px 18px;
        }

        .poster {
            max-width: 250px;
            max-height: 360px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <h1>Editar película</h1>

    <?php if (!empty($errores)): ?>
        <div class="errores">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($pelicula): ?>
        <form action="index.php?action=guardarDatosEditados" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= (int) $pelicula['id']?>">
            <label>Título(opcional)</label>
            <input name="titulo" value="<?= htmlspecialchars($pelicula['titulo']) ?>">

            <label>Género(opcional)</label>
            <input name="genero" value="<?= htmlspecialchars($pelicula['genero']) ?>">

            <label>Año(opcional)</label>
            <input
                type="number"
                name="anio"
                min="1895"
                max="<?= (int) date('Y') + 5 ?>"
                value="<?= htmlspecialchars((string) ($pelicula['anio'])) ?>">

            <label>Descripción(opcional)</label>
            <textarea name="descripcion"><?= htmlspecialchars($pelicula['descripcion']) ?></textarea>

            <label>Imagen(opcional)</label>
            <?php if (!empty($pelicula['imagen'])): ?>
                <img
                    class="poster"
                    src="uploads/<?= htmlspecialchars($pelicula['imagen']) ?>"
                    alt="Poster de <?= htmlspecialchars($pelicula['titulo']) ?>">
            <?php endif; ?>
            <input type="file" name="imagen" accept="image/jpeg,image/png,image/webp">
            <small>JPG, PNG o WEBP. Máximo 2 MB.</small>

            <button type="submit">Guardar película</button>
        </form>


    <?php endif; ?>



    <p><a href="index.php?action=listar">← Cancelar</a></p>
</body>

</html>