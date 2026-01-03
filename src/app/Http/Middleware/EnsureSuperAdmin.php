<?php

namespace App\Http\Middleware;

use App\Enum\PermissionAdminEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to ensure the authenticated user is a Super Admin.
 * 
 * Super Admin is identified by having any admin permission (PermissionAdminEnum).
 * This middleware should only be used on admin.orderflow.test domain.
 */
class EnsureSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            abort(401, 'Unauthenticated.');
        }
        // Check if user is super admin (has any admin permission)
        if (!auth()->user()->hasRole('Super Admin', 'admin')) {
            abort(403, 'Access denied. Super Admin privileges required.');
        }

        return $next($request);
    }
}
