@extends('layouts.app', ['title' => $actividad ? $actividad->titulo : 'Actividad no encontrada'])

@section('content')
    <section class="activities-section">
        <div class="container">
            {{-- para mostrar lo del cartelito de que se editó correctamente --}}
            @if (session('exito'))
                <div
                    style="padding: 14px 20px; margin-bottom: 24px; color: #fdfdfd; background-color: #4e8d5d; border: 1px solid #c3e6cb; border-radius: 8px;">
                    {{ session('exito') }}
                </div>
            @endif

            @if ($actividad)
                <article class="activity-detail-card">


                    <header class="detail-card-top group-description">
                        <div>
                            <div class="eyebrow dark">Detalle de actividad</div>
                            <h1>{{ $actividad->titulo }}</h1>
                        </div>

                        <div class="group-modification">
                            {{-- esto es para que se muestre el alert de borrar o no la activdad, que lleva a un route --}}
                            <a class="eyebrow dark" href="{{ route('actividades.edit', $actividad['id']) }}">✏️</a>
                            <form action="{{ route('actividades.delete', $actividad['id']) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta actividad?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="eyebrow dark">🗑️</button>
                        </div>
                    </header>


                    <div class="detail-card-body">
                        <div class="group-description">
                            <p class="detail-description">
                                "{!! nl2br(e($actividad->descripcion)) !!}"
                            </p>
                            @if ($actividad->imagen)
                                <img class="detalle-poster" src="{{ Storage::url($actividad->imagen) }}"
                                    alt="Imagen de {{ $actividad->titulo }}">
                            @else
                                <div class="sin-imagen">
                                    Sin imagen
                                </div>
                            @endif
                        </div>


                        <dl class="activity-meta detail-meta-grid">
                            <div>
                                <dt>Fecha</dt>
                                <dd>{{ $actividad->fecha->format('d/m/Y') }}</dd>
                            </div>
                            <div>
                                <dt>Hora</dt>
                                <dd>{{ substr($actividad->hora, 0, 5) }}</dd>
                            </div>
                        </dl>

                        <dl class="activity-meta detail-meta-grid">
                            <div>
                                <dt>Precio</dt>
                                <strong>{{ (float) $actividad->precio === 0.0 ? 'Sin costo' : '$ ' . number_format($actividad->precio, 0, ',', '.') }}</strong>
                            </div>
                            <div>
                                <dt>Cupo</dt>
                                <dd>{{ $actividad->cupo === 0 ? 'No hay cupo' : $actividad->cupo . ' lugare(s)' }} </dd>
                            </div>
                        </dl>

                        <footer class="card-footer detail-footer">
                            <div>
                                <dt class="eyebrow dark" style="font-size: .65rem; margin-bottom: 2px;">Estado</dt>
                                <strong>>{{ $actividad->estado }}</strong>

                            </div>
                            @if ($actividad->estado === 'ACTIVA')
                                <a href="{{ route('actividades.index') }}" class="nav-link" style="color: var(--teal);">
                                    Inscribirse / Consultar
                                </a>
                            @endif

                        </footer>
                    </div>

                </article>
            @else
                <div class="empty-state">
                    <h2>Actividad no encontrada</h2>
                    <p>La actividad que buscas no existe o no está disponible en este momento.</p>
                </div>
            @endif
            <br>
            <div>
                <a href="{{ route('actividades.index') }}" class="back-link">
                    ← Volver a actividades
                </a>
            </div>

        </div>
    </section>
@endsection
