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

        $this->checkUserExam();

        if ($this->question->type == Question::TYPE_FLASH_MUTI) {
            return $this->multiFlash();
        }

        if ($this->question->type == Question::TYPE_FLASH_SINGLE) {
            return $this->singleFlash();
        }

        if ($this->question->type == Question::TYPE_DIEN_TU) {
            return $this->fillWordIntoSentence();
        }

        if ($this->question->type == Question::TYPE_TRAC_NGHIEM) {
            return $this->multipleChoice();
        }

        if ($this->question->type == Question::TYPE_DIEN_TU_DOAN_VAN) {
            return $this->fillWordIntoParagraph();
        }

        return response()->json(array('error' => true, 'msg' => 'succsess'));
    }

    protected function _saveLogQuestion($data, $result = false)
    {
        $conditions = ['lesson_id' => $this->examId,
                       'user_id'   => $this->user->id,
                       'question_id', $this->question->id];

        $userQuestion = ExamUserAnswer::where($conditions)->first();

        if ($userQuestion) {
            $userQuestion->turn += 1;

        } else {
            $userQuestion = new ExamUserAnswer();

            $userQuestion->lesson_id   = $this->examId;
            $userQuestion->user_id     = $this->user->id;
            $userQuestion->question_id = $this->question->id;
            $userQuestion->turn        = 1;
        }
        $userQuestion->status    = $result;
        $userQuestion->answer    = \json_encode($data);
        $userQuestion->submit_at = now();

        if ($this->flag){
            $score =  $this->calculateScore();
            $examUser = ExamUser::where([
                'user_id' => $this->user->id,
                'lesson_id' => $this->examId
            ])->first();
            $examUser->score += $score;
            $examUser->save();
        }

        return $userQuestion->save();
    }

    /**
     * @return array
     */
    private function multiFlash()
    {
        $rely    = $this->request->get('reply');
        $dataLog = [
            'error'       => (int)$rely,
            'question_id' => $this->question->id
        ];
        $this->flag = $rely == Question::REPLY_OK;

        return $this->_saveLogQuestion($dataLog);
    }

    /**
     * @return array
     */
    private function singleFlash()
    {
        $rely    = $this->request->get('reply');
        $dataLog = [
            'error'       => (int)$rely,
            'question_id' => $this->question->id
        ];

        $this->flag = $rely == Question::REPLY_OK;
        return $this->_saveLogQuestion($dataLog);
    }

    private function multipleChoice()
    {
        $answers = $this->request->get('answers');
        $result  = [];
        foreach ($answers as $key => $answer) {

            $reply = QuestionAnswer::REPLY_ERROR;
            //lay dap an dung
            $answerCheck = QuestionAnswer::where('question_id', $key)->where('status', QuestionAnswer::REPLY_OK)->first();
            if (!$answerCheck) {
                return response()->json(array(
                    'error' => true,
                    'msg'   => 'Câu hỏi chưa có đáp án',
                    'data'  => '',
                ));
            }

            $this->flag = $flag = $answerCheck && (int)$answer == (int)$answerCheck->id;

            if ($flag) {
                $reply = QuestionAnswer::REPLY_OK;
            }

            $question_child = Question::find($key);
            $text           = $question_child ? $question_child->interpret : '';

            $interpret_all = $this->question ? $this->question->interpret_all : '';

            $result[$key] = array(
                'question_id'   => $key,
                'error'         => $reply,
                'input'         => !empty($answer) ? (int)$answer : '',
                'answer'        => $answerCheck->id,
                'interpret'     => $text ?: '',
                'interpret_all' => $interpret_all ?: '',
            );
        }

        return $this->_saveLogQuestion($result);
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
            }

            $result[$key] = array(
                'error'  => $reply,
                'input'  => !empty($answer) ? $answer : '',
                'answer' => $an->answer,
            );
        }

        return $this->_saveLogQuestion($result);
    }

    private function fillWordIntoParagraph()
    {
        $txtLearnWord = $this->request->get('txtLearnWord');
        $result       = [];
        foreach ($txtLearnWord as $question_id => $value) {
            $question = Question::find($question_id);
            if ($question) {

                $check_pass_question = QuestionAnswer::REPLY_OK;
                $str                 = $question->question;
                $pattern             = '/<a .*?class="(.*?cloze.*?)">(.*?)<\/a>/';

                $content = preg_replace_callback($pattern, function ($m) use ($question_id, $value, &$result, &$check_pass_question) {

                    static $incr_sb = 0;
                    $incr_sb += 1;
                    if (isset($value[$incr_sb])) {
                        if (mb_strtolower($value[$incr_sb], 'UTF-8') == mb_strtolower($m[2], 'UTF-8')) {
                            $reply_status = QuestionAnswer::REPLY_OK;
                        } else {
                            $check_pass_question = QuestionAnswer::REPLY_ERROR;
                            $reply_status        = QuestionAnswer::REPLY_ERROR;
                            $this->flag = false;
                        }
                        $result[$question_id][$incr_sb] = array(
                            'error'  => $reply_status,
                            'input'  => $value[$incr_sb],
                            'answer' => $m[2],
                        );
                    } else {
                        $this->flag = false;
                        $check_pass_question            = QuestionAnswer::REPLY_ERROR;
                        $result[$question_id][$incr_sb] = array(
                            'error'  => QuestionAnswer::REPLY_ERROR,
                            'input'  => '',
                            'answer' => $m[2],
                        );
                    }
                }, $str);
            }
        }
        return $this->_saveLogQuestion($result);
    }

    /**
     * @return mixed
     */
    private function checkUserExam()
    {
        $userId   = $this->request->user()->id;
        $examUser = ExamUser::where('lesson_id', $this->lesson->id)->where('user_id', $userId)->exsit();

        if (!$examUser) {
            ExamUser::create([
                 'lesson_id'      => $this->examId,
                 'user_id'        => $userId,
                 'turn'           => 1,
                 'score'          => 0,
                 'last_submit_at' => now(),
             ]);
        }
    }

    // tính điểm mỗi câu hỏi đúng
    private function calculateScore()
    {
        $examQuestion = ExamQuestion::where([
            'question_id' => $this->question->id,
            'lesson_id'   => $this->examId,
        ])->first();

        $condition = [
            'lesson_id' => $this->examId,
            'part'      => $examQuestion->part
        ];

        // tổng câu hỏi của từng phần
        $totalQuestions = ExamQuestion::where($condition)->count();

        // tổng điểm của phần
        $scoreTotal = ExamPart::where($condition)->first();

        return round($scoreTotal/$totalQuestions, 1);
    }
}