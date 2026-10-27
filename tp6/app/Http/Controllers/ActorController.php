<?php
//acá no hago referencias a pelicula porque la relaicon es n:m entonces actor existe por si mismo
//acá voy a poner solo metodos de crear y guardar porque no quiero hacer una vista de actores o algo así
namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class ActorController extends Controller
{
    public function create(): View
    {
        return view('actores.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:50'],
            'apellido' => ['required', 'string', 'max:50'],
            'imagen'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:300'],
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('actores', 'public');
        }

        Actor::create($validated);

        //redirecciono a peliculas porque no quiero crear una vista para actores
        return redirect()->route('peliculas.index')
            ->with('exitoActor', '¡Actor creado con éxito!');
    }
}
