<?php

namespace App\Http\Resources;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Album */
class AlbumResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title,
            'artist' => $this->artist,
            'release_year' => $this->release_year,

            'publisher' => [
                'id' => $this->publisher_id,
                'username' => $this->publisher->username,
                'email' => $this->publisher->email,
            ],
        ];
    }
}
