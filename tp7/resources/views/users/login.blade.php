@extends('layouts.inicioSesion')
@section('content')
    <div class="container my-5">

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('users.autenticar') }}" method="POST">
                    @csrf

                    <div class=" text-center mb-3">
                        <img src="{{ asset('css/assets/msn.jpg') }}" alt="Foto de msn" id="imagenMsn">
                    </div>

                    <div class="mb-3">
                        <label for="user" class="form-label">Usuario</label>
                        <input type="text" name="user" class="form-control" id="user" required minlength="5"
                            maxlength="10">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" id="password" required
                            minlength="8" maxlength="12">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    <hr>
                    <label for="">No tenés cuentá?</label>
                    <a href="{{ route('users.create') }}" class="btn btn-secondary w-100">Crear cuenta</a>

                </form>
            </div>
        </div>
    </div>
@endsection
