<?php

namespace App\Http\Requests\Api;


class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required',
            'userInfo' => 'required'
        ];
    }
}
