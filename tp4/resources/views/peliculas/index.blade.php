@extends('layouts.peliculas', ['title' => $titulo])

@section('content')
    <h2 class="display-5 text-center">{{ $titulo }}</h2>

    <form action="{{ route('peliculas.buscar') }}" method="get">
        <input type="search" name="buscar" id="buscar" placeholder="Buscar película por su título exacto"
            style="width: 300px; border-radius: 5px;border: 1px solid rgb(201, 201, 201);">
        <button type="submit" class="boton btn btn-outline-light">Buscar</button>
    </form>

    <nav>
        <form action="{{ route('peliculas.index') }}" method="get" id="formGenero">
            <input type="hidden" name="action" value="mostrarGeneros">
            <select class=" boton" name="genero" id="selectGenero" onchange="this.form.submit()">
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
        <a class="boton" href="{{ route('peliculas.create') }}">Agregar pelicula</a>
    </nav>

    @push('scripts')
        <script src="{{ asset('js/js.js') }}"></script>
    @endpush
    <hr>

    @forelse ($peliculas as $pelicula)
        <article class="pelicula">
            @if (empty($pelicula['titulo']))
                <div class="alert alert-warning" role="alert">
                    Esa película no existe en el catálogo
                </div>
            @endif

            @if (!empty($pelicula['imagen']) && isset($modelo) && ($url = $modelo->urlImagen($pelicula['imagen'])))
                <img class="poster" src="{{ $url }}" alt="Poster de {{ $pelicula['titulo'] }}">
            @else
                <div class="sin-imagen">Sin imagen</div>
            @endif

            <div>
                <h3>{{ $pelicula['titulo'] }}</h3>
                <p>{{ $pelicula['genero'] }} - {{ (int) $pelicula['anio'] }}</p>

                <div class="d-grid gap-2 d-md-block d-md-flex justify-content-md-end">
                    <a href="{{ route('peliculas.show', $pelicula['id']) }}">| Ver detalle |</a>
                    <a href="{{ route('peliculas.edit', $pelicula['id']) }}">| Editar datos |</a>

                    <form action="{{ route('peliculas.delete', $pelicula['id']) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de eliminar esta película?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">| Eliminar |</button>
                    </form>
                </div>

            </div>
        </article>
    @empty
        <p>No hay peliculas para mostrar.</p>
    @endforelse
@endsection
