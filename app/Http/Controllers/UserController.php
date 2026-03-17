<?php

namespace App\Http\Controllers;

use App\Base\ApiResponse;
use App\Base\Cursor;
use App\Http\Requests\UserUpdateRoleRequest;
use App\Http\Resources\UserBanResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserUpdateResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::applyCursor();
        $user = $user->get();
        return ApiResponse::response(200, [
            'success' => true,
            'data' => UserResource::collection($user),
            'meta' => Cursor::meta($user)
        ]);
    }

    public function update(UserUpdateRoleRequest $request, User $user)
    {
        if ($user->is_banned) {
            ApiResponse::errorResponse(409, 'Banned user update failed');
        }
        $admins = User::where('role', 'admin')->get();
        if ($admins->count() === 1 && $admins->first()->is($user)) {
            ApiResponse::errorResponse(403, 'Last admin demotion forbidden');
        }
        $user->update($request->only('role'));
        return ApiResponse::defaultResponse(200, new UserUpdateResource($user));
    }

    public function ban(User $user)
    {
        if ($user->role === 'admin') {
            ApiResponse::errorResponse(403, 'Cannot ban another admin');
        }
        if ($user->is(auth()->user())) {
            ApiResponse::errorResponse(400, 'Cannot ban self');
        }
        $user->update([
            'is_banned' => true,
        ]);
        return ApiResponse::defaultResponse(200, new UserBanResource($user));
    }

    public function unban(User $user)
    {
        $user->update([
            'is_banned' => false,
        ]);
        return ApiResponse::defaultResponse(200, new UserBanResource($user));
    }
}
