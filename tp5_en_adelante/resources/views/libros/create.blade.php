@extends('layouts.peliculas', ['title' => 'Nuevo libro'])
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/libros.css') }}">
@endpush
@section('content')
    <h2>Nuevo libro</h2>

    {{-- acá se muestran los errores que entiendo yo tira laravel co los formularios por ejemplo, cuando no se cumple con lo del validate --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('libros.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="titulo">Título</label>
        <input id="titulo" name="titulo" value="{{ old('titulo') }}" required maxlength="120">

        <label for="autor">Autor/a</label>
        <input id="autor" name="autor" value="{{ old('autor') }}" required maxlength="100">

        <label for="genero">Género</label>
        <input id="genero" name="genero" value="{{ old('genero') }}" required maxlength="80">

        <label for="anio">Año</label>
        <input id="anio" type="number" name="anio" min="1895" max="{{ $maxYear }}"
            value="{{ old('anio') }}" required>

        <label for="descripcion">Sinopsis</label>
        <textarea id="descripcion" name="sinopsis" required maxlength="1000">{{ old('sinopsis') }}</textarea>

        <label for="imagen">Imagen</label>
        <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp" required>
        <small>JPG, PNG o WEBP. Maximo 300 KB.</small>

        <button class="btn btn-outline-secondary" type="submit">Guardar libro</button>
    </form>

    <a class="btn btn-outline-secondary" href="{{ route('libros.index') }}">Cancelar</a>

@endsection
