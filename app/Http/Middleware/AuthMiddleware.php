<?php

namespace App\Http\Middleware;

use App\Base\ApiResponse;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-Authorization', false);
        if (!$token) {
            ApiResponse::errorResponse(401, 'Access Token is required');
        }
        $token = Str::replace('Bearer ', '', $token);
        $user = User::firstWhere('token', $token);
        if (!$user) {
            ApiResponse::errorResponse(401, 'Invalid Access Token');
        }
        if ($user->is_banned) {
            ApiResponse::errorResponse(403, 'User is banned');
        }
        auth()->login($user);
        return $next($request);
    }
}
