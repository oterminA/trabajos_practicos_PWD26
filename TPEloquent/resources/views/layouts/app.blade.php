<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Eventia')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/eventia.css') }}">
</head>

<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="{{ route('actividades.index') }}" aria-label="Eventia, inicio">
                <span class="brand-mark">E</span><span>eventia</span>
            </a>
            <nav aria-label="Navegación principal">
                <form action="{{ route('actividades.search') }}" method="get">
                    <input type="search" name="buscar" id="buscar" placeholder="Buscar actividad">
                    <button type="submit" class="boton btn btn-outline-light">Buscar</button>
                </form>

                <form action="{{ route('actividades.index') }}" method="get" id="formEstado">
                    <input type="hidden" name="action" value="mostrarEstado">
                    <select class=" boton" name="estado" id="selectEstado" onchange="this.form.submit()">
                        </option>
                        {{-- para no hardcodear los estados sino mostrarlos dinamicamente desde lo que se tiene en la bd --}}
                        @forelse ($estados as $estado)
                            <option value="{{ $estado }}" {{ request('estado') === $estado ? 'selected' : '' }}>
                                {{ $estado }}
                            </option>
                        @empty
                            <option disabled>No hay estados para mostrar</option>
                        @endforelse
                    </select>
                </form>

                <a class="nav-link" href="{{ route('actividades.index') }}"> Actividades </a>
                <a class="nav-link" href="{{ route('actividades.create') }}"> Agregar </a>
            </nav>
        </div>
    </header>
    <main>@yield('content')</main>
    <footer class="site-footer">
        <div class="container">Eventia · Proyecto educativo con Laravel y Eloquent</div>
    </footer>

    @push('scripts')
        <script src="{{ asset('js/js.js') }}"></script>
    @endpush
</body>

</html>
