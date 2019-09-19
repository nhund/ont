<?php

namespace App\Http\Requests;


class UpdateInfoUserRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'phone' => 'regex:/(^0\d{9,15}$)/u|max:11',
            'gender' => 'in:1,2',
            'full_name' => 'min:3',
            'birthday' => 'date_format:d-m-Y',
            'school_id' => 'numeric|exists:school,id'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email KHông hợp lệ.',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'phone.max' => 'Số điện thoại không được dài quá 11',
            'gender.in' => 'Giới tính không hợp lệ',
            'school_id.exists' => 'Mã trường không tồn tại',
            'school_id.numeric' => 'Mã trường phải là một số',
            'birthday.date_format' => 'Định dạng ngày sinh không hợp lệ.',
        ];
    }
}
