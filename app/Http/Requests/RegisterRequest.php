<?php

namespace App\Http\Requests;

use App\Base\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Arr;

class RegisterRequest extends ApiRequest
{
    protected function failedValidation(Validator $validator)
    {
        $failed = $validator->failed();
        if (Arr::has($failed, 'username.Unique')) {
            ApiResponse::errorResponse(409, 'Username already taken');
        } else if (Arr::has($failed, 'email.Unique')) {
            ApiResponse::errorResponse(409, 'Email already taken');
        }
        parent::failedValidation($validator);
    }

    public function rules()
    {
        return [
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'unique:users'],
            'password' => ['required',],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
