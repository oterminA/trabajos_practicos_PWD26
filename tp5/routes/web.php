<?php

use App\Http\Controllers\LibroController;
use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\ReseniaPeliculaController;
use App\Http\Controllers\ReseniaLibroController;
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
Route::get('/resenias-pelicula', [ReseniaPeliculaController::class, 'index'])->name('resenias.index');
Route::get('/resenias-pelicula/crear/{pelicula_id}', [ReseniaPeliculaController::class, 'create'])->name('resenias.create');
Route::post('/resenias-pelicula/guardar/{pelicula_id}', [ReseniaPeliculaController::class, 'store'])->name('resenias.store');
Route::get('/resenias/{pelicula_id}', [ReseniaPeliculaController::class, 'index'])->name('resenias.inicio');


//para libros
Route::get('/libros', [LibroController::class, 'index'])->name('libros.index');
Route::get('/libros-genero', [LibroController::class, 'index'])->name('libros.inicio');
Route::get('/libros/buscar', [LibroController::class, 'search'])->name('libros.buscar');
Route::get('/libros/crear', [LibroController::class, 'create'])->name('libros.create');
Route::post('/libros', [LibroController::class, 'store'])->name('libros.store');
Route::get('/libros/{id}', [LibroController::class, 'show'])->name('libros.show');
Route::get('/libros/{id}/editar', [LibroController::class, 'edit'])->name('libros.edit');
Route::put('/libros/{id}', [LibroController::class, 'update'])->name('libros.update');
Route::delete('/libros/{id}', [LibroController::class, 'destroy'])->name('libros.delete');


//para reseñas de LIBROS
Route::get('/resenias-libros', [ReseniaLibroController::class, 'index'])->name('reseniasLibros.index');
Route::get('/resenias-libros/crear/{libro_id}', [ReseniaLibroController::class, 'create'])->name('reseniasLibros.create');
Route::post('/resenias-libro/guardar/{libro_id}', [ReseniaLibroController::class, 'store'])->name('reseniasLibros.store');
Route::get('/resenias/ver/{libro_id}', [ReseniaLibroController::class, 'index'])->name('reseniasLibros.inicio');
