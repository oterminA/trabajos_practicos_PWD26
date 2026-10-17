@extends('layouts.app', ['title' => 'Agregar Actividad'])

@section('content')
    <section class="activities-section">

        <div class="container">
            {{-- esto es lo que se complementa con lo de la funcion store para mostrar el cartelito --}}
            @if (session('exito'))
                <div
                    style="padding: 14px 20px; margin-bottom: 24px; color: #fdfdfd; background-color: #4e8d5d; border: 1px solid #c3e6cb; border-radius: 8px;">
                    {{ session('exito') }}
                </div>
            @endif

            <article class="activity-detail-card" style="max-width: 700px; margin: 0 auto;">
                <header class="detail-card-top">
                    <div class="eyebrow dark">Administración</div>
                    <h1>Crear Actividad</h1>
                </header>

                <div class="detail-card-body">

                    @if ($errors->any())
                        <div class="errores">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('actividades.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="titulo" class="eyebrow dark">Título <small></small> </label>
                            <input id="titulo" type="text" name="titulo" class="form-control"
                                value="{{ old('titulo') }}" maxlength="150" required>
                        </div>

                        <div>
                            <div>
                                <label for="fecha" class="eyebrow dark">Fecha <small></small> </label>
                                <input id="fecha" type="date" name="fecha" class="form-control"
                                    value="{{ old('fecha') }}" required>
                            </div>
                            <div>
                                <label for="hora" class="eyebrow dark">Hora <small></small> </label>
                                <input id="hora" type="time" name="hora" class="form-control"
                                    value="{{ old('hora') }}" required>
                            </div>
                        </div>

                        <div>
                            <div>
                                <label for="cupo" class="eyebrow dark">Cupo (mayor a 0) <small></small> </label>
                                <input id="cupo" type="number" name="cupo" class="form-control" min="1"
                                    value="{{ old('cupo') }}" required>
                            </div>
                            <div>
                                <label for="precio" class="eyebrow dark">Precio <small></small> ($) </label>
                                <input id="precio" type="number" step="0.01" name="precio" class="form-control"
                                    min="0" value="{{ old('precio') }}" required>
                            </div>
                        </div>

                        <div>
                            <label for="estado" class="eyebrow dark">Estado <small></small> </label>
                            <select id="estado" name="estado" class="form-control" required>
                                {{-- esto es para que dinamicamente se agreguen los estados  y no esten hardcodeados --}}
                                @forelse ($estados as $estado)
                                    <option value="{{ $estado }}"
                                        {{ old('estado') === $estado ? 'selected' : '' }}>
                                        {{ $estado }}
                                    </option>
                                @empty
                                    <option disabled selected>No hay estados para mostrar</option>
                                @endforelse
                            </select>
                        </div>

                        <div>
                            <label for="descripcion" class="eyebrow dark">Descripción <small></small> </label>
                            <textarea id="descripcion" name="descripcion" rows="4" class="form-control" maxlength="1000" required>{{ old('descripcion') }}</textarea>
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label for="imagen" class="eyebrow dark">Imagen <small></small></label>
                            <input id="imagen" type="file" name="imagen" class="form-control"
                                accept="image/jpeg,image/png,image/webp">
                            <small>Formatos permitidos: JPG, PNG o WEBP. Máximo 300KB.</small>
                        </div>

                        <div>
                            <a href="{{ route('actividades.index') }}" class="btn-secondary">Cancelar</a>
                            <button type="submit" class="btn-primary">Guardar actividad</button>
                        </div>
                    </form>

                </div>
            </article>

        </div>
    </section>
@endsection
