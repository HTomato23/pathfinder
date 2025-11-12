<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();

        // Administrator can access everything
        if ($admin->role === 'Administrator') {
            return $next($request);
        }

        // Consultant cannot access client, control, model, and blogs routes
        if ($admin->role === 'Consultant' && (
            $request->is('admin/dashboard/control*') ||
            $request->is('admin/dashboard/model*')
        )) {
            abort(403, 'Unauthorized access.');
        }

        // Blog Moderator can only access blogs routes
        if ($admin->role === 'Blog Moderator' && (
            $request->is('admin/dashboard/client') ||
            $request->is('admin/dashboard/control*') ||
            $request->is('admin/dashboard/consultation*') ||
            $request->is('admin/dashboard/model*') || 
            $request->is('admin/dashboard/predict*')
        )) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
