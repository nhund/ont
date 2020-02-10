<?php

namespace App\Http\Requests;

class RecommendationRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

       return [
//            'lesson_id' => 'numeric|exists:lesson,id',
        ];
    }
}
