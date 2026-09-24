@extends('layouts.peliculas', ['title' => $titulo])

@section('content')
    <h2 class="display-5 text-center">
        {{ $titulo }}</h2>

    @forelse ($resenias as $resenia)
        <article class="pelicula">

            <div class="card-body">
                <h6 class="card-subtitle mb-2">El usuario <i><b>{{ $resenia['nombreUsuario'] }}</b></i> dice:</h6>
                <p class="card-text">"{{ $resenia['comentario'] }}"</p>
                <p class="card-text"><strong>Puntaje:</strong>
                    @switch((int) $resenia['puntaje'])
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

        </article>
        @empty
            <p>No hay reseñas para mostrar.</p>
        @endforelse

        <p>
            <a class="btn btn-outline-secondary" href="{{ route('peliculas.show', $pelicula['id'] ?? $idPelicula) }}">Volver a la
                película</a>
        </p>
    @endsection
