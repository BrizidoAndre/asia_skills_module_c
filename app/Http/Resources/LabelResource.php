<?php

namespace App\Http\Resources;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Label */
class LabelResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'label_id' => $this->label_id,
            'name' => $this->name,
        ];
    }
}
