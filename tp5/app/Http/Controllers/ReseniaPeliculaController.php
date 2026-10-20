<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\ReseniaPelicula;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReseniaPeliculaController extends Controller
{
    public function index($pelicula_id): View
    {
        $pelicula = Pelicula::with('resenias')->findOrFail($pelicula_id);

        return view('resenias.index', [
            'pelicula'     => $pelicula,
            'resenias'     => $pelicula->resenias,
            'titulo'       => 'Reseñas de ' . $pelicula->titulo,
            'activeFilter' => 'todas',
            'modelo'       => new ReseniaPelicula(),
        ]);
    }

    //esto lo comento porque sin darme cuenta terminé haciendo lo mismo que index, revisar si esto se puede hacer!
    // public function show(int $pelicula_id): View
    // {
    //     $pelicula = Pelicula::with('resenias')->findOrFail($pelicula_id);
    //     return view('resenias.index', [
    //         'pelicula' =>  $pelicula,
    //         'resenias' => $pelicula->resenias,
    //         'titulo' =>'Reseñas de ' . $pelicula->titulo,
    //         'modelo' => new ReseniaPelicula(),
    //     ]);
    // }

    public function create($pelicula_id): View
    {
        $pelicula = Pelicula::findOrFail($pelicula_id);
        return view('resenias.create', compact('pelicula'));
    }

    public function store(Request $request, $pelicula_id): RedirectResponse
    {
        $validated = $request->validate([
            'nombreUsuario' => ['required', 'string', 'max:50'],
            'comentario' => ['required', 'string', 'max:1000'],
            'puntaje' => ['required', 'integer', 'min:1', 'max:5']
        ]);

        $pelicula = Pelicula::findOrFail($pelicula_id);
        $pelicula->resenias()->create($validated); //para que la relacion asigne el id

        return redirect()->route('peliculas.show', $pelicula_id);
    }
}
