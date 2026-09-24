<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>{{ $title ?? 'Peliculas' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
            color: #222;
            min-height: 100vh;
        }

        article {
            box-shadow: 5px 5px 15px 0px rgba(0, 0, 0, 0.20);
            border-radius: 8px;
        }

        nav {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 25px;
        }

        a,
        button {
            text-decoration: none;
            color: brown;
        }

        .boton {
            padding: 9px 14px;
            border: 1px solid #bbb;
            border-radius: 6px;
            text-decoration: none;
            background: #fff;
            color: brown;
        }

        .boton.activo {
            border-color: #2457a6;
            background: #eef4ff;
        }

        .pelicula {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin: 15px 0;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .poster,
        .sin-imagen {
            width: 120px;
            height: 170px;
            border-radius: 6px;
            flex: 0 0 120px;
        }

        .poster {
            object-fit: cover;
        }

        .sin-imagen {
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: brown;
            text-align: center;
        }

        .detalle-poster {
            max-width: 250px;
            max-height: 360px;
            object-fit: cover;
            border-radius: 8px;
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
            border-radius: 6px;
        }

        button {
            background-color: white;
            cursor: pointer;
            border: none
        }

        .btn {
            margin: 5px;
        }

        small {
            display: block;
            margin-top: 6px;
            color: #555;
        }

        .card-footer,
        .navbar {
            background-color: brown;
            color: white;
        }

        .card-footer {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg ">
            <div class="container-fluid d-flex justify-content-center align-items-center"">
                <h1 class="display-3">
                    <a class="nav-link text-center fst-italic" href="{{ route('peliculas.index') }}">🎬 peliculandia
                        🎬</a>
                </h1>

            </div>
        </nav>
    </header>

    @yield('content')

    <footer class="card-footer text-center">
        <p class="mb-0">Laravel | Blade | HTML | CSS | JS | PHP | Bootstrap</p>
    </footer>
</body>

</html>
