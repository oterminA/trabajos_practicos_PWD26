@extends('layouts.peliculas', ['title' => 'Nuevo actor'])

@section('content')
    <h2>Nuevo actor</h2>

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

    <form action="{{ route('actors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="50">

        <label for="apellido">Apellido</label>
        <input id="apellido" name="apellido" value="{{ old('apellido') }}" required maxlength="50">

        <label for="imagen">Imagen</label>
        <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp">
        <small>JPG, PNG o WEBP. Maximo 300 KB.</small>

        <button class="btn btn-outline-secondary" type="submit">Guardar</button>
    </form>

    <a class="btn btn-outline-secondary" href="{{ route('peliculas.index') }}">Cancelar</a>

@endsection
