<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'super_admin', 'inventory_manager', 'delivery_agent', 'delivery'])) {
             // For simplicity, any non-user is admin-ish, or check specific 'admin' capability.
             // The requirement asked for multiple roles. We can have granular middleware or one logical one.
             // Let's assume 'AdminMiddleware' protects the /admin routes, so it allows any staff.
             abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
