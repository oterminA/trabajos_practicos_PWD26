@extends('layouts.peliculas', ['title' => 'Nueva reseña'])
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/libros.css') }}">
@endpush
@section('content')
    <h2>Nueva reseña de {{$libro->titulo}}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reseniasLibros.store', $libro->id) }}" method="POST" >
        @csrf

        <label for="nombreUsuario">Nombre de usuario</label>
        <input type="text" id="nombreUsuario" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required maxlength="50">

        <label for="comentario">Comentario(en 1000 caracteres)</label>
        <textarea id="comentario" name="comentario" {{ old('comentario') }} required maxlength="1000"></textarea>

        <label for="puntaje">Puntaje(1 a 5)</label>
        <input id="puntaje" type="number" name="puntaje" min="1" max="5" value="{{ old('puntaje') }}"
            required>

        <button class="btn btn-outline-secondary" type="submit">Guardar Reseña</button>
    </form>

    <a class="btn btn-outline-secondary" href="{{ route('libros.show', $libro->id) }}">Cancelar</a>
@endsection
