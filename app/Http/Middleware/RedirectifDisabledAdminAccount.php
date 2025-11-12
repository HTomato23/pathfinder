<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectifDisabledAdminAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('admin')->check()) {

            $admin = Auth::guard('admin')->user();

            // If status is disabled
            if ($admin->status === 'Disabled') {
                Auth::guard('admin')->logout(); // destroy session

                // Optionally invalidate session and regenerate token
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('show.login')->with('error', 'Your account has been disabled by an administrator.');
            }
        }

        return $next($request);
    }
}
