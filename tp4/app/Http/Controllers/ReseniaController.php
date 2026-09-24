<?php

//!!!muchas de las funciones están copiadas del repo de la profe Clau !!!

namespace App\Http\Controllers;

use App\Models\ReseniaModel;
use App\Models\PeliculaModelo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse; //importa la clase encargada de manejar las redirecciones HTTP
use Illuminate\Http\Request; //es una instrucción que importa la clase Request para poder manejar y obtener toda la información de la petición HTTP que un usuario o cliente envía, o sea con esto no seria necesario el data_submitted
use Illuminate\Validation\Rule; //declaración de importación en PHP para usar el objeto de utilidades de validación avanzado del Laravel Framework
use Illuminate\View\View; //declaración de importación en PHP que permite usar la clase concreta de vistas (Illuminate\View\View) dentro de un archivo en el framework Laravel, asumo que sirve ya que el controlador se comunica directamente con la vista

class ReseniaController extends Controller
{
    //voy a instanciar igual los atributos y el constructor
    private ReseniaModel $modelo; //atributo

    public function __construct()
    {
        $this->modelo = new ReseniaModel();
    }

    public function index($pelicula_id): View
    {
        $resenias = $this->modelo->buscarReseniaXPelicula($pelicula_id); //voy a esa funcion del modelo

        $peliculaModelo = new PeliculaModelo();
        $pelicula = $peliculaModelo->obtenerPorId($pelicula_id);

        return view('resenias.index', [
            'titulo'      => "Reseñas de " . ($pelicula['titulo'] ?? ''),
            'pelicula'    => $pelicula,
            'resenias'    => $resenias,
            'pelicula_id' => $pelicula_id,
            'modelo'      => $this->modelo,
        ]);
    }

    public function create($pelicula_id): View
    {
        //esto retorna a la vista y además fija un limite de años que después se usa en las view(no sé porqué es importante hacerlo así)
        return view('resenias.create', compact('pelicula_id'));
    }

    public function store(Request $request): RedirectResponse
    {
        //acá la profe usa los datos que vienen por parametro(o sea los que vendria antiguamente por data_submitted) y usa una funcion de laravel para fijar validaciones a cada campo
        $validated = $request->validate([
            'nombreUsuario' => ['required', 'string', 'max:50'],
            'comentario' => ['required', 'string', 'max:1000'],
            'puntaje' => ['required', 'integer', 'min:1', 'max:5']
        ]);
        $idPelicula = $request->input('pelicula_id');
        $this->modelo->agregar([
            'nombreUsuario' => $validated['nombreUsuario'],
            'comentario' => $validated['comentario'],
            'puntaje' => (int) $validated['puntaje'],
            'idPelicula' => (int) $idPelicula
        ]);

        return redirect()->route('peliculas.show', $pelicula['id'] ?? $idPelicula); //redirige a la vista de esa peli
    }


    /**
     *por ahora se llama así, después lo tengo que cambiar a algo más inglés
     * esta funcion la uso para filtrar las reseñas q pertenecen auna peli usando una funcion del modelo
     * entra el id de la pelicula
     *retorno un array vacio o lleno de las reseñas filtradas
     */
    public function buscarReseniaXPelicula($idPelicula)
    {
        $reseniasFiltradas = $this->modelo->buscarReseniaXPelicula($idPelicula);

        return view('resenias.index', compact('reseniasFiltradas'));
    }
}
