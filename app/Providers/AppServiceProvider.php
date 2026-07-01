<?php

namespace App\Providers;

use App\Models\Appointments;
use App\Models\Contacts;
use App\Policies\AppointmentPolicy;
use App\Policies\ContactPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Contacts::class, ContactPolicy::class);
        Gate::policy(Appointments::class, AppointmentPolicy::class);
    }
}
