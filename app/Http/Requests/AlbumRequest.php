<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends ApiRequest
{

    public function rules()
    {
        return [
            'title' => ['required'],
            'artist' => ['required'],
            'release_year' => ['required', 'integer'],
            'genre' => ['required'],
            'description' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
