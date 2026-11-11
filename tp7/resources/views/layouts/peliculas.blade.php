<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- esto lo tuve q poner para el ajax del modal en resenia create --}}

    {{-- paso 1 para usar tom select como libreria --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

    {{-- este es el css q quiero mantener para toda la pagina --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
    <title>{{ $title ?? '' }}</title>
</head>

<body>
    {{-- el header y footer son las cosas que se repiten en todas las paginas, por eso están en el layout --}}
    <header class="mb-4">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false" id="sesionBoton">
                        👤
                    </a>
                    <ul class="dropdown-menu">
                        {{-- esto es para mostrar un cartel con el nombre del usuario asi ya sé quien es xd, para eso uso el helper @auth que sabe q el user está disponible globalmente en las vistas de la app --}}
                        @auth
                            <li>
                                <span class="dropdown-item-text">
                                    <strong><i>Hola, {{ auth()->user()->user }}!</i></strong>
                                </span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('users.logout') }}">Cerrar sesión</a></li>
                        @endauth

                        @guest
                            <li><a class="dropdown-item" href="{{ route('login') }}">Iniciar sesión</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.create') }}">Registrarse</a></li>
                        @endguest
                    </ul>
            </ul>
            </li>
            </ul>

        </div>

        <nav class="navbar">
            <div class="container-fluid d-flex flex-column align-items-center text-center">

                <h1 class="text-center fst-italic display-3">peliculandia</h1>

                <ul class="navbar-nav d-flex flex-row justify-content-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link active text-light fw-bold" href="{{ route('peliculas.index') }}">Catálogo</a>
                    </li>
                </ul>

            </div>
        </nav>
    </header>

    {{-- esto es para armar el estilo del chatbot --}}
    <div id="chat-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
        <button id="chat-toggle" class="btn btn-secondary rounded-circle shadow">🗯️</button>

        <div id="chat-box" class="card shadow"
            style="display: none; width: 350px; height: 450px; flex-direction: column;">
            <div class="card-header bg-danger text-white d-flex justify-content-between">
                <span>PeliBot</span>
                <button id="chat-close" class="btn-close btn-close-white"></button>
            </div>
            <div id="chat-mensajes" class="card-body overflow-auto flex-grow-1" style="font-size: 0.9rem;">
                <p class="text-muted">¡Hola! Soy <i><strong>PeliBot</strong></i> y tengo las respuestas del universo...</p>
                <p class="text-muted"> ...En realidad solo tengo respuestas programadas pero ¿En qué te ayudo?</p>
            </div>
            <div class="card-footer p-2">
                <form id="chat-form" class="d-flex">
                    <input type="text" id="chat-input" class="form-control form-control-sm me-1"
                        placeholder="Escribí tu consulta..." required>
                    <button type="submit" class="btn btn-sm btn-secondary">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    {{-- aca va a ir todo el contenido de las demás páginas --}}
    @yield('content')

    <footer class="card-footer text-center">
        <p class="mb-0">Laravel | Blade | HTML | CSS | JS | PHP | Bootstrap | Eloquent | SweetAlert2 | Tom Select |
            ChatBot</p>
    </footer>

    <!-- Bootstrap JS Bundle xra dropdowns y modales -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- para los modales --}}

    <!-- paso 1 cargo la libreria-->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <!-- y cargo el js donde voy a subir las cosas -->
    <script src="{{ asset('js/js.js') }}"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>
</body>

</html>
