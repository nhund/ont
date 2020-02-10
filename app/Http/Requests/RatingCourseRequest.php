<?php

namespace App\Http\Requests;

class RatingCourseRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

       return [
            'rating_value' => 'required|min:1|max:5|integer',
        ];
    }
}
