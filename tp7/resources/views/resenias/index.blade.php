@extends('layouts.peliculas', ['title' => $titulo])

@section('content')
    <h2 class="display-5 text-center">
        {{ $titulo }}</h2>

    @forelse ($resenias as $resenia)
        <article class="pelicula">

            <div class="card-body">
                {{-- esto es la politica de reseniapolicy donde solo puede borrar el admin o el dueño de la reseña--}}
                @can('delete', $resenia)
                    <form action="{{ route('resenias.destroy', $resenia->id) }}"
                        method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta reseña?');">
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

        <p>
            <a class="btn btn-outline-secondary" href="{{ route('peliculas.show', $pelicula->id ?? $id_Pelicula) }}">Volver a la
                pelicula</a>
        </p>
    @endsection
