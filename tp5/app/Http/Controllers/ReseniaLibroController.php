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
        $libro = Libro::with('resenias')->findOrFail($libro_id);//asi traeria las reseñas de ESA pelicula q entro por parametro
        return view('reseniasLibros.index', [
            'libro' => $libro,
            'reseniaLibros' => $libro->resenias,
            'titulo' => "Reseñas de " . $libro->titulo,
            'activeFilter' => 'todas',
            'modelo' => new ReseniaLibro(),
        ]);
    }

    //esto lo comento porque sin darme cuenta terminé haciendo lo mismo que index, revisar si esto se puede hacer!
    // public function show(int $id): View
    // {
    //     $reseniaLibro=ReseniaLibro::find($id);
    //     return view('reseniasLibros.show', [
    //         'reseniaLibro' =>  $reseniaLibro ,
    //         'modelo' => new ReseniaLibro(),
    //     ]);
    // }

    public function create($libro_id): View
    {
        $libro = Libro::findOrFail($libro_id);
        return view('reseniasLibros.create', compact('libro'));
    }

    public function store(Request $request, $libro_id): RedirectResponse
    {
        $validated = $request->validate([
            'nombreUsuario' => ['required', 'string', 'max:50'],
            'comentario' => ['required', 'string', 'max:1000'],
            'puntaje' => ['required', 'integer', 'min:1', 'max:5']
        ]);

        $libro= Libro::findOrFail($libro_id);
        $libro->resenias()->create($validated);

        return redirect()->route('libros.show', $libro_id);
    }
}
