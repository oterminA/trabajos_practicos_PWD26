@extends('layouts.app')

@section('title', 'Actividades disponibles · Eventia')

@section('content')
    <section class="hero">
        <div class="container hero-content">
            <p class="eyebrow">Aprender · Crear · Compartir</p>
            <h1>Actividades disponibles</h1>
            <p class="hero-copy">Encontrá cursos, talleres y jornadas para aprender algo nuevo y conectar con otras personas.
            </p>
        </div>
    </section>
    <section class="container activities-section">
        @if (session('exito'))
            <div
                style="padding: 14px 20px; margin-bottom: 24px; color: #fdfdfd; background-color: #4e8d5d; border: 1px solid #c3e6cb; border-radius: 8px;">
                {{ session('exito') }}
            </div>
        @endif

        @if (session('deleted'))
            <div
                style="padding: 14px 20px; margin-bottom: 24px; color: #fdfdfd; background-color: #eb5b48; border: 1px solid #c3e6cb; border-radius: 8px;">
                {{ session('deleted') }}
            </div>
        @endif

        <div class="section-heading">
            <div>
                <p class="eyebrow dark">Agenda</p>
                <h2>{{ $actividades->count() }} propuesta(s) para explorar</h2>
            </div>
        </div>
        @if ($actividades->isEmpty())
            <div class="empty-state">
                <h2>Todavía no hay actividades</h2>
                <p>Volvé pronto para conocer las próximas propuestas.</p>
            </div>
        @else
            <div class="activity-grid">
                @foreach ($actividades as $actividad)
                    <article class="activity-card">
                        <div class="card-top {{ strtolower($actividad->estado) }}">
                            <span class="date-day">{{ $actividad->fecha->format('d') }}</span>
                            <span class="date-month">{{ $actividad->fecha->translatedFormat('M') }}</span>
                            <span class="status">{{ $actividad->estado }}</span>
                        </div>
                        <div class="card-body">
                            <h3>{{ $actividad->titulo }}</h3>
                            <p>{{ $actividad->descripcion }}</p>
                            <dl class="activity-meta">
                                <div>
                                    <dt>Fecha y hora</dt>
                                    <dd>{{ $actividad->fecha->format('d/m/Y') }} · {{ substr($actividad->hora, 0, 5) }} h
                                    </dd>
                                </div>
                                <div>
                                    <dt>Cupo</dt>
                                    <dd>{{ $actividad->cupo }} lugares</dd>
                                </div>
                            </dl>
                            <div class="card-footer">
                                <strong>{{ (float) $actividad->precio === 0.0 ? 'Gratuita' : '$ ' . number_format($actividad->precio, 0, ',', '.') }}</strong>
                                <a href="{{ route('actividades.show', $actividad['id']) }}"> <span
                                        class="coming-soon">Detalle</span></a>

                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
