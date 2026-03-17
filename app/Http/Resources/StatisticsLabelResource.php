<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsLabelResource extends LabelResource
{
    public function toArray(Request $request)
    {
        return [
            'total_view_count' => $this->song_labels_count,
            'label' => $this->name,
            'songs' => StatisticsSongResource::collection($this->songs),
        ];
    }
}
