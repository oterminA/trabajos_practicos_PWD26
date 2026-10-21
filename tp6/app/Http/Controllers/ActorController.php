<?php
//acá no hago referencias a pelicula porque la relaicon es n:m entonces actor existe por si mismo
//acá voy a poner solo metodos de crear y guardar porque no quiero hacer una vista de actores o algo así
namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ActorController extends Controller
{
    public function create(): View {
        return view('actores.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:50'],
            'apellido' => ['required', 'string', 'max:50'],
        ]);
        Actor::create($validated);

        //redirecciono a peliculas porque no quiero crear una vista para actores
        return redirect()->route('peliculas.index')
            ->with('exitoActor', '¡Actor creado con éxito!');
    }
}
