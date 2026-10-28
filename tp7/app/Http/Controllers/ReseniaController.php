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
        $pelicula = Pelicula::with('resenias')->findOrFail($pelicula_id);

        return view('resenias.index', [
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


    public function store(Request $request, $pelicula_id): RedirectResponse
    {
        $validated = $request->validate([
            'nombreUsuario' => ['required', 'string', 'max:50', 'unique:resenias, nombreUsuario'],
            'comentario' => ['required', 'string', 'max:1000'],
            'puntaje' => ['required', 'integer', 'min:1', 'max:5']
        ]);

        $pelicula = Pelicula::findOrFail($pelicula_id);
        $pelicula->resenias()->create($validated); //para que la relacion asigne el id

        return redirect()->route('peliculas.show', $pelicula_id)
            ->with('exitoResenia', '¡Reseña creada con éxito!');
    }
}
