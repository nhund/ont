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

}
