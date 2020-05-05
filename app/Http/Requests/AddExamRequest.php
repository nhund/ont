<?php

namespace App\Http\Requests;

class AddExamRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lesson_type' => 'in:exam,lesson',
            'course_id'   => 'required',
            'name'        => 'required|min:3',
        ];
    }

}
