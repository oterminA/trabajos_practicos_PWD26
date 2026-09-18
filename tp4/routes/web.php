<?php

use App\Http\Controllers\PeliculaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PeliculaController::class, 'index'])->name('peliculas.index');

Route::get('/peliculas/ciencia-ficcion', [PeliculaController::class, 'cienciaFiccion'])->name('peliculas.ciencia-ficcion');

Route::get('/peliculas/nueva', [PeliculaController::class, 'create'])->name('peliculas.create');

Route::post('/peliculas', [PeliculaController::class, 'store'])->name('peliculas.store');

Route::get('/peliculas/{id}', [PeliculaController::class, 'show'])
    ->whereNumber('id')
    ->name('peliculas.show');

Route::get('/peliculas/buscador', [PeliculaController::class, 'buscar'])->name('peliculas.buscar');

Route::get('/peliculas/editar/{id}', [PeliculaController::class, 'mostrarDatosEdicion'])
    ->whereNumber('id')
    ->name('peliculas.edit');

Route::post('/peliculas/guardar-edicion/{id}', [PeliculaController::class, 'guardarDatosEditados'])
    ->whereNumber('id')
    ->name('peliculas.update');

Route::delete('/peliculas/eliminar/{id}', [PeliculaController::class, 'delete'])->name('peliculas.destroy');
