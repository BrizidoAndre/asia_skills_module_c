<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumSongStoreResource extends SongResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'album_id' => $this->album_id,
            'title' => $this->title,
            'duration_seconds' => $this->duration_seconds,
            'lyrics' => $this->lyrics,
            'order' => $this->track_order,
            'view_count' => $this->user_view_logs_count,
            'label' => $this->labels()->pluck('name'),
            'is_cover' => $this->is_cover,
            'cover_image_url' => "/api/songs/{$this->getKey()}/cover",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
