@extends('layouts.peliculas', ['title' => $pelicula ? $pelicula->titulo : 'Pelicula no encontrada'])

@section('content')
    {{-- esto es para mostrar los cartelitos cuando se agrega --}}
    @if (session('exitoResenia'))
        <div
            style="padding: 14px 20px; margin-bottom: 24px; color: #fdfdfd; background-color: #4e8d5d; border: 1px solid #c3e6cb; border-radius: 8px;">
            {{ session('exitoResenia') }}
        </div>
    @endif

    @if (session('edicion'))
        <div
            style="padding: 14px 20px; margin-bottom: 24px; color: #080808; background-color: #edf1ac; border: 1px solid #c3e6cb; border-radius: 8px;">
            {{ session('edicion') }}
        </div>
    @endif

    @if (session('deletedResenia'))
        <div
            style="padding: 14px 20px; margin-bottom: 24px; color: #fdfdfd; background-color: #eb5b48; border: 1px solid #c3e6cb; border-radius: 8px;">
            {{ session('deletedResenia') }}
        </div>
    @endif
    <div class="row">
        <div class="col">
            @if ($pelicula)
                @if ($url = $pelicula->urlImagen($pelicula->imagen))
                    <img class="detalle-poster" src="{{ Storage::url($pelicula->imagen) }}"
                        alt="Poster de {{ $pelicula->titulo }}">
                @endif

                <h2>{{ $pelicula->titulo }}</h2>
                <p><strong>Genero:</strong> {{ $pelicula->genero }}</p>
                <p><strong>Año:</strong> {{ (int) $pelicula->anio }}</p>
                <p><strong>Reparto:</strong></p>
                <ul>
                    @foreach ($pelicula->actores as $actor)
                        <li>{{ $actor->nombreFormateado }}</li>
                    @endforeach
                </ul>
                <p><strong>Sinopsis:</strong></p>
                <p> <i>"{!! nl2br(e($pelicula->descripcion)) !!}"</i> </p>
            @else
                <h2>Pelicula no encontrada</h2>
            @endif
            <div class="d-grid gap-2 d-md-block d-md-flex justify-content-md-center">
                {{-- para el modal y ajax --}}
                <button type="button" onclick="abrirModalResenia(this)" data-pelicula-id="{{ $pelicula->id }}"
                    class="btn btn-outline-secondary">
                    Dejar reseña
                </button>

                {{-- si paso el ID solamente, en el controlador tengo que usar findOrFail para obtener el objeto --}}
                <a class="btn btn-outline-secondary" href="{{ route('peliculas.index') }}">Volver al catálogo</a>
            </div>
            <br>
        </div>

        <div class="col resenias">
            <h4>Reseñas</h4>
            @forelse ($resenias as $resenia)
                <article class="pelicula">

                    <div class="card-body">
                        {{-- esto es la politica de reseniapolicy donde solo puede borrar el admin o el dueño de la reseña --}}
                        @can('delete', $resenia)
                            <form action="{{ route('resenias.destroy', $resenia->id) }}" method="POST"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta reseña?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit">🗑️</button>
                            </form>
                        @endcan
                        <div>
                            <h6 class="card-subtitle mb-2">El usuario <i><b>{{ $resenia->user->user }}</b></i> dice:</h6>
                            <p class="card-text">"{{ $resenia->comentario }}"</p>
                            <p class="card-text"><strong>Puntaje:</strong>
                                @switch((int) $resenia->puntaje)
                                    @case(1)
                                        ★☆☆☆☆
                                    @break

                                    @case(2)
                                        ★★☆☆☆
                                    @break

                                    @case(3)
                                        ★★★☆☆
                                    @break

                                    @case(4)
                                        ★★★★☆
                                    @break

                                    @case(5)
                                        ★★★★★
                                    @break

                                    @default
                                        ☆☆☆☆☆
                                @endswitch
                            </p>
                        </div>

                    </div>

                </article>
                @empty
                    <p>No hay reseñas para mostrar.</p>
                @endforelse
            </div>
        </div>



    @endsection
