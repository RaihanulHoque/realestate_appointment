<?php

namespace App\Policies;

use App\Models\Appointments;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Appointments $appointment)
    {
        return $user->id === $appointment->user_id;
    }

    public function update(User $user, Appointments $appointment)
    {
        return $user->id === $appointment->user_id;
    }

    public function delete(User $user, Appointments $appointment)
    {
        return $user->id === $appointment->user_id;
    }
}
