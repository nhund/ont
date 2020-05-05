<?php

namespace App\Http\Requests;

class UserCourseRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

       return [
            'user_id' => 'numeric',
        ];
    }
}
