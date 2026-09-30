<?php

//!!!muchas de las funciones están copiadas del repo de la profe Clau !!!

namespace App\Http\Controllers;

use App\Models\ReseniaLibroModel;
use App\Models\LibroModelo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse; //importa la clase encargada de manejar las redirecciones HTTP
use Illuminate\Http\Request; //es una instrucción que importa la clase Request para poder manejar y obtener toda la información de la petición HTTP que un usuario o cliente envía, o sea con esto no seria necesario el data_submitted
use Illuminate\Validation\Rule; //declaración de importación en PHP para usar el objeto de utilidades de validación avanzado del Laravel Framework
use Illuminate\View\View; //declaración de importación en PHP que permite usar la clase concreta de vistas (Illuminate\View\View) dentro de un archivo en el framework Laravel, asumo que sirve ya que el controlador se comunica directamente con la vista

class ReseniaLibroController extends Controller
{
    //voy a instanciar igual los atributos y el constructor
    private ReseniaLibroModel $modelo; //atributo

    public function __construct()
    {
        $this->modelo = new ReseniaLibroModel();
    }

    public function index($libro_id): View
    {
        //acá yo le paso como parametro el id de la libro que quiero buscar y mostrar su nombre
        $resenias = $this->modelo->buscarReseniaXlibro($libro_id); //voy a esa funcion del modelo

        $libroModelo = new LibroModelo();
        $libro = $libroModelo->obtenerPorId($libro_id); //recupero el id de esa libro

        return view('reseniasLibros.index', [ //estos son los datos que le quiero pasar a la vista
            'titulo'      => "Reseñas de " . ($libro['titulo'] ?? ''),
            'libro'    => $libro,
            'resenias'    => $resenias,
            'libro_id' => $libro_id,
            'modelo'      => $this->modelo,
        ]);
    }

    public function create($libro_id): View
    {
        //esto retorna a la vista
        return view('reseniasLibros.create', compact('libro_id'));
    }

    public function store(Request $request): RedirectResponse
    {
        //acá la profe usa los datos que vienen por parametro(o sea los que vendria antiguamente por data_submitted) y usa una funcion de laravel para fijar validaciones a cada campo
        $validated = $request->validate([ //valido la info que entra
            'nombreUsuario' => ['required', 'string', 'max:50'],
            'comentario' => ['required', 'string', 'max:1000'],
            'puntaje' => ['required', 'integer', 'min:1', 'max:5']
        ]);
        $idLibro = $request->input('libro_id'); //recupero el id de la libro asociada que entra en los datos del arreglo
        $this->modelo->agregar([ //agrego estos datos a la funcion que está en la memoria
            'nombreUsuario' => $validated['nombreUsuario'],
            'comentario' => $validated['comentario'],
            'puntaje' => (int) $validated['puntaje'],
            'idLibro' => (int) $idLibro
        ]);

        return redirect()->route('libros.show', $libro['id'] ?? $idLibro); //redirige a la vista de ese libro
    }


    /**
     *por ahora se llama así, después lo tengo que cambiar a algo más inglés
     * esta funcion la uso para filtrar las reseñas q pertenecen auna peli usando una funcion del modelo
     * entra el id de la libro
     *retorno un array vacio o lleno de las reseñas filtradas
     */
    public function buscarReseniaXlibro($idLibro)
    {
        $reseniasFiltradas = $this->modelo->buscarReseniaXlibro($idLibro); //voy a esta funcion del modelo a buscar un arreglo que solo tiene las reseñas cuyos idLibro coinciden con el que entra por parámetro

        return view('reseniasLibros.index', compact('reseniasFiltradas'));//retorno en la vista las reseñas filtradas
    }
}
