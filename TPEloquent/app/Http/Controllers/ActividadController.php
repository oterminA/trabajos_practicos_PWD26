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
        $actividades = Actividad::orderBy('fecha')->orderBy('hora')->get(); //guardo acá la información del objeto pero acomodado por fecha y hora
        $estados = Actividad::distinct()
            ->pluck('estado'); //asi puedo guardar los estados sin repetir
        return view('actividades.index', compact('actividades', 'estados')); //eso es lo que paso a la vista
    }

    /**
     *esta funcion sirve para mostrar los detalles de un objeto
     */
    public function show(int $id): View
    {
        $actividad = Actividad::find($id); //recupero el objeto por el id que llega por parametro
        $estados = Actividad::distinct()
            ->pluck('estado'); //asi puedo guardar los estados sin repetir
        return view('actividades.show', [ //eso es lo que paso a la vista xq necesito esos datos ahi
            'actividad' =>  $actividad,
            'estados' => $estados,
            'modelo' => new Actividad(),
        ]);
    }

    /**
     *esta funcion sirve para redirigir a una pagina de la vista
     */
    public function create(): View
    {
        $estados = Actividad::distinct()
            ->pluck('estado'); //asi hago que me traiga todos los estados sin repetir y mostrando solo 'activa' y eso
        return view('actividades.create', [ //eso es lo que paso a la vista xq necesito esos datos ahi
            'estados' => $estados,
        ]);
    }


    /**
     *esta funcion guarda los datos metidos por medio del formulario
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
        $validated = $request->validate([ //valido aca en el servidor los datos
            'titulo' => ['required',
            'string',
            'max:150',
            Rule::unique('actividades', 'titulo'),],
            'fecha' => ['required', 'date'],
            'hora' => ['required', 'date_format:H:i'],
            'cupo' => ['required', 'integer'],
            'precio' => ['required', 'numeric'],
            'estado' => ['required', 'string'],
            'descripcion' => ['required', 'string', 'max:1000'],
            'imagen'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:300'],
        ]);

        if ($request->hasFile('imagen')) { //si viene una imagen
            $rutaImagen = $request->file('imagen')->store('actividades', 'public'); //guardo la nueva imagen en esa ruta
        } else {
            $rutaImagen = null; //sino dejo null
        }

        $estados = Actividad::distinct()
            ->pluck('estado');

        Actividad::create([ //uso esa funcion del modelo para crear ese objeto con esos datos
            'titulo' => $validated['titulo'],
            'fecha' => $validated['fecha'],
            'hora' => $validated['hora'],
            'cupo' => $validated['cupo'],
            'precio' => $validated['precio'],
            'estado' => $validated['estado'],
            'descripcion' => $validated['descripcion'],
            'imagen' => $rutaImagen,
        ]);

        return redirect()->route('actividades.index', compact('estados')) //redirijo al index y acá paso un coso que es de session de laravel donde puedo mostrar el mensaje de exito por la carga del objeto, esta parte sigue en el index
            ->with('exito', '¡Actividad agregada con éxito!');
    }


    /**
     *esta funcion la uso para mostrarle al usuario en el formulario los datos de ese objeto a modificar
     */
    public function edit($id)
    {
        $actividad = Actividad::findOrFail($id); //acá traeria toda la data de ese objeto
        $estados = Actividad::distinct()
            ->pluck('estado'); //asi hago que me traiga todos los estados sin repetir y mostrando solo 'activa' y eso
        return view('actividades.edit', [ //esto es lo que paso a la vista
            'actividad' =>  $actividad,
            'estados' => $estados,
        ]);
    }

    /**
     *esta funcion la uso para guardar los datos modificados
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $actividad = Actividad::findOrFail($id); //uso el id del parametro para buscar ese objeto

        $validated = $request->validate([ //valido como en el store
            'titulo'      => ['required',
            'string',
            'max:150',
            Rule::unique('actividades', 'titulo'),],
            'fecha'       => ['nullable', 'date'],
            'hora'        => ['nullable', 'date_format:H:i'],
            'cupo'        => ['integer', 'min:1'],
            'precio'      => ['numeric', 'min:0'],
            'estado'       => ['string'],
            'descripcion' => ['string', 'max:1000'],
            'imagen'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:300'],
        ]);

        if ($request->hasFile('imagen')) { //si viene una imagen por parametro
            if ($actividad->imagen && Storage::disk('public')->exists($actividad->imagen)) { //tengo que borrar la anterior que estaba cargada para reemplazarla con la nueva
                Storage::disk('public')->delete($actividad->imagen);
            }

            $validated['imagen'] = $request->file('imagen')->store('actividades', 'public'); //valido y guardo la imagen subida en el form
        }

        $actividad->update($validated); //uso la funcion del modelo para subir los datos editados

        return redirect()->route('actividades.show', $actividad->id) //redirijo al show y acá paso un coso que es de session de laravel donde puedo mostrar el mensaje de exito por la carga del objeto, esta parte sigue en el show
            ->with('exito', '¡Actividad editada con éxito!');
    }


    /**
     *esta funcion la uso para hacer un borrado del objeto(el borrado en su profundidad es logico)
     */
    public function delete($id)
    {
        $actividad = Actividad::findOrFail($id); //encuentro el objeto necesario
        if ($actividad->imagen && Storage::disk('public')->exists($actividad->imagen)) { //si ese objeto tiene una imagen
            Storage::disk('public')->delete($actividad->imagen); //borro la imagen
        }
        $actividad->delete(); //borro el objeto
        return redirect()->route('actividades.index') //redirijo al index y acá paso un coso que es de session de laravel donde puedo mostrar el mensaje de exito por la carga del objeto, esta parte sigue en el index
            ->with('deleted', '¡Actividad borrada con éxito!');
    }


    /**
     *esta funcion la uso para hacer la busqueda de una actividad
     */
    public function search(Request $request)
    {
        $tituloBuscado = $request->input('buscar', ''); //desde la vista recupero el titulo o lo dejo como vacio x las dudas
        $estados = Actividad::distinct()
            ->pluck('estado'); //asi hago que me traiga todos los estados sin repetir y mostrando solo 'activa' y eso
        $resultados = Actividad::where('titulo', 'LIKE', "%{$tituloBuscado}%")
            ->orderBy('fecha', 'desc')
            ->get(); //acá hago una query por titulo y fecha/hora
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

        $resultados = Actividad::where('estado', 'ACTIVA') //esta es la query que me pide el ejercicio
            ->where('fecha', '>=', today())
            ->where('cupo', '>', 0)
            ->orderBy('fecha', 'asc')
            ->orderBy('hora', 'asc')
            ->get();
        $estados = Actividad::distinct() //esto es para que me muestre los estados sin repetir
            ->pluck('estado');
        return view('actividades.next', [ //estos son los datos que necesito pasarle a la vista porq los va a necesitar
            'actividades' => $resultados,
            'estados' => $estados,
            'activeFilter' => 'todos',
            'modelo' => new Actividad(),
        ]);
    }
}
