<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LibroController extends Controller
{
    public function index(): View
    {
        return view('libros.index', [
            'libros' => Libro::orderBy('titulo')->get(),
            'generos'      => Libro::select('genero')->distinct()->pluck('genero'), //pluck y eso es para que no me de cosas repetidas creo
            'autores'      => Libro::select('autor')->distinct()->pluck('autor'), //pluck y eso es para que no me de cosas repetidas creo
            'titulo' => 'Catalogo de libros',
            'activeFilter' => 'todos',
            'modelo' => new Libro(),
        ]);
    }

    public function show(int $id): View
    {
        $libro = Libro::find($id);
        return view('libros.show', [
            'libro' =>  $libro,
            'modelo' => new Libro(),
        ]);
    }

    public function create(): View
    {
        return view('libros.create', [
            'maxYear' => now()->year + 5,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'autor' => ['required', 'string', 'max:100'],
            'genero' => ['required', 'string', 'max:80'],
            'anio' => ['required', 'integer', 'min:1895', 'max:' . (now()->year + 5)],
            'sinopsis' => ['required', 'string', 'max:1000'],
            'imagen'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:300'],
        ]);

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('libros', 'public');
        }

        Libro::create([
            'titulo' => $validated['titulo'],
            'autor' => $validated['autor'],
            'genero' => $validated['genero'],
            'anio' => (int) $validated['anio'],
            'sinopsis' => $validated['sinopsis'],
            'imagen' => $rutaImagen,
        ]);

        return redirect()->route('libros.index');
    }

    /**
     *
     */
    public function edit($id)
    {
        $libro = Libro::findOrFail($id); //acá traeria toda la data de ese libro
        $maxYear = now()->year + 5;
        return view('libros.edit', compact('libro', 'maxYear')); //creo que acá no tengo que poner lo de url porque se accede desde el modelo con esa funcion de url no se cuanto
    }

    /**
     *
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $libro = Libro::findOrFail($id);
        $validated = $request->validate([
            'titulo' => ['string', 'max:120'],
            'autor' => ['string', 'max:100'],
            'genero' => ['string', 'max:80'],
            'anio' => ['integer', 'min:1895', 'max:' . (now()->year + 5)],
            'sinopsis' => ['string', 'max:1000'],
            'imagen'   => ['image', 'mimes:jpg,jpeg,png,webp', 'max:300'],
        ]);

        if ($request->hasFile('imagen')) {
            if ($libro->imagen && Storage::disk('public')->exists($libro->imagen)) {
                Storage::disk('public')->delete($libro->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('libros', 'public');
        }

        $validated['imagen'] = $request->file('imagen')->store('libros', 'public');

        $libro->update($validated);

        return redirect()->route('libros.show', $libro->id);
    }

    /**
     *
     */
    public function destroy($id)
    {
        $libro = Libro::findOrFail($id);
        if ($libro->imagen && Storage::disk('public')->exists($libro->imagen)) {
            Storage::disk('public')->delete($libro->imagen);
        }
        $libro->delete();
        return redirect()->route('libros.index');
    }

    /**
     *
     */
    public function search(Request $request)
    {
        $tituloBuscado = $request->input('buscar', ''); //desde la vista recupero el titulo o lo dejo como vacio x las dudas
        $resultados = Libro::where('titulo', 'LIKE', "%{$tituloBuscado}%")->get();
        return view('libros.index', [ //estos son los datos que necesito pasarle a la vista porq los va a necesitar
            'libros' => $resultados,
            'generos'      => Libro::select('genero')->distinct()->pluck('genero'), //pluck y eso es para que no me de cosas repetidas creo
            'autores'      => Libro::select('autor')->distinct()->pluck('autor'), //pluck y eso es para que no me de cosas repetidas creo
            'titulo' => 'Resultados para la búsqueda: "' . $tituloBuscado . '"',
            'activeFilter' => 'todos',
            'modelo' => new Libro(),
        ]);
    }
}
