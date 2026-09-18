@extends('layouts.peliculas', ['title' => 'Editar pelicula'])

@section('content')
    <h1>Editar pelicula</h1>

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

            <label for="titulo">Título(opcional)</label>
            <input id="titulo" name="titulo" value="{{ $pelicula['titulo'] }}" required>

            <label for="genero">Género(opcional)</label>
            <input id="genero" name="genero" value="{{ $pelicula['genero'] }}" required>

            <label for="anio">Año(opcional)</label>
            <input id="anio" type="number" name="anio" min="1895" max="{{ $maxYear }}"
                value="{{ $pelicula['anio'] }}" required>

            <label for="descripcion">Descripción(opcional)</label>
            <textarea id="descripcion" name="descripcion" required>{{ $pelicula['descripcion'] }}</textarea>

            <label for="imagen">Imagen(opcional)</label>
            @if (!empty($pelicula['imagen']))
                <img class="poster" src="{{ Storage::url($pelicula['imagen']) }}" alt="Póster de {{ $pelicula['titulo'] }}">
            @else
                <div class="sin-imagen">Sin imagen</div>
            @endif

            <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp" required>
            <small>JPG, PNG o WEBP. Maximo 2 MB.</small>

            <button type="submit">Guardar pelicula</button>
        </form>
    @endif
    <p><a href="{{ route('peliculas.index') }}"><- Cancelar</a></p>
@endsection
