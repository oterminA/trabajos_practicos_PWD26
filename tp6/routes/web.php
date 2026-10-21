<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\ReseniaController;
use App\Http\Controllers\ReseniaLibroController;
use App\Models\Actor;
use Illuminate\Support\Facades\Route;

//LAS URL+METODO HTTP NO SE PUEDEN REPETIR!!!!

///get     -> STORE, INDEX, SHOW,
///delete  -> DELETE
///put     -> UPDATE
///post    -> CREATE, EDIT

//para peliculas
Route::get('/', [PeliculaController::class, 'index'])->name('peliculas.index');
Route::get('/peliculas/buscar', [PeliculaController::class, 'search'])->name('peliculas.buscar');
Route::get('/peliculas/crear', [PeliculaController::class, 'create'])->name('peliculas.create');
Route::post('/peliculas', [PeliculaController::class, 'store'])->name('peliculas.store');
Route::get('/peliculas/{id}', [PeliculaController::class, 'show'])->name('peliculas.show');
Route::get('/peliculas/{id}/editar', [PeliculaController::class, 'edit'])->name('peliculas.edit');
Route::put('/peliculas/{id}', [PeliculaController::class, 'update'])->name('peliculas.update');
Route::delete('/peliculas/{id}', [PeliculaController::class, 'destroy'])->name('peliculas.delete'); //ESTO no funcionó hasta que usé delete en lugar de put!!!!!


//para reseñas de PELICULAS
Route::get('/resenias-pelicula', [ReseniaController::class, 'index'])->name('resenias.index');
Route::get('/resenias-pelicula/crear/{pelicula_id}', [ReseniaController::class, 'create'])->name('resenias.create');
Route::post('/resenias-pelicula/guardar/{pelicula_id}', [ReseniaController::class, 'store'])->name('resenias.store');
Route::get('/resenias/{pelicula_id}', [ReseniaController::class, 'index'])->name('resenias.inicio');


//para actors
Route::get('/actores/crear/', [ActorController::class, 'create'])->name('actors.create');
Route::post('/actores', [ActorController::class, 'store'])->name('actors.store');


