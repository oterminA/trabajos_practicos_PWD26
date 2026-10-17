<?php

use App\Http\Controllers\ActividadController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/actividades');

// Punto de partida resuelto. El resto de las rutas forma parte de la Etapa 1.
Route::get('/actividades', [ActividadController::class, 'index'])->name('actividades.index');
Route::get('/actividades-inicio', [ActividadController::class, 'index'])->name('actividades.index');
Route::get('/actividades-detalle/{id}', [ActividadController::class, 'show'])->name('actividades.show');
Route::delete('/actividades-eliminar/{id}', [ActividadController::class, 'delete'])->name('actividades.delete');
Route::get('/actividades-agregar', [ActividadController::class, 'create'])->name('actividades.create');
Route::post('/actividades-guardar', [ActividadController::class, 'store'])->name('actividades.store');
Route::get('/actividades-editar/{id}', [ActividadController::class, 'edit'])->name('actividades.edit');
Route::put('/actividades-guardar-editado/{id}', [ActividadController::class, 'update'])->name('actividades.update');
Route::get('/actividades-buscar', [ActividadController::class, 'search'])->name('actividades.search');
Route::get('/actividades-filtrar-estado', [ActividadController::class, 'index'])->name('actividades.index');
Route::get('/actividades-proximas', [ActividadController::class, 'filter'])->name('actividades.next');
