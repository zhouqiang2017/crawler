<?php

namespace App\Http\Requests\Api;


class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required|regex:/^1[345678]\d{9}$/',
        ];
    }
}
