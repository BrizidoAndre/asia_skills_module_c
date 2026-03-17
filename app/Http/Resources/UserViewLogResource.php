<?php

namespace App\Http\Resources;

use App\Models\UserViewLog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin UserViewLog */
class UserViewLogResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'user_view_log_id' => $this->user_view_log_id,

            'user_id' => $this->user_id,
            'song_id' => $this->song_id,

            'user' => new UserResource($this->whenLoaded('user')),
            'song' => new SongResource($this->whenLoaded('song')),
        ];
    }
}
