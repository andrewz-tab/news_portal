<?php

namespace App\Policies;

use App\Models\CV;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CVPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CV $cv): bool
    {
        return $user->hasPermissionTo('cv.view.' . $cv->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('cv.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CV $cv): bool
    {
        return $user->hasPermissionTo('cv.update.' . $cv->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CV $cv): bool
    {
        return $user->hasPermissionTo('cv.delete.' . $cv->id);
    }

    public function accept(User $user)
    {
        return $user->hasPermissionTo('cv.accept');
    }

    public function refuse(User $user)
    {
        return $user->hasPermissionTo('cv.refuse');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CV $cv): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CV $cv): bool
    {
        //
    }
}
