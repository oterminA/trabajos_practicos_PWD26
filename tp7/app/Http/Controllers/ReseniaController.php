<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Resenia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReseniaController extends Controller
{

    public function index($pelicula_id): View
    {
        $pelicula = Pelicula::with('resenias.user')->findOrFail($pelicula_id); //aparentemente esto es lo de eager loading para que no haga ocnsultas innecesarias a la bd y me traiga los usuarios
        return view('peliculas.show', [ //locambie para q se muestren las resenias en la misma pagina que la peli
            'pelicula'     => $pelicula,
            'resenias'     => $pelicula->resenias,
            'titulo'       => 'Reseñas de ' . $pelicula->titulo,
            'activeFilter' => 'todas',
            'modelo'       => new Resenia(),
        ]);
    }


    public function create($pelicula_id): View
    {
        $pelicula = Pelicula::findOrFail($pelicula_id);
        return view('resenias.create', compact('pelicula'));
    }


    public function store(Request $request, $pelicula_id)
    {
        $validated = $request->validate([
            'comentario' => ['required', 'string', 'max:1000'],
            'puntaje' => ['required', 'integer', 'min:1', 'max:5']
        ]);

        $pelicula = Pelicula::findOrFail($pelicula_id);

        $resenia = $pelicula->resenias()->create([
            'comentario' => $validated['comentario'],
            'puntaje' => $validated['puntaje'],
            'user_id' => auth()->id(), //le pongo el user autenticado
        ]);

        return response()->json([ //acá mando los datos al js
            'success' => true,
            'resenia' => $resenia
        ]);
    }


    /**
     *
     */
    public function destroy(Resenia $resenia)
    {
        $this->authorize('delete', $resenia); //uso la funcion de reseniapolicy donde solo borra el admin o el dueño de la reseña
        $peliculaId = $resenia->pelicula_id; //traigo la pelicula asociada a esa
        $resenia->delete(); //borro la reseña

        return redirect()->route('peliculas.show', $peliculaId)
            ->with('deletedResenia', 'Reseña eliminada con éxito');
    }
}
