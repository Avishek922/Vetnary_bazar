<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class DeliveryAgentMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['delivery_agent', 'delivery'])) {
            if (Auth::check() && in_array(Auth::user()->role, ['admin', 'super_admin'])) {
                return $next($request);
            }
            abort(403, 'Delivery Agent access required.');
        }

        return $next($request);
    }
}
