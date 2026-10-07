<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/*
'titulo', 'descripcion', 'fecha', 'hora', 'cupo', 'precio', 'imagen', 'estado'
*/

class ActividadController extends Controller
{
    /** Esta acción se entrega resuelta como ejemplo de lectura con Eloquent. */
    public function index(): View
    {
        $actividades = Actividad::orderBy('fecha')->orderBy('hora')->get();
        $estados = Actividad::distinct()
            ->pluck('estado');
        return view('actividades.index', compact('actividades', 'estados'));
    }

    /**
     *
     */
    public function show(int $id): View
    {
        $actividad = Actividad::find($id);
        $estados = Actividad::distinct()
            ->pluck('estado');
        return view('actividades.show', [
            'actividad' =>  $actividad,
            'estados' => $estados,
            'modelo' => new Actividad(),
        ]);
    }

    /**
     *
     */
    public function create(): View
    {
        $estados = Actividad::distinct()
            ->pluck('estado'); //asi hago que me traiga todos los estados sin repetir y mostrando solo 'activa' y eso
        return view('actividades.create', [
            'estados' => $estados,
        ]);
    }


    /**
     *
     */
    public function store(Request $request): RedirectResponse
    {
        /*
        título y descripción obligatorios;
fecha válida y hora obligatoria;
cupo entero mayor que cero;
precio mayor o igual que cero;
estado: ACTIVA, CANCELADA o FINALIZADA;
imagen opcional en formato JPG, PNG o WebP.
        */
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:150'],
            'fecha' => ['required', 'date'],
            'hora' => ['required', 'date_format:H:i'],
            'cupo' => ['required', 'integer'],
            'precio' => ['required', 'numeric'],
            'estado' => ['required', 'string'],
            'descripcion' => ['required', 'string', 'max:1000'],
            'imagen'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:300'],
        ]);

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('actividades', 'public');
        } else {
            $rutaImagen = null;
        }

        Actividad::create([
            'titulo' => $validated['titulo'],
            'fecha' => $validated['fecha'],
            'hora' => $validated['hora'],
            'cupo' => $validated['cupo'],
            'precio' => $validated['precio'],
            'estado' => $validated['estado'],
            'descripcion' => $validated['descripcion'],
            'imagen' => $rutaImagen,
        ]);

        return redirect()->route('actividades.index')
            ->with('exito', '¡Actividad agregada con éxito!');
    }


    /**
     *
     */
    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id); //acá traeria toda la data de esa act
        $estados = Actividad::distinct()
            ->pluck('estado'); //asi hago que me traiga todos los estados sin repetir y mostrando solo 'activa' y eso
        return view('actividades.edit', [
            'actividad' =>  $actividad,
            'estados' => $estados,
        ]);
    }

    /**
     *
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $actividad = Actividad::findOrFail($id);

        $validated = $request->validate([
            'titulo'      => ['string', 'max:150'],
            'fecha'       => ['nullable', 'date'],
            'hora'        => ['nullable', 'date_format:H:i'],
            'cupo'        => ['integer', 'min:1'],
            'precio'      => ['numeric', 'min:0'],
            'estado'       => ['string'],
            'descripcion' => ['string', 'max:1000'],
            'imagen'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:300'],
        ]);

        if ($request->hasFile('imagen')) {
            if ($actividad->imagen && Storage::disk('public')->exists($actividad->imagen)) {
                Storage::disk('public')->delete($actividad->imagen);
            }

            $validated['imagen'] = $request->file('imagen')->store('actividades', 'public');
        }

        $actividad->update($validated);

        return redirect()->route('actividades.show', $actividad->id)
            ->with('exito', '¡Actividad editada con éxito!');
    }


    /**
     *
     */
    public function delete($id)
    {
        $actividad = Actividad::findOrFail($id);
        if ($actividad->imagen && Storage::disk('public')->exists($actividad->imagen)) {
            Storage::disk('public')->delete($actividad->imagen);
        }
        $actividad->delete();
        return redirect()->route('actividades.index')
            ->with('deleted', '¡Actividad borrada con éxito!');
    }


    /**
     *
     */
    public function search(Request $request)
    {
        $tituloBuscado = $request->input('buscar', ''); //desde la vista recupero el titulo o lo dejo como vacio x las dudas
        $estados = Actividad::distinct()
            ->pluck('estado');
        $resultados = Actividad::where('titulo', 'LIKE', "%{$tituloBuscado}%")
            ->orderBy('fecha', 'desc')
            ->get();
        return view('actividades.index', [ //estos son los datos que necesito pasarle a la vista porq los va a necesitar
            'actividades' => $resultados,
            'estados' => $estados,
            'titulo' => 'Resultados para la búsqueda: "' . $tituloBuscado . '"',
            'activeFilter' => 'todos',
            'modelo' => new Actividad(),
        ]);
    }


    /**
     *
     */
    public function filter(Request $request)
    {
        /*Crear una pantalla que muestre únicamente actividades activas, con fecha igual o posterior a hoy y cupo mayor que cero, ordenadas por fecha y hora.*/

        $resultados = Actividad::where('estado', 'ACTIVA')
            ->where('fecha', '>=', today())
            ->where('cupo', '>', 0)
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get();
        $estados = Actividad::distinct()
            ->pluck('estado');
        return view('actividades.next', [ //estos son los datos que necesito pasarle a la vista porq los va a necesitar
            'actividades' => $resultados,
            'estados' => $estados,
            'activeFilter' => 'todos',
            'modelo' => new Actividad(),
        ]);
    }
}
