<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBanResource extends UserResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user_id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'is_banned' => $this->is_banned,
            'updated_at' => $this->updated_at,
        ];
    }
}
