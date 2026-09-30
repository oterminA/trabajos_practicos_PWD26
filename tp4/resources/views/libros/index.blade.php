@extends('layouts.peliculas', ['title' => $titulo])
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/libros.css') }}">
@endpush
@section('content')
    <h2 class="display-5 text-center">{{ $titulo }}</h2>
    <div class="nav">

        <form action="{{ route('libros.buscar') }}" method="get">
            <input type="search" name="buscar" id="buscar" placeholder="Buscar libro por su título exacto">
            <button type="submit" class="boton btn btn-outline-light">Buscar</button>
        </form>

        <form action="{{ route('libros.index') }}" method="get" id="formAutor">
            <input type="hidden" name="action" value="mostrarAutor">
            <select class=" boton" name="autor" id="selectAutor" onchange="this.form.submit()">
                <option value="" {{ request('autor') ? '' : 'selected' }}>Todos los autores</option>
                @forelse ($autores as $autor)
                    <option value="{{ $autor }}" {{ request('autor') === $autor ? 'selected' : '' }}>
                        {{ $autor }}
                    </option>
                @empty
                    <option disabled>No hay autores para mostrar</option>
                @endforelse
            </select>
        </form>

        <form action="{{ route('libros.inicio') }}" method="get" id="formGenero">
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
        <a class="boton" href="{{ route('libros.create') }}">Agregar libro</a>
    </div>

    {{-- asi se ponen los bloques de codigo de js en blade, podria pasarlo a un js aparte pero no lo hice xd --}}
    @push('scripts')
        <script src="{{ asset('js/js.js') }}"></script>
    @endpush
    <hr>

    @forelse ($libros as $libro)
        <article class="pelicula">
            @if (empty($libro['titulo']))
                <div class="alert alert-warning" role="alert">
                    Ese libro no existe en el catálogo
                </div>
            @endif

            @if (!empty($libro['imagen']) && isset($modelo) && ($url = $modelo->urlImagen($libro['imagen'])))
                <img class="poster" src="{{ $url }}" alt="Poster de {{ $libro['titulo'] }}">
            @else
                <div class="sin-imagen">Sin imagen</div>
            @endif

            <div>
                <h3>{{ $libro['titulo'] }}</h3>
                <p>{{ $libro['genero'] }} - {{ (int) $libro['anio'] }}</p>

                <div class="d-grid gap-2 d-md-block d-md-flex justify-content-md-end">
                    <a href="{{ route('libros.show', $libro['id']) }}">| Ver detalle |</a>
                    <a href="{{ route('libros.edit', $libro['id']) }}">| Editar datos |</a>

                    <form action="{{ route('libros.delete', $libro['id']) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro de eliminar este libro?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">| Eliminar |</button>
                    </form>
                </div>

            </div>
        </article>
    @empty
        <p>No hay libros para mostrar.</p>
    @endforelse
@endsection
