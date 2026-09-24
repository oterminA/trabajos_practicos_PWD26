<?php

use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\ReseniaController;
use Illuminate\Support\Facades\Route;

///get     -> STORE, INDEX, SHOW,
///delete  -> DELETE
///put     -> UPDATE
///post    -> CREATE, EDIT


//para peliculas
Route::get('/', [PeliculaController::class, 'index'])->name('peliculas.index');
Route::get('/peliculas/buscar', [PeliculaController::class, 'buscar'])->name('peliculas.buscar');
Route::get('/peliculas/crear', [PeliculaController::class, 'create'])->name('peliculas.create');
Route::post('/peliculas', [PeliculaController::class, 'store'])->name('peliculas.store');
Route::get('/peliculas/{id}', [PeliculaController::class, 'show'])->name('peliculas.show');
Route::get('/peliculas/{id}/editar', [PeliculaController::class, 'mostrarDatosEdicion'])->name('peliculas.edit');
Route::put('/peliculas/{id}', [PeliculaController::class, 'guardarDatosEditados'])->name('peliculas.update');
Route::delete('/peliculas/{id}', [PeliculaController::class, 'delete'])->name('peliculas.delete'); //ESTO no funcionó hasta que usé delete en lugar de put!!!!!


//para reseñas
Route::get('/resenias', [ReseniaController::class, 'index'])->name('resenias.index');
Route::get('/resenias/crear/{pelicula_id}', [ReseniaController::class, 'create'])->name('resenias.create');
Route::post('/resenias', [ReseniaController::class, 'store'])->name('resenias.store');
Route::get('/resenias/{pelicula_id}', [ReseniaController::class, 'index'])->name('resenias.show');
