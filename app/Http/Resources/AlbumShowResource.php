<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumShowResource extends AlbumResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title,
            'artist' => $this->artist,
            'release_year' => $this->release_year,
            'genre' => $this->genre,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'publisher' => [
                'id' => $this->publisher->getKey(),
                'username' => $this->publisher->username,
                'email' => $this->publisher->email,
            ]
        ];
    }
}
