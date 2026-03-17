<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsSongResource extends SongResource
{
    public function toArray(Request $request)
    {
        return [
            "id" => $this->getKey(),
            "album_id" => $this->album_id,
            "title" => $this->title,
            "duration_seconds" => $this->duration_seconds,
            "order" => $this->track_order,
            "label" => $this->labels->pluck('name'),
            "view_count" => $this->user_view_logs_count,
            "is_cover" => $this->is_cover,
            "lyrics" => $this->lyrics,
            "cover_image_url" => "/api/songs/{$this->getKey()}/cover",
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
