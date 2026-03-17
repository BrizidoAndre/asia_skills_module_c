<?php

namespace App\Http\Controllers;

use App\Base\ApiResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use Auth;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only(['username', 'password']))) {
            auth()->user()->update([
                'token' => md5(strtolower(auth()->user()->username)),
            ]);
            return ApiResponse::defaultResponse(200, auth()->user());
        }
        ApiResponse::errorResponse(400, 'Login failed');
    }

    public function register(RegisterRequest $request)
    {
        $created = User::create([
            ...$request->validated(),
            'password_hash' => bcrypt($request->validated('password')),
            'role' => 'user'
        ]);
        return ApiResponse::defaultResponse(201, new RegisterResource($created));
    }

    public function logout()
    {
        $user = auth()->user();
        auth()->logout();
        $user->update([
            'token' => null,
        ]);
        return ApiResponse::response(200, [
            'success' => true,
        ]);
    }
}
