<?php

namespace App\Policies;

use App\Models\Pelicula;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PeliculaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pelicula $pelicula): bool
    {
        return false;
    }

    /**
     * esto es una policy para que solo el admin pueda crear peliculas
     */
    public function create(User $user): bool
    {
        // Retorna true solo si el rol del usuario es 'admin'
        return $user->rol === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pelicula $pelicula): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pelicula $pelicula): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pelicula $pelicula): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pelicula $pelicula): bool
    {
        return false;
    }
}
