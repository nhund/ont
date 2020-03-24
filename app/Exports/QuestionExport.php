<?php

namespace App\Exports;

use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionCardMuti;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class QuestionExport implements FromView
{
    use Exportable;

    protected $lessonId;
    protected $part;

    public function __construct($lessonId, $part = null)
    {
        $this->lessonId = $lessonId;
        $this->part = $part;
    }


    /**
     * @return View
     */
    public function view(): View
    {
        $questions = Question::query()->where('lesson_id',$this->lessonId)
            ->where('parent_id',0)
            ->orderBy('id','ASC');

        if ($this->part){
            $questions->whereHas('examQuestion', function ($q){
                $q->where('exam_question.lesson_id', $this->lessonId)
                    ->where('part', $this->part)
                ;
            });
        }

        $questions = $questions->get();

        foreach($questions as $question)
        {
            if($question->type == Question::TYPE_FLASH_MUTI)
            {
                $cardMutiles = QuestionCardMuti::where('parent_id',$question->id)->where('lesson_id',$this->lessonId)->orderBy('id','ASC')->get();

                foreach ($cardMutiles as $key => $card) {
                    $card->child = QuestionCardMuti::where('parent_id',$card->id)->where('lesson_id',$this->lessonId)->orderBy('id','ASC')->get();
                }
                $question->child_cards = $cardMutiles;
            }
            if($question->type == Question::TYPE_DIEN_TU)
            {
                $questions_child = Question::where('parent_id',$question->id)->where('lesson_id',$this->lessonId)->get();
                foreach ($questions_child as $question_child) {
                    $question_child->answers = QuestionAnswer::where('question_id',$question_child->id)->get();
                }
                $question->childs = $questions_child;
            }
            if($question->type == Question::TYPE_TRAC_NGHIEM)
            {
                $questions_child = Question::where('parent_id',$question->id)->where('lesson_id',$this->lessonId)->get();
                foreach ($questions_child as $question_child) {
                    $question_child->answers = QuestionAnswer::where('question_id',$question_child->id)->get();
                }
                $question->childs = $questions_child;
            }
            if($question->type == Question::TYPE_TRAC_NGHIEM_DON)
            {
                $question->answers = QuestionAnswer::where('question_id',$question->id)->get();
            }
            if($question->type == Question::TYPE_DIEN_TU_DOAN_VAN)
            {
                $sub_questions = Question::where('parent_id',$question->id)->where('lesson_id',$this->lessonId)->get();
                foreach ($sub_questions as $key => $sub_q) {
                    $str = $sub_q->question;
                    $pattern = '/<a .*?class="(.*?cloze.*?)">(.*?)<\/a>/';
                    $content = preg_replace_callback($pattern, function($m) use ($sub_q) {
                        static $incr = 0;
                        $incr += 1;
                        //$title = '';
                        if( strpos($m[1], 'clozetip' ) !== false) {
                            $get_title = '';
                            $title = preg_replace_callback('/title="(.*?)"/', function($m_x) use(&$get_title) {
                                $get_title = $m_x[1]; //dd($get_title);
                                return ''.$m_x[1].'';
                            },$m[1]);

                            return '<#'.$m[2].'|'.$get_title.'#>';
                        }else{
                            return '<#'.$m[2].'#>';
                        }

                    }, $str);

                    $sub_q->question_display = $content;
                }
                $question->childs = $sub_questions;
            }
        }

        return view('backend.export.question', [
            'questions' => $questions
        ]);
    }
}
