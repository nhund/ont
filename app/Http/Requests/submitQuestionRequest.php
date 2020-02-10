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

        $questionType = $this->get('question_type');

        $rules =  [
            'question_type' => 'required|in:'.implode($types, ','),
            'type' => 'required',
        ];

        if ( in_array($questionType, [Question::TYPE_FLASH_MUTI, Question::TYPE_FLASH_SINGLE])){
            return array_merge($rules, [
                'reply' =>'required|in:1,2'
            ]);
        }

        if ($questionType == Question::TYPE_DIEN_TU_DOAN_VAN){
            return array_merge($rules, [
                'txtLearnWord' =>'required|array'
            ]);
        }
        if ( in_array($questionType, [Question::TYPE_TRAC_NGHIEM, Question::TYPE_DIEN_TU])){
            return array_merge($rules, [
                'answers' =>'required|array'
            ]);
        }

        return [
            'question_type' => 'required|in:'.implode($types, ','),
            'type' => 'required',
            'answers' => 'array',
            'txtLearnWord' => 'array'
        ];
    }
}
