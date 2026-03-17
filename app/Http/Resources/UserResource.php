<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'user_id' => $this->user_id,
            'username' => $this->username,
            'password_hash' => $this->password_hash,
            'email' => $this->email,
            'role' => $this->role,
            'is_banned' => $this->is_banned,
            'token' => $this->token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
