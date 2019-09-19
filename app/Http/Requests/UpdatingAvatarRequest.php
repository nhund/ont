<?php

namespace App\Http\Requests;

class UpdatingAvatarRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       return [
           'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'avatar.required' => 'Ảnh đại diện không được để trống',
            'avatar.image' => 'Tệp này không phải là một ảnh',
            'avatar.mimes' => 'Đinh dạng ảnh không được phép',
            'avatar.max' => 'Kích thước ảnh không được vượt quá 2MB',
        ];
    }
}
