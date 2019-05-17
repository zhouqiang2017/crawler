<?php

namespace App\Http\Requests\Api;


class SmsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'verification_key' => 'required|min:12|max:18',
            'code' => 'required|min:4|max:6'
        ];
    }
}
