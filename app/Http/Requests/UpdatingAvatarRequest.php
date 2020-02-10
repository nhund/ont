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
}
