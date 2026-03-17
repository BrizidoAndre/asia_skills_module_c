<?php

namespace App\Http\Requests;

use App\Base\ApiResponse;
use App\Base\Cursor;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AlbumIndexRequest extends ApiRequest
{
    protected function failedValidation(Validator $validator)
    {
        ApiResponse::errorResponse(400, 'Invalid parameter');
    }

    public function rules()
    {
        return [
            'capital' => ['string',],
            'year' => ['string', function ($att, $value, $error) {
                $pattern = '/^(?:\d{4}-\d{4}|\d{4})$/';
                if (!preg_match($pattern, $value)) {
                    ApiResponse::errorResponse(400, 'Invalid year format');
                }
                if (str_contains($value, "-")) {
                    [$start, $end] = array_map(function ($item) {
                        return (integer)$item;
                    }, explode('-', $value));
                    if ($end < $start) {
                        ApiResponse::errorResponse(400, 'Invalid year format');
                    }
                }
            }],
            'limit' => ['integer', 'min:1'],
            'cursor' => ['string', function ($att, $value, $error) {
                $cursor = base64_decode($value);
                $cursor = json_decode($cursor);
                if (!$cursor) {
                    ApiResponse::errorResponse(400, 'Invalid cursor');
                }
            }],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
