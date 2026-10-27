<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    {{-- paso 1 para usar tom select como libreria --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    {{-- este es el css q quiero mantener para toda la pagina --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
    <title>{{ $title ?? '' }}</title>
</head>

<body>
    {{-- el header y footer son las cosas que se repiten en todas las paginas, por eso están en el layout --}}
    <header>
        <nav class="navbar">
            <div class="container-fluid d-flex flex-column align-items-center text-center">

                <h1 class="text-center fst-italic display-3">peliculandia</h1>

                <ul class="navbar-nav d-flex flex-row justify-content-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link active text-light fw-bold"
                            href="{{ route('peliculas.index') }}">Peliculas</a>
                    </li>
                </ul>

            </div>
        </nav>
    </header>

    {{-- aca va a ir todo el contenido de las demás páginas --}}
    @yield('content')

    <footer class="card-footer text-center">
        <p class="mb-0">Laravel | Blade | HTML | CSS | JS | PHP | Bootstrap | Eloquent </p>
    </footer>

    <!-- paso 1 cargo la libreria-->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <!-- y cargo el js donde voy a subir las cosas -->
    <script src="{{ asset('js/js.js') }}"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
</body>

</html>
