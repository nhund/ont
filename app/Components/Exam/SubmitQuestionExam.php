<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 28/09/2019
 * Time: 10:54
 */
namespace App\Components\Exam;

use App\Models\ExamPart;
use App\Models\ExamQuestion;
use App\Models\ExamUser;
use App\Models\ExamUserAnswer;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;

class SubmitQuestionExam
{
    protected $request;
    protected $question;
    protected $examId;
    protected $user;
    private $flag = true;
    private $totalSub = 0;
    private $trueSub = 0;

    /**
     * @param Request $request
     * @param Question $question
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function submit(Request $request, Question $question)
    {
        $this->request  = $request;
        $this->user     = $this->request->user();
        $this->question = $question;
        $this->examId   = $this->request->get('exam_id');

        if ($this->request->question_type == $this->question->type)
        {
            if ($this->question->type == Question::TYPE_FLASH_MUTI) {
                return $this->multiFlash();
            }

            if ($this->question->type == Question::TYPE_FLASH_SINGLE) {
                return $this->singleFlash();
            }

            if ($this->question->type == Question::TYPE_DIEN_TU) {
                return $this->fillWordIntoSentence();
            }

            if ($this->question->type == Question::TYPE_TRAC_NGHIEM || $this->question->type == Question::TYPE_TRAC_NGHIEM_DON) {
                return $this->multipleChoice();
            }

            if ($this->question->type == Question::TYPE_DIEN_TU_DOAN_VAN) {
                return $this->fillWordIntoParagraph();
            }
        }

        return response()->json(array('error' => 1, 'msg' => 'Dữ liệu không hợp lệ'));
    }

    protected function _saveLogQuestion($data)
    {
        $score =  $this->calculateScore();

        $conditions = ['lesson_id' => $this->examId,
                       'user_id'   => $this->user->id,
                       'question_id' => $this->question->id];

        $userQuestion = ExamUserAnswer::where($conditions)->first();

        if ($userQuestion) {
            $userQuestion->turn += 1;

        } else {
            $examQuestion  = $this->question->examQuestion()
                ->where('lesson_id', $this->examId)->first();

            $userQuestion = new ExamUserAnswer();
            $userQuestion->lesson_id   = $this->examId;
            $userQuestion->user_id     = $this->user->id;
            $userQuestion->question_id = $this->question->id;
            $userQuestion->part = $this->question->id;
            $userQuestion->turn = 1;
            $userQuestion->part = $examQuestion->part;
        }
        $userQuestion->status    = $this->flag ? Question::REPLY_OK : Question::REPLY_ERROR;
        $userQuestion->score     = $this->flag ? $score : 0 ;
        $userQuestion->answer    = \json_encode($data);
        $userQuestion->submit_at = now();

        $examUser = ExamUser::where([
            'user_id' => $this->user->id,
            'lesson_id' => $this->examId
        ])->first();
        if ($this->flag){
            $examUser->score += $score;

            if ($examUser->score > $examUser->highest_score){
                $examUser->highest_score = $examUser->score;
                $examUser->last_submit_at = now();
                $examUser->begin_highest_at = $examUser->begin_at;
                $examUser->second_stop_highest = $examUser->second_stop;
            }
        }
        $examUser->until_number = $this->request->get('until_number');
        $examUser->last_at = now();
        $examUser->save();

        return $userQuestion->save();
    }

    /**
     * @return array
     */
    private function multiFlash()
    {
        $rely    = $this->request->get('reply');
        $this->totalSub = 1;
        $this->trueSub = 1;
        $dataLog = [
            'error'       => (int)$rely,
            'question_id' => $this->question->id
        ];
        $this->flag = $rely == Question::REPLY_OK;

         $this->_saveLogQuestion($dataLog);

        return $dataLog;
    }

    /**
     * @return array
     */
    private function singleFlash()
    {
        $rely    = $this->request->get('reply');
        $this->totalSub = 1;
        $this->trueSub = 1;
        $dataLog = [
            'error'       => (int)$rely,
            'question_id' => $this->question->id
        ];

        $this->flag = $rely == Question::REPLY_OK;
        $this->_saveLogQuestion($dataLog);

        return $dataLog;
    }

    private function multipleChoice()
    {
        $answers = $this->request->get('answers');
        $result  = [];
        foreach ($answers as $key => $answer) {
            $this->totalSub++;
            $reply = QuestionAnswer::REPLY_ERROR;
            //lay dap an dung
            $answerCheck = QuestionAnswer::where('question_id', $key)->where('status', QuestionAnswer::REPLY_OK)->first();
            $allAnswers = QuestionAnswer::where('question_id', $key)->orderBy('answer','ASC')->pluck('id')->toArray();

            $flag = $answerCheck && (int)$answer == (int)$answerCheck->id;

            if ($flag) {
                $reply = QuestionAnswer::REPLY_OK;
                $this->trueSub ++;
            }

            if (!$flag){
                $this->flag = false;
            }

            $question_child = Question::find($key);
            $text           = $question_child ? $question_child->interpret : '';
            $interpret_all  = $this->question ? $this->question->interpret_all : '';

            $result[$key] = array(
                'question_id'   => $key,
                'error'         => $reply,
                'input'         => !empty($answer) ? (int)$answer : '',
                'input_text'    => !empty($allAnswers) ? $this->getAnswerMultiChoice(array_search($answer, $allAnswers)) : '',
                'answer'        => $answerCheck->id ?? '',
                'interpret'     => $text ?: '',
                'interpret_all' => $interpret_all ?: '',
            );
        }
        $this->_saveLogQuestion($result);
        return $result;
    }

    private function fillWordIntoSentence()
    {
        $answers = $this->request->get('answers');
        $result  = [];
        foreach ($answers as $key => $answer) {
            $an    = QuestionAnswer::where('question_id', $key)->first();
            $reply = Question::REPLY_ERROR;
            if (mb_strtolower($an->answer, 'UTF-8') == mb_strtolower($answer, 'UTF-8')) {
                $reply = Question::REPLY_OK;
            }

            $flag = mb_strtolower($an->answer, 'UTF-8') == mb_strtolower($answer, 'UTF-8');

            if (!$flag){
                $this->flag = $flag;
            }else {
                $this->trueSub ++;
            }
            $this->totalSub ++;

            $result[$key] = array(
                'error'  => $reply,
                'input'  => !empty($answer) ? $answer : '',
                'input_text'  => !empty($answer) ? $answer : '',
                'answer' => $an->answer,
            );
        }

        $this->_saveLogQuestion($result);

        return $result;
    }

    private function fillWordIntoParagraph()
    {
        $txtLearnWord = $this->request->get('txtLearnWord');
        $result       = [];
        foreach ($txtLearnWord as $question_id => $value) {
            $question = Question::find($question_id);
            if ($question) {
                $this->totalSub ++;
                $check_pass_question = QuestionAnswer::REPLY_OK;
                $str                 = $question->question;
                $pattern             = '/<a .*?class="(.*?cloze.*?)">(.*?)<\/a>/';

                $content = preg_replace_callback($pattern, function ($m) use ($question_id, $value, &$result, &$check_pass_question) {

                    static $incr_sb = 0;
                    $incr_sb += 1;
                    if (isset($value[$incr_sb])) {
                        if (mb_strtolower($value[$incr_sb], 'UTF-8') == mb_strtolower($m[2], 'UTF-8')) {
                            $reply_status = QuestionAnswer::REPLY_OK;
                            $this->trueSub++;
                        } else {
                            $check_pass_question = QuestionAnswer::REPLY_ERROR;
                            $reply_status        = QuestionAnswer::REPLY_ERROR;
                            $this->flag = false;
                        }
                        $result[$question_id][$incr_sb] = array(
                            'error'  => $reply_status,
                            'input'  => $value[$incr_sb],
                            'input_text'  => $value[$incr_sb],
                            'answer' => $m[2],
                        );
                    } else {
                        $this->flag = false;
                        $check_pass_question            = QuestionAnswer::REPLY_ERROR;
                        $result[$question_id][$incr_sb] = array(
                            'error'  => QuestionAnswer::REPLY_ERROR,
                            'input'  => '',
                            'input_text'  => '',
                            'answer' => $m[2],
                        );
                    }
                }, $str);
            }
        }
        $this->_saveLogQuestion($result);

        return $result;
    }


    // tính điểm mỗi câu hỏi đúng
    private function calculateScore()
    {
        $examQuestion = ExamQuestion::where([
            'question_id' => $this->question->id,
            'lesson_id'   => $this->examId,
        ])->firstOrFail();

        $conditionPart = [
            'lesson_id' => $this->examId,
            'id' => $examQuestion->part,
        ];

        // tổng điểm của phần
        $parts = ExamPart::where($conditionPart)->first();


        if ($this->totalSub != 0 && $this->trueSub != 0){
            return round(($parts->score*$this->trueSub)/($parts->number_question*$this->totalSub), 1);
        }
        return round($parts->score/$parts->number_question, 1);
    }

    private function getAnswerMultiChoice($index){

        $array = [
            0 => "A",
            1 => "B",
            2 => "C",
            3 => "D",
            4 => "E",
            5 => "F",
            6 => "G",
         ];

        return $array[$index];
    }
}