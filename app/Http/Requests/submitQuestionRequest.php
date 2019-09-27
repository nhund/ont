<?php

namespace App\Http\Requests;


use App\Models\Question;

class submitQuestionRequest extends AuthorizedFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $types = array_keys(Question::TYPE);

        return [
            'question_id' => 'required|integer|exists:question,id',
            'question_type' => 'required|in:'.implode($types, ','),
            'type' => 'required',
            'answers' => 'array',
            'txtLearnWord' => 'array'
        ];
    }
}
