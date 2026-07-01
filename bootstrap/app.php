<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Provide a plain path so the built-in Authenticate middleware does not
        // call route('login') — which would crash since this is an API-only app
        // with no named 'login' web route. The /login path itself is never
        // followed because the exception renderer below intercepts first.
        $middleware->redirectGuestsTo('/login');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // This is an API-only app — always return JSON 401, never redirect.
        $exceptions->render(function (AuthenticationException $e, \Illuminate\Http\Request $request) {
            return response()->json(['message' => $e->getMessage()], 401);
        });
    })
    ->create();
