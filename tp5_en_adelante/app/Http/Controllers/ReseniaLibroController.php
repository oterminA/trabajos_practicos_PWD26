<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\ReseniaLibro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ReseniaLibroController extends Controller
{
   public function index($libro_id): View
    {
        $pelicula = Libro::findOrFail($libro_id);
        $resenias = $pelicula->resenias(); //asi traeria las reseñas de ESA pelicula q entro por parametro
        $libro = new Libro;
        return view('reseniasLibros.index', [
            'reseniaLibros' => ReseniaLibro::orderBy('nombreUsuario')->get(),
            'titulo' => "Reseñas de " . ($libro->titulo ?? ''),
            'activeFilter' => 'todas',
            'modelo' => new ReseniaLibro(),
        ]);
    }

    public function show(int $id): View
    {
        $reseniaLibro=ReseniaLibro::find($id);
        return view('reseniasLibros.show', [
            'reseniaLibro' =>  $reseniaLibro ,
            'modelo' => new ReseniaLibro(),
        ]);
    }

    public function create(): View
    {
        return view('reseniasLibro.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombreUsuario' => ['required', 'string', 'max:50'],
            'comentario' => ['required', 'string', 'max:1000'],
            'puntaje' => ['required', 'integer', 'min:1', 'max:5']
        ]);

        ReseniaLibro::create([
            'nombreUsuario' => $validated['nombreUsuario'],
            'comentario' => $validated['comentario'],
            'puntaje' => (int) $validated['puntaje']
        ]);

        return redirect()->route('reseniasLibro.index');
    }
}
