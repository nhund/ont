<?php

namespace App\Http\Requests;

class AddCommentToCourseRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_id' => 'numeric|exists:course_comment,id',
            'content'   => 'required|max:525',
        ];
    }
}
