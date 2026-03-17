<?php

namespace App\Http\Resources;

use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Song */
class SongResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->getKey(),
            'album_id' => $this->album_id,
            'title' => $this->title,
            'label' => $this->labels->pluck('name'),
            'duration_seconds' => $this->duration_seconds,
            'album_title' => $this->album->title,
            'cover_image_url' => "/api/songs/{$this->getKey()}/cover"
        ];
    }
}
