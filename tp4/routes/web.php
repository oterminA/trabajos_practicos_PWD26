<?php

use App\Http\Controllers\LibroController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\ReseniaController;
use App\Http\Controllers\ReseniaLibroController;
use Illuminate\Support\Facades\Route;

//LAS URL+METODO HTTP NO SE PUEDEN REPETIR!!!!

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


//para reseñas de PELICULAS
Route::get('/resenias-pelicula', [ReseniaController::class, 'index'])->name('resenias.index');
Route::get('/resenias-pelicula/crear/{pelicula_id}', [ReseniaController::class, 'create'])->name('resenias.create');
Route::post('/resenias-pelicula', [ReseniaController::class, 'store'])->name('resenias.store');
Route::get('/resenias-pelicula/{pelicula_id}', [ReseniaController::class, 'index'])->name('resenias.show');


//para libros
Route::get('/libros', [LibroController::class, 'index'])->name('libros.index');
Route::get('/libros-genero', [LibroController::class, 'index'])->name('libros.inicio');
Route::get('/libros/buscar', [LibroController::class, 'buscar'])->name('libros.buscar');
Route::get('/libros/crear', [LibroController::class, 'create'])->name('libros.create');
Route::post('/libros', [LibroController::class, 'store'])->name('libros.store');
Route::get('/libros/{id}', [LibroController::class, 'show'])->name('libros.show');
Route::get('/libros/{id}/editar', [LibroController::class, 'mostrarDatosEdicion'])->name('libros.edit');
Route::put('/libros/{id}', [LibroController::class, 'guardarDatosEditados'])->name('libros.update');
Route::delete('/libros/{id}', [LibroController::class, 'delete'])->name('libros.delete');


//para reseñas de LIBROS
Route::get('/resenias', [ReseniaLibroController::class, 'index'])->name('reseniasLibros.index');
Route::get('/resenias-libros/crear/{libro_id}', [ReseniaLibroController::class, 'create'])->name('reseniasLibros.create');
Route::post('/resenias-libro', [ReseniaLibroController::class, 'store'])->name('reseniasLibros.store');
Route::get('/resenias-libros/{libro_id}', [ReseniaLibroController::class, 'index'])->name('reseniasLibros.show');
