<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 20/09/2019
 * Time: 17:16
 */

namespace App\Components\Question;


use App\Models\Course;
use App\Models\ExamUserAnswer;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionCardMuti;
use App\Models\QuestionLogCurrent;
use App\Models\TeacherSupport;
use App\Models\UserCourse;
use App\Models\UserLessonLog;
use App\Models\UserQuestionBookmark;
use App\Models\UserQuestionLog;
use App\User;
use Illuminate\Http\Request;

class QuestionService
{
    protected $request;
    protected $question;
    protected $lesson;


    public function getQuestions($questions, $lesson)
    {
        $this->lesson = $lesson;


        foreach ($questions as $question){
            if ($question->type === Question::TYPE_DIEN_TU_DOAN_VAN){
                $this->getFillWordIntoParagraphQuestions($question);
            }
            if ($question->type === Question::TYPE_DIEN_TU){
                $this->getFillWordIntoSentenceQuestions($question);
            }
            if ($question->type === Question::TYPE_TRAC_NGHIEM){
                $this->getMultipleChoiceQuestions($question);
            }
            if ($question->type === Question::TYPE_FLASH_MUTI){
                $this->getMultiFlashQuestions($question);
            }
        }

        return $questions;
    }
    
    private function getMultipleChoiceQuestions(Question $question, array $notIn = [])
    {
        $questionChildren = Question::query()->where('parent_id',$question->id);

        if (count($notIn)){
            $questionChildren = $questionChildren->whereNotIn('id',$notIn);
        }

        $questionChildren = $questionChildren->orderBy('order_s','ASC')
            ->orderBy('id','ASC')->get();

        foreach($questionChildren as $questionChild)
        {
            if($this->lesson->random_question == Lesson::TRAC_NGHIEM_ANSWER_RANDOM)
            {
                $questionChild->answers = QuestionAnswer::where('question_id',$questionChild->id)->orderByRaw('RAND()')->get();
            }else{
                $questionChild->answers = QuestionAnswer::where('question_id',$questionChild->id)->orderBy('answer','ASC')->get();
            }
        }
        $question->child = $questionChildren;
    }
    
    private function getFillWordIntoSentenceQuestions(Question $question, array $notIn = [])
    {
        $query = Question::where('parent_id', $question->id);

        if (count($notIn)){
            $query = $query->whereNotIn('id',$notIn);
        }

        $children = $query->orderBy('order_s','ASC')
                ->orderBy('id','ASC')->get();

        $question->child = $children;
    }
    
    private function getFillWordIntoParagraphQuestions(Question $question)
    {
        if($question->parent_id == 0)
        {
            $sub_questions = Question::where('parent_id',$question->id)->orderBy('id','asc')->get();
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
                            $get_title = $m_x[1];
                            return ''.$m_x[1].'';
                        },$m[1]);

                        if(empty($get_title))
                        {
                            return '<input title="" type="text" name="txtLearnWord['.$sub_q->id.']['.$incr.']" class="input_answer" value= "">';
                        }else{
                            return '<nobr><input title="" type="text" name="txtLearnWord['.$sub_q->id.']['.$incr.']" class="input_answer" value= ""><img class="show_suggest" data-title="'.$get_title.'" src="'.asset('/public/images/course/icon/bong_den_size.png').'" align="baseline" border="0" title="Xem gợi ý" style="margin-left:6px;cursor: pointer;"></nobr>';
                        }

                    }else{
                        return '<input title="" type="text" name="txtLearnWord['.$sub_q->id.']['.$incr.']" class="input_answer" value= "">';
                    }

                }, $str);

                $sub_q->question_display = $content;
            }
            $question->childs =  $sub_questions;
        }
    }
    
    private function getMultiFlashQuestions(Question $question)
    {
        $questionSub = QuestionCardMuti::where('parent_id',$question->id)->where('lesson_id',$question->lesson_id)->get();
        if(count($questionSub) > 0)
        {
            foreach ($questionSub as $key => $value) {
                $value->child = QuestionCardMuti::where('parent_id',$value->id)->where('lesson_id',$question->lesson_id)->get();
            }
        }
        $question->child = $questionSub;
    }
}