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

    public function messages()
    {
        return [
            'course_id.required' => 'Mã khóa học không được để trống',
            'course_id.numeric' => 'Mã khóa học phải là một số',
            'course_id.exists' => 'Mã khóa học không tồn tại',
        ];
    }

}
