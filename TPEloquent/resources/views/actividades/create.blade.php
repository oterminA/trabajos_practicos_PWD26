@extends('layouts.app', ['title' => 'Agregar actividad'])

@section('content')
    <section class="activities-section">
        <div class="container">

            <article class="activity-detail-card" style="max-width: 700px; margin: 0 auto;">
                <header class="detail-card-top">
                    <div class="eyebrow dark">Administración</div>
                    <h1>Crear Nueva Actividad</h1>
                </header>

                <div class="detail-card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger" style="margin-bottom: 24px; padding: 16px; border-radius: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('actividades.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div style="margin-bottom: 18px;">
                            <label for="titulo" class="eyebrow dark" style="display: block; margin-bottom: 6px;">Título *</label>
                            <input id="titulo" type="text" name="titulo" class="form-control"
                                value="{{ old('titulo') }}" maxlength="150" required>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                            <div>
                                <label for="fecha" class="eyebrow dark" style="display: block; margin-bottom: 6px;">Fecha *</label>
                                <input id="fecha" type="date" name="fecha" class="form-control"
                                    value="{{ old('fecha') }}" required>
                            </div>
                            <div>
                                <label for="hora" class="eyebrow dark" style="display: block; margin-bottom: 6px;">Hora *</label>
                                <input id="hora" type="time" name="hora" class="form-control"
                                    value="{{ old('hora') }}" required>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                            <div>
                                <label for="cupo" class="eyebrow dark" style="display: block; margin-bottom: 6px;">Cupo (mayor a 0) *</label>
                                <input id="cupo" type="number" name="cupo" class="form-control" min="1"
                                    value="{{ old('cupo') }}" required>
                            </div>
                            <div>
                                <label for="precio" class="eyebrow dark" style="display: block; margin-bottom: 6px;">Precio ($) *</label>
                                <input id="precio" type="number" step="0.01" name="precio" class="form-control" min="0"
                                    value="{{ old('precio', 0) }}" required>
                            </div>
                        </div>

                        {{-- Estado --}}
                            <label for="estado" class="eyebrow dark" style="display: block; margin-bottom: 6px;">Estado *</label>
                            <select id="estado" name="estado" class="form-control" required>
                                <option value="ACTIVA" {{ old('estado') == 'ACTIVA' ? 'selected' : '' }}>ACTIVA</option>
                                <option value="CANCELADA" {{ old('estado') == 'CANCELADA' ? 'selected' : '' }}>CANCELADA</option>
                                <option value="FINALIZADA" {{ old('estado') == 'FINALIZADA' ? 'selected' : '' }}>FINALIZADA</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 18px;">
                            <label for="descripcion" class="eyebrow dark" style="display: block; margin-bottom: 6px;">Descripción *</label>
                            <textarea id="descripcion" name="descripcion" rows="4" class="form-control" maxlength="1000" required>{{ old('descripcion') }}</textarea>
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label for="imagen" class="eyebrow dark" style="display: block; margin-bottom: 6px;">Imagen (Opcional)</label>
                            <input id="imagen" type="file" name="imagen" class="form-control" accept="image/jpeg,image/png,image/webp">
                            <small style="color: var(--muted); font-size: .75rem; display: block; margin-top: 4px;">Formatos permitidos: JPG, PNG o WEBP. Máximo 300KB.</small>
                        </div>

                        <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 28px;">
                            <a href="{{ route('actividades.index') }}" class="btn-secondary">Cancelar</a>
                            <button type="submit" class="btn-primary">Guardar actividad</button>
                        </div>
                    </form>

                </div>
            </article>

            <div style="margin-top: 20px; text-align: center;">
                <a href="{{ route('actividades.index') }}" class="back-link">
                    ← Volver a actividades
                </a>
            </div>

        </div>
    </section>
@endsection
