@extends('layouts.peliculas', ['title' => 'Editar libro'])
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/libros.css') }}">
@endpush
@section('content')
    <h2>Editar libro</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($libro)
        <form action="{{ route('libros.update', ['id' => $libro->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="titulo">Título(opcional)</label>
            <input id="titulo" name="titulo" value="{{ $libro->titulo }}" maxlength="120">

            <label for="autor">Autor/a(opcional)</label>
            <input id="autor" name="autor" value="{{ $libro->autor }}" maxlength="80">

            <label for="genero">Género(opcional)</label>
            <input id="genero" name="genero" value="{{ $libro->genero }}" maxlength="80">

            <label for="anio">Año(opcional)</label>
            <input id="anio" type="number" name="anio" min="1895" max="{{ $maxYear }}"
                value="{{ $libro->anio }}">

            <label for="sinopsis">Sinopsis(opcional)</label>
            <textarea id="sinopsis" name="sinopsis" maxlength="1000">{{ $libro->sinopsis }}</textarea>

            <label for="imagen">Imagen(opcional)</label>
            @if (!empty($libro->imagen))
                <img class="poster" src="{{ Storage::url($libro->imagen) }}" alt="Póster de {{ $libro->imagen }}">
            @else
                <div class="sin-imagen">Sin imagen</div>
            @endif

            <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp">
            <small>JPG, PNG o WEBP. Maximo 300KB.</small>

            <button class="btn btn-outline-secondary" type="submit">Guardar libro</button>
        </form>
    @endif
    <a class="btn btn-outline-secondary" href="{{ route('libros.index') }}">Cancelar</a>
@endsection
