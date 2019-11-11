<?php

namespace App\Http\Requests;

class AddCommentToQuestionRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'course_id' => 'required|numeric|exist:course,id',
            'parent_id' => 'numeric',
            'content'   => 'required|max:525',
        ];
    }
}
