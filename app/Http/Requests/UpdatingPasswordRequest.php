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
}
