<?php

namespace App\Http\Controllers;

use App\Models\LibroModelo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse; //importa la clase encargada de manejar las redirecciones HTTP
use Illuminate\Http\Request; //es una instrucción que importa la clase Request para poder manejar y obtener toda la información de la petición HTTP que un usuario o cliente envía, o sea con esto no seria necesario el data_submitted
use Illuminate\Validation\Rule; //declaración de importación en PHP para usar el objeto de utilidades de validación avanzado del Laravel Framework
use Illuminate\View\View; //declaración de importación en PHP que permite usar la clase concreta de vistas (Illuminate\View\View) dentro de un archivo en el framework Laravel, asumo que sirve ya que el controlador se comunica directamente con la vista

class LibroController extends Controller
{
    //voy a instanciar igual los atributos y el constructor
    private LibroModelo $modelo; //atributo

    public function __construct()
    {
        $this->modelo = new LibroModelo();
    }

    public function index(Request $request): View
    {
        //acá reviso que existan genero y autor como conceptos antes de ir a buscarlos para el select
        $autor = $request->input('autor');
        $genero = $request->input('genero');

        if ($autor !== '' & $autor !== null) {
            $libros = $this->modelo->obtenerPorAutor($autor);
        }elseif($genero !== '' & $genero !== null) {
            $libros = $this->modelo->obtenerPorGenero($genero);
        }else{
            $libros = $this->modelo->obtenerTodos();
        }

        //esto es lo que se quiere mostrar rn la vista ya que todo esto es lo que se retorna al view
        return view('libros.index', [
            'libros'    => $libros,
            'generos'      => $this->modelo->obtenerGeneros(), //IMPORTANTE no olvidarse de esooooooo,esto es lo que hace q se carguen los generos y me lo estaba olvidando otra veeeeeeeeez
            'autores'      => $this->modelo->obtenerAutores(),
            'titulo'       => 'Catálogo de libros',
            'activeFilter' => 'todas',
            'modelo'       => $this->modelo,
        ]);
    }

    public function show(int $id): View
    {
        //esto es para mostrar el detalle de una libro en especifico y por eso se usa el ide para buscarla y retornar la info de esa peli a la vista
        return view('libros.show', [
            'libro' => $this->modelo->obtenerPorId($id),
            'modelo' => $this->modelo,
        ]);
    }

    public function create(): View
    {
        //esto retorna a la vista y además fija un limite de años que después se usa en las view(no sé porqué es importante hacerlo así)
        return view('libros.create', [
            'maxYear' => now()->year + 5,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        //acá la profe usa los datos que vienen por parametro(o sea los que vendria antiguamente por data_submitted) y usa una funcion de laravel para fijar validaciones a cada campo
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'autor' => ['required', 'string', 'max:100'],
            'genero' => ['required', 'string', 'max:80'],
            'anio' => ['required', 'integer', 'min:1895', 'max:' . (now()->year + 5)],
            'sinopsis' => ['required', 'string', 'max:1000'],
            'imagen' => [
                'required',
                'image',
                Rule::file()->types(['jpg', 'jpeg', 'png', 'webp'])->max('300kb'),
            ], //con esto entiendo que se hace toda la validacion que antes de hacia con una funcion propia en $guardarImagen
        ]);

        $this->modelo->agregar([
            'titulo' => $validated['titulo'],
            'autor' => $validated['autor'],
            'genero' => $validated['genero'],
            'anio' => (int) $validated['anio'],
            'sinopsis' => $validated['sinopsis'],
        ], $request->file('imagen'));

        return redirect()->route('libros.index'); //redirige al inicio
    }

    /**
     * por ahora se llama así, después lo tengo que cambiar a algo más inglés
     *
     * esta funcion consulta al modelo y trae los datos existentes de la libro que se quiere editar
     * recibe el id de la libro a mostrar
     */
    public function mostrarDatosEdicion($id)
    {
        $libro = $this->modelo->obtenerPorId($id);
        //ver si es necesario hacer acá un error por si no existe la peli

        $url = !empty($libro['imagen']) ? Storage::url($libro['imagen']) : null;
        $maxYear = date('Y');
        return view('libros.edit', compact('libro', 'url', 'maxYear')); //esto es lo que paso a la vista para despues rellenar los inputs con los datos existentes
    }

    /**
     * por ahora se llama así, después lo tengo que cambiar a algo más inglés
     * esta funcion recibe los nuevos y opcionales datos y los manda al modelo para modificar el json
     * recibe un arreglo por post de los datos de la libro
     */
    public function guardarDatosEditados(Request $request, $id)
    {
        //usando esa funcion puedo poner creo que las validaciones que yo quiera
        $validated = $request->validate([
            'titulo'      => ['required', 'string', 'max:120'],
            'autor'      => ['required', 'string', 'max:100'],
            'genero'      => ['required', 'string', 'max:80'],
            'anio'        => ['required', 'integer', 'min:1895', 'max:' . (now()->year + 5)],
            'sinopsis' => ['required', 'string', 'max:1000'],
            'imagen'      => [
                'image',
                Rule::file()->types(['jpg', 'jpeg', 'png', 'webp'])->max('300kb'),
            ],
        ]);

        //lo mando a esta funcion del modelo para guardar los datos
        $exito = $this->modelo->editarExistentes(
            $id,
            [
                'titulo'      => $validated['titulo'],
                'autor'      => $validated['autor'],
                'genero'      => $validated['genero'],
                'anio'        => (int) $validated['anio'],
                'sinopsis' => $validated['sinopsis'],
            ],
            $request->file('imagen')
        );

        if (!$exito) { //porsi no se puede
            abort(404, 'No se pudo editar.');
        }
        //redirijo al 'ver detalle' pero de esa libro exactamente
        return redirect()->route('libros.show', ['id' => $id]);
    }

    /**
     * por ahora se llama así, después lo tengo que cambiar a algo más inglés
     * esta funcion llama a una del modelo para borrar la libro elegida
     * recibe el id de la libro a borrar
     * retorna nada porque la libro fue borrada
     */
    public function delete($id)
    {
        //a esa funcion del modelo le paso el id que quiero borrar
        $exito = $this->modelo->delete((int) $id);
        if (!$exito) {
            abort(404, 'No se pudo eliminar.');
        }
        return redirect()->route('libros.index'); //redirijo al index
    }

    /**
     *por ahora se llama así, después lo tengo que cambiar a algo más inglés
     * esta funcion la uso para buscar una libro
     * entra el titulo de la libro
     *retorno la libro buscada o vacio si no hay nada
     */
    public function buscar(Request $request)
    {
        //REVISAR si tengo que hacer validaciones acá
        $tituloBuscado = $request->input('buscar', ''); //desde la vista recupero el titulo o lo dejo como vacio x las dudas
        $resultados = $this->modelo->buscar($tituloBuscado); //traigo todos los datos de ese titulo

        return view('libros.index', [ //estos son los datos que necesito pasarle a la vista porq los va a necesitar
            'libros'    => $resultados,
            'generos'      => $this->modelo->obtenerGeneros(), //lo mismo que en la funcion index, esto tiene que estar
            'autores'      => $this->modelo->obtenerAutores(),
            'titulo'       => 'Resultados para la búsqueda: "' . $tituloBuscado . '"',
            'activeFilter' => 'busqueda',
            'modelo'       => $this->modelo,
        ]);
    }
}
