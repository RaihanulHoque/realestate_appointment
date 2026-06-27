<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * This is an API-only application with no web login view, so unauthenticated
     * requests should always get a JSON 401 rather than attempting a redirect to a
     * route that doesn't exist.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        return null;
    }
}
