<?php

namespace App\Http\Resources;

use App\Models\SongLabel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SongLabel */
class SongLabelResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'song_label_id' => $this->song_label_id,
            'label_id' => $this->label_id,

            'song_id' => $this->song_id,

            'song' => new SongResource($this->whenLoaded('song')),
        ];
    }
}
