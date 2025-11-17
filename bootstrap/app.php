<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust all proxies (for Railway deployment)
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'admin.verified' => \App\Http\Middleware\EnsureAdminEmailIsVerified::class,
            'role.check' => \App\Http\Middleware\RoleCheckAccess::class,
            'guest.admin' => \App\Http\Middleware\RedirectifAdminAuthenticated::class,
            'guest.client' => \App\Http\Middleware\RedirectifClientAuthenticated::class,
            'admin.disabled' => \App\Http\Middleware\RedirectifDisabledAdminAccount::class,
            'client.disabled' => \App\Http\Middleware\RedirectifDisabledClientAccount::class,
            'assessment.access' => \App\Http\Middleware\CheckAssessmentAccess::class,
            'summary' => \App\Http\Middleware\CheckSummary::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle throttle exceptions for login
        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if ($request->is('login') || $request->is('/')) {
                $seconds = $e->getHeaders()['Retry-After'] ?? 60;
                $minutes = ceil($seconds / 60);

                return back()->withErrors([
                    'email' => "Too many login attempts. Please try again in {$minutes} minute(s)."
                ])->withInput($request->only('email'));
            }
        });
    })->create();
