<?php

//!!!muchas de las funciones están copiadas del repo de la profe Clau !!!

namespace App\Http\Controllers;

use App\Models\PeliculaModelo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse; //importa la clase encargada de manejar las redirecciones HTTP
use Illuminate\Http\Request; //es una instrucción que importa la clase Request para poder manejar y obtener toda la información de la petición HTTP que un usuario o cliente envía, o sea con esto no seria necesario el data_submitted
use Illuminate\Validation\Rule; //declaración de importación en PHP para usar el objeto de utilidades de validación avanzado del Laravel Framework
use Illuminate\View\View; //declaración de importación en PHP que permite usar la clase concreta de vistas (Illuminate\View\View) dentro de un archivo en el framework Laravel, asumo que sirve ya que el controlador se comunica directamente con la vista

class PeliculaController extends Controller
{
    //voy a instanciar igual los atributos y el constructor
    private PeliculaModelo $modelo; //atributo

    public function __construct()
    {
        $this->modelo = new PeliculaModelo();
    }

    public function index(Request $request): View
    {
        if ($request->has('genero') && $request->get('genero') !== null) {
            $peliculas = $this->modelo->obtenerPorGenero($request->get('genero'));
        } else {
            $peliculas = $this->modelo->obtenerTodas();
        }

        //esto es lo que se quiere mostrar rn la vista ya que todo esto es lo que se retorna al view
        return view('peliculas.index', [
            'peliculas'    => $peliculas,
            'generos'      => $this->modelo->obtenerGeneros(), //IMPORTANTE no olvidarse de esooooooo,esto es lo que hace q se carguen los generos y me lo estaba olvidando otra veeeeeeeeez
            'titulo'       => 'Catálogo de películas',
            'activeFilter' => 'todas',
            'modelo'       => $this->modelo,
        ]);
    }

    public function show(int $id): View
    {
        //esto es para mostrar el detalle de una pelicula en especifico y por eso se usa el ide para buscarla y retornar la info de esa peli a la vista
        return view('peliculas.show', [
            'pelicula' => $this->modelo->obtenerPorId($id),
            'modelo' => $this->modelo,
        ]);
    }

    public function create(): View
    {
        //esto retorna a la vista y además fija un limite de años que después se usa en las view(no sé porqué es importante hacerlo así)
        return view('peliculas.create', [
            'maxYear' => now()->year + 5,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        //acá la profe usa los datos que vienen por parametro(o sea los que vendria antiguamente por data_submitted) y usa una funcion de laravel para fijar validaciones a cada campo
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'genero' => ['required', 'string', 'max:80'],
            'anio' => ['required', 'integer', 'min:1895', 'max:' . (now()->year + 5)],
            'descripcion' => ['required', 'string', 'max:1000'],
            'imagen' => [
                'required',
                'image',
                Rule::file()->types(['jpg', 'jpeg', 'png', 'webp'])->max('300kb'),
            ], //con esto entiendo que se hace toda la validacion que antes de hacia con una funcion propia en $guardarImagen
        ]);

        $this->modelo->agregar([
            'titulo' => $validated['titulo'],
            'genero' => $validated['genero'],
            'anio' => (int) $validated['anio'],
            'descripcion' => $validated['descripcion'],
        ], $request->file('imagen'));

        return redirect()->route('peliculas.index'); //redirige al inicio
    }

    /**
     * por ahora se llama así, después lo tengo que cambiar a algo más inglés
     *
     * esta funcion consulta al modelo y trae los datos existentes de la pelicula que se quiere editar
     * recibe el id de la pelicula a mostrar
     */
    public function mostrarDatosEdicion($id)
    {
        $pelicula = $this->modelo->obtenerPorId($id);
        //ver si es necesario hacer acá un error por si no existe la peli

        $url = !empty($pelicula['imagen']) ? Storage::url($pelicula['imagen']) : null;
        $maxYear = date('Y');
        return view('peliculas.edit', compact('pelicula', 'url', 'maxYear'));
    }

    /**
     * por ahora se llama así, después lo tengo que cambiar a algo más inglés
     * esta funcion recibe los nuevos y opcionales datos y los manda al modelo para modificar el json
     * recibe un arreglo por post de los datos de la pelicula
     */
    public function guardarDatosEditados(Request $request, $id)
    {
        //esto es como lo de guardar pelicula pero editando lo q ya existe
        $validated = $request->validate([
            'titulo'      => ['required', 'string', 'max:120'],
            'genero'      => ['required', 'string', 'max:80'],
            'anio'        => ['required', 'integer', 'min:1895', 'max:' . (now()->year + 5)],
            'descripcion' => ['required', 'string', 'max:1000'],
            'imagen'      => [
                'image',
                Rule::file()->types(['jpg', 'jpeg', 'png', 'webp'])->max('300kb'),
            ],
        ]);

        $exito = $this->modelo->editarExistentes(
            $id,
            [
                'titulo'      => $validated['titulo'],
                'genero'      => $validated['genero'],
                'anio'        => (int) $validated['anio'],
                'descripcion' => $validated['descripcion'],
            ],
            $request->file('imagen')
        );

        if (!$exito) { //porsi no se puede, revisar si esto lo saco o no
            abort(404, 'No se pudo editar.');
        }

        return redirect()->route('peliculas.show', ['id' => $id]);
    }

    /**
     * por ahora se llama así, después lo tengo que cambiar a algo más inglés
     * esta funcion llama a una del modelo para borrar la pelicula elegida
     * recibe el id de la pelicula a borrar
     * retorna nada porque la pelicula fue borrada
     */
    public function delete($id)
    {
        $exito = $this->modelo->delete((int) $id);
        if (!$exito) {
            abort(404, 'No se pudo eliminar.');
        }
        return redirect()->route('peliculas.index');
    }

    /**
     *por ahora se llama así, después lo tengo que cambiar a algo más inglés
     * esta funcion la uso para buscar una pelicula
     * entra el titulo de la pelicula
     *retorno la pelicula buscada o vacio si no hay nada
     */
    public function buscar(Request $request)
    {
        //REVISAR si tengo que hacer validaciones acá
        $tituloBuscado = $request->input('buscar', ''); //desde la vista recupero el titulo
        $resultados = $this->modelo->buscar($tituloBuscado); //traigo todos los datos de ese titulo

        return view('peliculas.index', [
            'peliculas'    => $resultados,
            'generos'      => $this->modelo->obtenerGeneros(),
            'titulo'       => 'Resultados para la búsqueda: "' . $tituloBuscado . '"',
            'activeFilter' => 'busqueda',
            'modelo'       => $this->modelo,
        ]);
    }

    /**
     * por ahora se llama así, después lo tengo que cambiar a algo más inglés
     * esta funcion ocupa una del modelo para filtrar los generos de las peliculas
     */
    public function mostrarGeneros()
    {
        return view('peliculas.generos', [
            'generos' => $this->modelo->obtenerGeneros(),
        ]);
    }
}
