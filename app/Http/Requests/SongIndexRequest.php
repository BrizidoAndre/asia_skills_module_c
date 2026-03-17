<?php

namespace App\Http\Requests;

use App\Base\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class SongIndexRequest extends ApiRequest
{
    protected function failedValidation(Validator $validator)
    {
        ApiResponse::errorResponse(400, 'Invalid parameter');
    }

    public function rules()
    {
        return [
            'keyword' => ['string'],
            'limit' => ['integer', 'min:1'],
            'cursor' => ['string'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
