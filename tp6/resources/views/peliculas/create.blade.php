@extends('layouts.peliculas', ['title' => 'Nueva pelicula'])
@section('content')
    <h2>Nueva pelicula</h2>

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

    <form action="{{ route('peliculas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="titulo">Título</label>
        <input id="titulo" name="titulo" value="{{ old('titulo') }}" required maxlength="120">

        <label for="genero">Género</label>
        <input id="genero" name="genero" value="{{ old('genero') }}" required maxlength="80">

        <label for="anio">Año</label>
        <input id="anio" type="number" name="anio" min="1895" max="{{ $maxYear }}"
            value="{{ old('anio') }}" required>

        <div class="mb-3">
            <label for="actores" class="form-label">Elenco:</label>

            <!-- paso 2 para usar tom select como libreria -->
            <select name="actor_ids[]" id="select-actores" multiple autocomplete="off">
                {{-- para multiples poner multiple --}}
                    @foreach ($actores as $actor)
                        <option value="{{ $actor->id }}" {{ in_array($actor->id, old('actor_ids', isset($pelicula) ? $pelicula->actores->pluck('id')->toArray() : [])) ? 'selected' : '' }} data-foto="{{ asset('storage/' . $actor->imagen) }}">
                            {{ $actor->nombreFormateado }}
                        </option>
                    @endforeach
                </select>
        </div>

        <label for="descripcion">Descripcion</label>
        <textarea id="descripcion" name="descripcion" required maxlength="1000">{{ old('descripcion') }}</textarea>

        <label for="imagen">Imagen</label>
        <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp">
        <small>JPG, PNG o WEBP. Maximo 300 KB.</small>

        <button class="btn btn-outline-secondary" type="submit">Guardar pelicula</button>
    </form>

    <a class="btn btn-outline-secondary" href="{{ route('peliculas.index') }}">Cancelar</a>

@endsection
