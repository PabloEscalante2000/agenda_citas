<?php

namespace App\Policies;

use App\Models\Sesion;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SesionPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isTerapeuta();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Sesion $sesion): bool
    {
        return $sesion->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sesion $sesion): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sesion $sesion): bool
    {
        return false;
    }
}
