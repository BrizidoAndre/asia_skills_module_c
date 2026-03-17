<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'label_id' => ['required', 'integer'],
            'name' => ['required'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
