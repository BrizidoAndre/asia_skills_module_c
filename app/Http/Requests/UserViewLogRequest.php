<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserViewLogRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'user_view_log_id' => ['required', 'integer'],
            'user_id' => ['required', 'exists:users'],
            'song_id' => ['required', 'exists:songs'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
