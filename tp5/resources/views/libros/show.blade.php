@extends('layouts.peliculas', ['title' => $libro ? $libro['titulo'] : 'Libro no encontrado'])
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/libros.css') }}">
@endpush
@section('content')
        @if ($libro)
            @if ($url = $libro->urlImagen($libro->imagen))
                <img class="detalle-poster" src="{{ Storage::url($libro->imagen) }}" alt="Poster de {{ $libro->titulo}}">
            @endif

            <h2>{{ $libro->titulo }}</h2>
            <p><strong>Autor/a:</strong> {{ $libro->autor}}</p>
            <p><strong>Genero:</strong> {{ $libro->genero }}</p>
            <p><strong>Año:</strong> {{ (int) $libro->anio }}</p>
            <p><strong>Sinopsis:</strong></p>
            <p> <i>"{!! nl2br(e($libro->sinopsis)) !!}"</i> </p>
        @else
            <h2>Libro no encontrado</h2>
        @endif
        <div class="d-grid gap-2 d-md-block d-md-flex justify-content-md-center">
            <a class="btn btn-outline-secondary" href="{{ route('reseniasLibros.create', $libro->id) }}">Dejar reseña</a>
            {{-- si paso el ID solamente, en el controlador tengo que usar findOrFail para obtener el objeto --}}
            <a class="btn btn-outline-secondary" href="{{ route('reseniasLibros.inicio', $libro->id) }}">Ver reseñas</a>
            <a class="btn btn-outline-secondary" href="{{ route('libros.index') }}">Volver al catálogo</a>
        </div>
        <br>

@endsection
