<?php

namespace App\Policies;

use App\Models\Resenia;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReseniaPolicy
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
    public function view(User $user, Resenia $resenia): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * esta policy es para que solo el user dueño de la resnia o el admin la pueda modificar
     */
    public function update(User $user, Resenia $resena): bool
    {
        return $user->id === $resena->user_id || $user->rol === 'admin';
    }

    /**
     * eesta policy es para que soloel admin o dueño de la resenia la pueda borrar
     */
    public function delete(User $user, Resenia $resenia): bool
    {
        return (int) $user->id === (int) $resenia->user_id || $user->rol === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Resenia $resenia): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Resenia $resenia): bool
    {
        return false;
    }
}
