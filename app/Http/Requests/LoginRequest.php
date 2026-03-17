<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'username' => ['required',],
            'password' => ['required',],
        ];
    }
}
