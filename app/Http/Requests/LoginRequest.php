<?php

namespace App\Http\Requests;


class LoginRequest extends AuthorizedFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required'    => ' Email không được để trống.',
            'email.email'       => ' Email không đúng định dạng.',
            'password.required' => ' Mật khẩu không được để trống.',
        ];
    }
}
