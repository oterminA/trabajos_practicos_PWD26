@extends('layouts.peliculas', ['title' => $pelicula ? $pelicula->titulo : 'Pelicula no encontrada'])

@section('content')
    {{-- esto es para mostrar los cartelitos cuando se agrega --}}
    @if (session('exitoResenia'))
        <div
            style="padding: 14px 20px; margin-bottom: 24px; color: #fdfdfd; background-color: #4e8d5d; border: 1px solid #c3e6cb; border-radius: 8px;">
            {{ session('exitoResenia') }}
        </div>
    @endif

    @if (session('edicion'))
        <div
            style="padding: 14px 20px; margin-bottom: 24px; color: #080808; background-color: #edf1ac; border: 1px solid #c3e6cb; border-radius: 8px;">
            {{ session('edicion') }}
        </div>
    @endif

    @if ($pelicula)
        @if ($url = $pelicula->urlImagen($pelicula->imagen))
            <img class="detalle-poster" src="{{ Storage::url($pelicula->imagen) }}" alt="Poster de {{ $pelicula->titulo }}">
        @endif

        <h2>{{ $pelicula->titulo }}</h2>
        <p><strong>Genero:</strong> {{ $pelicula->genero }}</p>
        <p><strong>Año:</strong> {{ (int) $pelicula->anio }}</p>
        <p><strong>Reparto:</strong></p>
        <ul>
            @foreach ($pelicula->actores as $actor)
                <li>{{ $actor->nombreFormateado }}</li>
            @endforeach
        </ul>
        <p><strong>Sinopsis:</strong></p>
        <p> <i>"{!! nl2br(e($pelicula->descripcion)) !!}"</i> </p>
    @else
        <h2>Pelicula no encontrada</h2>
    @endif
    <div class="d-grid gap-2 d-md-block d-md-flex justify-content-md-center">
        <a class="btn btn-outline-secondary" href="{{ route('resenias.create', $pelicula->id) }}">Dejar reseña</a>
        {{-- si paso el ID solamente, en el controlador tengo que usar findOrFail para obtener el objeto --}}
        <a class="btn btn-outline-secondary" href="{{ route('resenias.inicio', $pelicula->id) }}">Ver reseñas</a>
        <a class="btn btn-outline-secondary" href="{{ route('peliculas.index') }}">Volver al catálogo</a>
    </div>
    <br>

@endsection
