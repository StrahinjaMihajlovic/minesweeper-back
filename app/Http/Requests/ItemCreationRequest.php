<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => [
                'present',
                'string'
            ],
            'name' => [
                'required',
                'string',
            ],
            'price' => [
                'required',
                'Integer'
            ],
            'category' => [
                'exists:Category, name'
            ]
        ];
    }
}
