<?php

namespace App\Http\Requests;

class AddUserCourseRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => 'required|numeric|exists:course,id',
        ];
    }
}
