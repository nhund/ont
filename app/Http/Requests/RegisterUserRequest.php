<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'phone' =>  'phone|unique:users',
        ];
    }

    public function messages()
    {
       return [
            'email.required'                    => ' Email không được để trống.',
            'email.email'                       => ' Email không đúng định dạng.',
            'email.unique'                      => ' Email đã được sử dụng.',
            'password.required'                 => ' Mật khẩu không được để trống.',
            'password.min'                      => ' Mật khẩu tối thiểu 6 ký tự.',
            'password.confirmed'                => 'Mật khẩu xác nhận không đúng',
        ];
    }
}
