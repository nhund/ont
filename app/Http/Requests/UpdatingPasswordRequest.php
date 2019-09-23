<?php

namespace App\Http\Requests;

class UpdatingPasswordRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       return [
           'old_password' => 'required',
           'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Mật khẩu không được để trống.',
            'password.confirmed' => 'Mật khẩu xác nhận không trùng hợp.',
            'password.min' => 'Mật khẩu ít nhất 6 kí tự.',
            'old_password.required' => 'Mật khẩu cũ không được để trống.',
        ];
    }
}
