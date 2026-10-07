<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PeliculaController extends Controller
{
    public function index(): View
    {
        return view('peliculas.index', [
            'peliculas' => Pelicula::orderBy('titulo')->get(),
            'generos'      => Pelicula::select('genero')->distinct()->pluck('genero'), //pluck y eso es para que no me de cosas repetidas creo
            'titulo' => 'Catalogo de peliculas',
            'activeFilter' => 'todos',
            'modelo' => new Pelicula(),
        ]);
    }

    public function show(int $id): View
    {
        $pelicula = Pelicula::find($id);
        return view('peliculas.show', [
            'pelicula' =>  $pelicula,
            'modelo' => new Pelicula(),
        ]);
    }

    public function create(): View
    {
        return view('peliculas.create', [
            'maxYear' => now()->year + 5,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'genero' => ['required', 'string', 'max:80'],
            'anio' => ['required', 'integer', 'min:1895', 'max:' . (now()->year + 5)],
            'descripcion' => ['required', 'string', 'max:1000'],
            'imagen'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:300'],
        ]);

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('peliculas', 'public');
        }

        Pelicula::create([
            'titulo' => $validated['titulo'],
            'genero' => $validated['genero'],
            'anio' => (int) $validated['anio'],
            'descripcion' => $validated['descripcion'],
            'imagen' => $rutaImagen,
        ]);

        return redirect()->route('peliculas.index');
    }

    /**
     *
     */
    public function edit($id)
    {
        $pelicula = Pelicula::findOrFail($id); //acá traeria toda la data de ese pelicula
        $maxYear = now()->year + 5;
        return view('peliculas.edit', compact('pelicula', 'maxYear')); //creo que acá no tengo que poner lo de url porque se accede desde el modelo con esa funcion de url no se cuanto
    }

    /**
     *
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $pelicula = Pelicula::findOrFail($id);
        $validated = $request->validate([
            'titulo' => ['string', 'max:120'],
            'autor' => ['string', 'max:100'],
            'genero' => ['string', 'max:80'],
            'anio' => ['integer', 'min:1895', 'max:' . (now()->year + 5)],
            'descripcion' => ['string', 'max:1000'],
            'imagen'   => ['image', 'mimes:jpg,jpeg,png,webp', 'max:300'],
        ]);

        if ($request->hasFile('imagen')) {
            if ($pelicula->imagen && Storage::disk('public')->exists($pelicula->imagen)) {
                Storage::disk('public')->delete($pelicula->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('peliculas', 'public');
        }

        $validated['imagen'] = $request->file('imagen')->store('peliculas', 'public');

        $pelicula->update($validated);

        return redirect()->route('peliculas.show', $pelicula->id);
    }

    /**
     *
     */
    public function destroy($id)
    {
        $pelicula = Pelicula::findOrFail($id);
        if ($pelicula->imagen && Storage::disk('public')->exists($pelicula->imagen)) {
            Storage::disk('public')->delete($pelicula->imagen);
        }
        $pelicula->delete();
        return redirect()->route('peliculas.index');
    }

    /**
     *
     */
    public function search(Request $request)
    {
        $tituloBuscado = $request->input('buscar', ''); //desde la vista recupero el titulo o lo dejo como vacio x las dudas
        $resultados = Pelicula::where('titulo', 'LIKE', "%{$tituloBuscado}%")->get();
        return view('peliculas.index', [ //estos son los datos que necesito pasarle a la vista porq los va a necesitar
            'peliculas' => $resultados,
            'generos'      => Pelicula::select('genero')->distinct()->pluck('genero'), //pluck y eso es para que no me de cosas repetidas creo
            'titulo' => 'Resultados para la búsqueda: "' . $tituloBuscado . '"',
            'activeFilter' => 'todos',
            'modelo' => new Pelicula(),
        ]);
    }
}
