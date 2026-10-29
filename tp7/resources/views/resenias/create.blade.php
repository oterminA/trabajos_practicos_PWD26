@extends('layouts.peliculas', ['title' => 'Nueva reseña'])

@section('content')
    <h2>Nueva reseña de {{$pelicula->titulo}}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('resenias.store', $pelicula->id) }}" method="POST" >
        @csrf

        <label for="comentario">Comentario(en 1000 caracteres)</label>
        <textarea id="comentario" name="comentario" value="{{ old('comentario') }}" required maxlength="1000"></textarea>

        <label for="puntaje">Puntaje(1 a 5)</label>
        <input id="puntaje" type="number" name="puntaje" min="1" max="5" {{ old('puntaje') }}
            required>

        <button class="btn btn-outline-secondary" type="submit">Guardar Reseña</button>
    </form>

    <a class="btn btn-outline-secondary" href="{{ route('peliculas.show', $pelicula->id) }}">Cancelar</a>
@endsection
