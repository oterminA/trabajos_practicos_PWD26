<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PeliculaController extends Controller
{
    public function index(Request $request): View
    {
        return view('peliculas.index', [
            'peliculas' => Pelicula::withCount('resenias') //para q cada resenia triga su cantidad y lo recupero como resenias_count
                ->withAvg('resenias', 'puntaje') //para lo del promediodde resenias
                ->when($request->filled('genero'), function ($query) use ($request) {
                    return $query->where('genero', $request->genero);
                })
                ->when($request->filled('actor'), function ($query) use ($request) {
                    return $query->whereHas('actores', function ($q) use ($request) {
                        $q->where('actores.id', $request->actor);
                    });
                })
                ->orderBy('titulo')
                ->get(),

            'generos' => Pelicula::select('genero')->distinct()->pluck('genero'),
            'actores' => Actor::orderBy('apellido')->get(),
            'titulo' => $request->filled('genero')
                ? 'Películas de ' . $request->genero
                : 'Catalogo de peliculas',
            'activeFilter' => $request->input('genero') ?? $request->input('actor', 'todos'),
            'modelo' => new Pelicula(),
        ]);
    }

    public function show(int $id): View
    {
        $pelicula = Pelicula::with(['resenias', 'actores'])->findOrFail($id); //creo q esto es para no hacer dos consultas iguales y me de error
        return view('peliculas.show', compact('pelicula'));
    }

    public function create(): View
    {
        $actores = Actor::orderBy('apellido')->get(); //recupero los actores para mandarlos al form de pelicula
        return view('peliculas.create', [
            'maxYear' => now()->year + 5,
        ], compact('actores'));
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

        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('peliculas', 'public');
        }

        $pelicula = Pelicula::create([
            'titulo' => $validated['titulo'],
            'genero' => $validated['genero'],
            'anio' => (int) $validated['anio'],
            'descripcion' => $validated['descripcion'],
            'imagen' => $rutaImagen,
        ]);

        if ($request->has('actor_ids')) {
            $pelicula->actores()->attach($request->actor_ids);
        }

        return redirect()->route('peliculas.index')
            ->with('exitoPelicula', 'Pelicula creada con éxito!');
    }

    /**
     *
     */
    public function edit($id)
    {
        $actores = Actor::orderBy('apellido')->get(); //recupero los actores para mandarlos al form de pelicula
        $pelicula = Pelicula::findOrFail($id); //acá traeria toda la data de ese pelicula
        $maxYear = now()->year + 5;
        return view('peliculas.edit', compact('pelicula', 'maxYear', 'actores'));
    }

    /**
     *
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $pelicula = Pelicula::findOrFail($id);
        $validated = $request->validate([
            'titulo' => ['string', 'max:120'],
            'genero' => ['string', 'max:80'],
            'anio' => ['integer', 'min:1895', 'max:' . (now()->year + 5)],
            'descripcion' => ['string', 'max:1000'],
            'imagen'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:300'],
        ]);

        if ($request->hasFile('imagen')) {
            if ($pelicula->imagen && Storage::disk('public')->exists($pelicula->imagen)) {
                Storage::disk('public')->delete($pelicula->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('peliculas', 'public');
        }

        $pelicula->update($validated);
        $pelicula->actores()->sync($request->input('actor_ids', []));

        return redirect()->route('peliculas.show', $pelicula->id)
            ->with('edicion', 'La película fue modificada');
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
        return redirect()->route('peliculas.index')
            ->with('deletedPelicula', 'La película fue borrada');
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

    /**
     * funcion que hace una respuesta json para usar ajax en js cuando el usuario busca un titulo
     */
    public function ajaxSearch(Request $request)
    {
        $tituloBuscado = $request->input('titulo', ''); //acá tenog que poner 'titulo' porque en fetch es lo que usé "fetch(`/api/peliculas/buscar?titulo=${encodeURIComponent(tituloBuscado)}`" no tiene que ver con el input search
        $resultados = Pelicula::where('titulo', 'LIKE', "%{$tituloBuscado}%")->get();
        return response()->json([
            'success' => true,
            'peliculas' => $resultados
        ]);
    }


    /**
     *funcion que usa el scope del modelo
     */
    public function sinImagen()
    {
        return view('peliculas.index', [ //estos son los datos que necesito pasarle a la vista porq los va a necesitar
            'peliculas' => Pelicula::sinImagen() //no uso la palabra scope porque las convenciones de laravel la borran
                ->orderBy('titulo')
                ->get(),
            'generos'      => Pelicula::select('genero')->distinct()->pluck('genero'), //pluck y eso es para que no me de cosas repetidas creo
            'titulo' => 'Peliculas sin imagen',
            'activeFilter' => 'todos',
            'modelo' => new Pelicula(),
        ]);
    }
}
