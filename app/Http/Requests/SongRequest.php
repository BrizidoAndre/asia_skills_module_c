<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'song_id' => ['required', 'integer'],
            'album_id' => ['nullable', 'exists:albums'],
            'title' => ['required'],
            'duration_seconds' => ['nullable', 'integer'],
            'cover_image_path' => ['nullable'],
            'is_cover' => ['required', 'integer'],
            'lyrics' => ['nullable'],
            'track_order' => ['nullable', 'integer'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
