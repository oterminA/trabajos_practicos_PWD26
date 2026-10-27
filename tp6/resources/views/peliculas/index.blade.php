@extends('layouts.peliculas', ['title' => $titulo])
{{-- asi se ponen los bloques de codigo de js en blade, podria pasarlo a un js aparte pero no lo hice xd --}}
@push('scripts')
    <script src="{{ asset('js/js.js') }}"></script>
@endpush
@section('content')
    {{-- esto es para mostrar los cartelitos cuando se agrega --}}
    @if (session('exitoPelicula'))
        <div
            style="padding: 14px 20px; margin-bottom: 24px; color: #fdfdfd; background-color: #4e8d5d; border: 1px solid #c3e6cb; border-radius: 8px;">
            {{ session('exitoPelicula') }}
        </div>
    @endif

    @if (session('exitoActor'))
        <div
            style="padding: 14px 20px; margin-bottom: 24px; color: #fdfdfd; background-color: #4e8d5d; border: 1px solid #c3e6cb; border-radius: 8px;">
            {{ session('exitoActor') }}
        </div>
    @endif

    @if (session('deletedPelicula'))
        <div
            style="padding: 14px 20px; margin-bottom: 24px; color: #fdfdfd; background-color: #eb5b48; border: 1px solid #c3e6cb; border-radius: 8px;">
            {{ session('deletedPelicula') }}
        </div>
    @endif
    <h2 class="display-5 text-center">{{ $titulo }}</h2>
    <nav class="nav">

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
        <a class="boton" href="{{ route('actors.create') }}">Cargar actor</a>
         </nav>
        <form action="{{ route('peliculas.buscar') }}" method="get" id="formularioSearch">
            <input type="search" name="buscar" id="buscar" placeholder="Buscar película por su título">
            {{-- <button type="submit" class="boton btn btn-outline-light">Buscar</button> --}}
            <div id="mostrar-resultados"></div>
        </form>




    <hr>

    @forelse ($peliculas as $pelicula)
        <article class="pelicula">
            @if (empty($pelicula->titulo))
                <div class="alert alert-warning" role="alert">
                    Esa película no existe en el catálogo
                </div>
            @endif

            @if ($pelicula->imagen)
                <img class="poster" src="{{ Storage::url($pelicula->imagen) }}" alt="Poster de {{ $pelicula->titulo }}">
            @else
                <div class="sin-imagen">Sin imagen</div>
            @endif

            <div>
                <h3>{{ $pelicula->tituloFormateado }}</h3>
                <p>{{ $pelicula->genero }} </p>
                <p>Reseñas: {{ $pelicula->resenias_count }}</p>
                <p>Promedio de puntaje:
                    @if ($pelicula->promedioPuntaje == 0)
                        Sin calificaciones
                    @else
                        {{ $pelicula->promedioPuntaje }} ★
                    @endif
                </p>


                <div class="d-grid gap-2 d-md-block d-md-flex justify-content-md-end">
                    <a href="{{ route('peliculas.show', $pelicula->id) }}">| Ver detalle |</a>
                    <a href="{{ route('peliculas.edit', $pelicula->id) }}">| Editar datos |</a>

                    <form action="{{ route('peliculas.delete', $pelicula->id) }}" method="POST"
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
