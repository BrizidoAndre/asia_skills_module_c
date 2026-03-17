<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'album_id' => ['required', 'integer'],
            'publisher_id' => ['required', 'exists:users'],
            'title' => ['required'],
            'artist' => ['required'],
            'release_year' => ['nullable', 'integer'],
            'genre' => ['nullable'],
            'description' => ['nullable'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
