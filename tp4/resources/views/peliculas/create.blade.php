@extends('layouts.peliculas', ['title' => 'Nueva pelicula'])

@section('content')
    <h2>Nueva pelicula</h1>

    @if ($errors->any())
        <div class="errores">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('peliculas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="titulo">Título</label>
        <input id="titulo" name="titulo" value="{{ old('titulo') }}" required maxlength="120">

        <label for="genero">Género</label>
        <input id="genero" name="genero" value="{{ old('genero') }}" required maxlength="80">

        <label for="anio">Año</label>
        <input
            id="anio"
            type="number"
            name="anio"
            min="1895"
            max="{{ $maxYear }}"
            value="{{ old('anio') }}"
            required
        >

        <label for="descripcion">Descripcion</label>
        <textarea id="descripcion" name="descripcion" required maxlength="1000">{{ old('descripcion') }}</textarea>

        <label for="imagen">Imagen</label>
        <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp" required>
        <small>JPG, PNG o WEBP. Maximo 300 KB.</small>

        <button class="btn btn-outline-secondary" type="submit">Guardar pelicula</button>
    </form>

    <a class="btn btn-outline-secondary" href="{{ route('peliculas.index') }}">Cancelar</a>

@endsection
