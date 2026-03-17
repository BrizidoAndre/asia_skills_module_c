<?php

namespace App\Http\Middleware;

use App\Base\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role === 'admin') {
            return $next($request);
        }
        ApiResponse::errorResponse(403, 'Admin access required');
    }
}
