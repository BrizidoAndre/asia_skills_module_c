<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRoleRequest extends UserRequest
{
    public function rules(): array
    {
        return [
            'role' => ['required', Rule::in(['admin', 'publisher', 'user'])]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
