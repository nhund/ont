<?php

namespace App\Http\Requests;


use App\Models\Question;

class submitQuestionExamRequest extends AuthorizedFormRequest
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

        if (!$this->has('question_type')){
            return [ 'question_type' => 'required|in:'.implode($types, ',')];
        }

        $rules =  [
            'question_type' => 'required|in:'.implode($types, ','),
            'type' => 'required',
            'exam_id' => 'required|exists:lesson,id',
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

//        return [
//            'question_type' => 'required|in:'.implode($types, ','),
//            'exam_id' => 'required|exists:lesson,id',
//            'type' => 'required',
//            'answers' => 'array',
//            'txtLearnWord' => 'array'
//        ];
    }
}
