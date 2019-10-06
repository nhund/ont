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
            'lesson_type' => 'required|in:exam,lesson,level2',
            'course_id'   => 'required',
        ];
    }

}
