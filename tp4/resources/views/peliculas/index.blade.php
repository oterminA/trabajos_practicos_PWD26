@extends('layouts.peliculas', ['title' => $titulo])

@section('content')
    <h1>{{ $titulo }}</h1>
    <form action="{{ route('peliculas.buscar') }}" method="get">
        <input type="search" name="buscar" id="buscar" placeholder="Buscar película por su título exacto"
            style="width: 300px;">
        <button type="submit" class="boton btn btn-outline-light">Buscar</button>
    </form>
    <hr>
    <nav>
        {{-- <a class="boton {{ $activeFilter === 'todas' ? 'activo' : '' }}" href="{{ route('peliculas.index') }}">Todas</a> --}}

        {{-- <a class="boton {{ $activeFilter === 'ciencia-ficcion' ? 'activo' : '' }}"
            href="{{ route('peliculas.ciencia-ficcion') }}">Ciencia ficcion</a> --}}

        <a class="boton" href="{{ route('peliculas.create') }}">+ Agregar pelicula</a>
    </nav>

    <form action="{{ route('peliculas.index') }}" method="get" id="formGenero">
        @csrf

        <!-- puse get porque con post no funcionaba -->
        <input type="hidden" name="action" value="mostrarGeneros">
        <!-- eso tengo que ponerlo así porque si lo meto en el index no funciona la parte del js -->
        <select class="btn btn-outline-light boton" name="genero" id="selectGenero" onchange="this.form.submit()">
            <option value="" {{ request('genero') ? '' : 'selected' }}>Todos los géneros</option>
            @forelse ($generos as $gen)
                <option value="{{ $gen }}" {{ request('genero') === $gen ? 'selected' : '' }}>
                    {{ $gen }}
                </option>
            @empty
                <option disabled>No hay géneros para mostrar</option>
            @endforelse
        </select>
    </form>
    @push('scripts')
        <script src="{{ asset('js/js.js') }}"></script>
    @endpush


    @forelse ($peliculas as $pelicula)
        <article class="pelicula">
            <!-- reviso que exista una pelicula -->

            @if ($pelicula['titulo'] == '')
                <div class="alert alert-warning" role="alert">
                    Esa película no existe en el catálogo
                </div>
            @endif

            <!-- reviso que exista una imagen -->
            @if ($url = $modelo->urlImagen($pelicula['imagen']))
                <img class="poster" src="{{ $url }}" alt="Poster de {{ $pelicula['titulo'] }}">
            @else
                <div class="sin-imagen">Sin imagen</div>
            @endif

            <div>
                <h2>{{ $pelicula['titulo'] }}</h2>
                <p>{{ $pelicula['genero'] }} - {{ (int) $pelicula['anio'] }}</p>
                <a href="{{ route('peliculas.show', $pelicula['id']) }}">| Ver detalle |</a>
                <a href="{{ route('peliculas.edit', $pelicula['id']) }}">| Editar datos |</a>
                <form action="{{ route('peliculas.destroy', $pelicula['id']) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</button>
                </form>
            </div>
        </article>
    @empty
        <p>No hay peliculas para mostrar.</p>
    @endforelse
@endsection
