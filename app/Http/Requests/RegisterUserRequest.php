<?php

namespace App\Http\Requests;

class RegisterUserRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'phone'    => 'unique:users',
        ];
    }
}
