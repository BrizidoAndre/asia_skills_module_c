<?php

namespace App\Http\Requests;

use Psy\Util\Str;

class AlbumAddSongRequest extends ApiRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'is_cover' => filter_var($this->input('is_cover'), FILTER_VALIDATE_BOOLEAN),
            'label' => preg_split('/, ?/', $this->input('label'))
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required',],
            'duration_seconds' => ['required', 'integer'],
            'label' => ['array',],
            'label.*' => 'exists:labels,name',
            'lyrics' => ['required',],
            'cover_image' => ['required', 'image'],
            'is_cover' => ['required', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
