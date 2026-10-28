@extends('layouts.inicioSesion')

@section('content')
    <h2>Crear usuario</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user" class="form-label">Usuario</label>
            <input type="text" name="user" class="form-control" id="user" required minlength="5" maxlength="10">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" id="password" required minlength="8"
                maxlength="12" pattern="/^[a-zA-Z0-9!@#\$%\^\&*_=+-]{8,12}$/g">
        </div>

        <button class="btn btn-outline-primary" type="submit">Crear</button>
    </form>

    <a class="btn btn-outline-secondary" href="{{ route('peliculas.index') }}">Cancelar</a>
@endsection
