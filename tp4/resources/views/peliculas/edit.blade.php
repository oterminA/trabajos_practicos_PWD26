@extends('layouts.peliculas', ['title' => 'Editar pelicula'])

@section('content')
    <h2>Editar pelicula</h2>

    @if ($errors->any())
        <div class="errores">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($pelicula)
        <form action="{{ route('peliculas.update', ['id' => $pelicula['id']]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label for="titulo">Título(opcional)</label>
            <input id="titulo" name="titulo" value="{{ $pelicula['titulo'] }}" maxlength="120">

            <label for="genero">Género(opcional)</label>
            <input id="genero" name="genero" value="{{ $pelicula['genero'] }}" maxlength="80">

            <label for="anio">Año(opcional)</label>
            <input id="anio" type="number" name="anio" min="1895" max="{{ $maxYear }}"
                value="{{ $pelicula['anio'] }}">

            <label for="descripcion">Descripción(opcional)</label>
            <textarea id="descripcion" name="descripcion" maxlength="1000">{{ $pelicula['descripcion'] }}</textarea>

            <label for="imagen">Imagen(opcional)</label>
            @if (!empty($pelicula['imagen']))
                <img class="poster" src="{{ Storage::url($pelicula['imagen']) }}" alt="Póster de {{ $pelicula['titulo'] }}">
            @else
                <div class="sin-imagen">Sin imagen</div>
            @endif

            <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp">
            <small>JPG, PNG o WEBP. Maximo 300KB.</small>

            <button class="btn btn-outline-secondary" type="submit">Guardar pelicula</button>
        </form>
    @endif
    <a class="btn btn-outline-secondary" href="{{ route('peliculas.index') }}">Cancelar</a>
@endsection
