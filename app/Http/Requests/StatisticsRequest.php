<?php

namespace App\Http\Requests;

use App\Base\ApiResponse;
use App\Models\Label;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StatisticsRequest extends ApiRequest
{
    protected function failedValidation(Validator $validator)
    {
        dump($validator->errors());
        ApiResponse::errorResponse(400, 'Invalid parameter');
    }

    public function rules()
    {
        return [
            'metrics' => ['required', 'string', 'in:label,album,song'],
            'labels' => ['bail', 'nullable', 'string', function ($att, $value, $error) {
                $labelsUser = explode(',', $value);
                $labels = Label::whereIn('name', $labelsUser)->count();
                if ($labels < count($labelsUser)) {
                    $error('Label\'s error');
                }
            }]
        ];
    }

    public function authorize()
    {
        return true;
    }
}
