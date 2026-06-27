<?php

namespace App\Policies;

use App\Models\Contacts;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Contacts $contact)
    {
        return $user->id === $contact->created_by;
    }

    public function update(User $user, Contacts $contact)
    {
        return $user->id === $contact->created_by;
    }

    public function delete(User $user, Contacts $contact)
    {
        return $user->id === $contact->created_by;
    }
}
