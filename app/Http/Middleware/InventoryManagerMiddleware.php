<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class InventoryManagerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'inventory_manager') {
             // Allows super admin too? Usually yes.
             if (in_array(Auth::user()->role, ['admin', 'super_admin'])) {
                 return $next($request);
             }
            abort(403, 'Inventory Manager access required.');
        }

        return $next($request);
    }
}
