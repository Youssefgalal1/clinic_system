<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
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
    public function view(User $user, Appointment $appointment): bool
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
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, Appointment $appointment): bool
    {
        return $authUser->id == $appointment->doctor_id
        || $authUser->id == $appointment->user_id
        || $authUser->role === 'admin' ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Appointment $appointment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Appointment $appointment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Appointment $appointment): bool
    {
        return false;
    }

    public function confirm(User $user,Appointment $appointment): bool
    {
    return $user->role === 'admin'|| $user->id == $appointment->doctor_id;
    }

    public function complete(User $user,Appointment $appointment): bool
    {
        return $user->role === "admin" || $user->id == $appointment->doctor_id;
    }

    public function cancel(User $user,Appointment $appointment): bool
    {
        return $user->role === "admin" 
        || $user->id == $appointment->doctor_id 
        || $user->id == $appointment->user_id;
    }
}
