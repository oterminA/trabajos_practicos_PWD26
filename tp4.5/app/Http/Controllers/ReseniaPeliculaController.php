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
    public function index(): View
    {
        return view('resenias.index', [
            'resenias' => ReseniaPelicula::orderBy('nombreUsuario')->get(),
            'titulo' => 'Catalogo de reseñas',
            'activeFilter' => 'todas',
            'modelo' => new ReseniaPelicula(),
        ]);
    }

    public function show(int $id): View
    {
        $pelicula=ReseniaPelicula::find($id);
        return view('resenias.show', [
            'pelicula' =>  $pelicula ,
            'modelo' => new ReseniaPelicula(),
        ]);
    }

    public function create(): View
    {
        return view('resenias.create');
    }

    public function store(Request $request): RedirectResponse
    {
         $validated = $request->validate([
            'nombreUsuario' => ['required', 'string', 'max:50'],
            'comentario' => ['required', 'string', 'max:1000'],
            'puntaje' => ['required', 'integer', 'min:1', 'max:5']
        ]);

        ReseniaPelicula::create([
            'nombreUsuario' => $validated['nombreUsuario'],
            'comentario' => $validated['comentario'],
            'puntaje' => (int) $validated['puntaje']
        ]);

        return redirect()->route('resenias.index');
    }
}
