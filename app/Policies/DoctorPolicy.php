<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Doctor;
use App\Models\User;

class DoctorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $authuser): bool
    {
        return $authuser->role === 'admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authuser, Doctor $doctor): bool
    {
        return $authuser->role === 'admin' || $doctor->user_id == $authuser->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $authuser): bool
    {
        return $authuser->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authuser, Doctor $doctor): bool
    {
        return $authuser->role === 'admin' || $doctor->user_id == $authuser->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authuser, Doctor $doctor): bool
    {
        return $authuser->role === 'admin' || $authuser->id !== $doctor->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Doctor $doctor): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Doctor $doctor): bool
    {
        return false;
    }
}
