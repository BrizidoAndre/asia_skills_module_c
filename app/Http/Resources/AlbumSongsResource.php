<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumSongsResource extends SongResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->getKey(),
            'album_id' => $this->album_id,
            'title' => $this->title,
            'label' => $this->labels->pluck('name'),
            'duration_seconds' => $this->duration_seconds,
            'order' => $this->track_order,
            'is_cover' => $this->is_cover,
            'cover_image_url' => "/api/songs/{$this->getKey()}/cover"
        ];
    }
}
