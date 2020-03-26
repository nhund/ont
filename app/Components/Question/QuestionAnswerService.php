<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 20/09/2019
 * Time: 17:16
 */
namespace App\Components\Question;

use App\Events\SubmitQuestionEvent;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionLogCurrent;
use App\Models\UserLessonLog;
use App\Models\UserQuestionBookmark;
use App\Models\UserQuestionLog;
use Illuminate\Http\Request;
use Intervention\Image\Exception\NotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionAnswerService
{
    protected $request;
    protected $question;
    protected $lesson;

    public function submit(Request $request, Question $question)
    {
        $this->request  = $request;
        $this->question = $question;
        $this->lesson   = $this->getLesson($this->question->lesson_id);

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

        return response()->json(array('error' => true, 'msg' => 'succsess'));
    }

    protected function _saveLogQuestion($data)
    {

        if ($this->checkBookmark()){
            return false;
        }

        $courseId       = $this->lesson->course_id;
        $lessonId       = $this->lesson->id;
        $type           = Question::LEARN_LAM_BAI_TAP;
        $user           = $this->request->user();
        $questionParent = $this->question->id;

        $questionlearnedIds = [];
        $questionLearned    = QuestionLogCurrent::where('user_id', $user->id)->where('course_id', $courseId)->where('type', $type)->first();
        if ($questionLearned) {
            $questionlearnedIds = json_decode($questionLearned->content, true);
            if (isset($questionlearnedIds[$lessonId])) {
                if (!in_array($questionParent, $questionlearnedIds[$lessonId])) {
                    array_push($questionlearnedIds[$lessonId], $questionParent);
                }
            } else {
                $questionlearnedIds[$lessonId] = [$questionParent];
            }
            //lay tat ca cau hoi cua lesson
            $lesson_questions = Question::where('lesson_id', $lessonId)->where('course_id', $courseId)->where('parent_id', 0)->count();

            if ($lesson_questions == count($questionlearnedIds[$lessonId])) {
                // neu so cau da lam xong thi reset log
                $questionlearnedIds[$lessonId] = [];
            }
            $questionLearned->content = json_encode($questionlearnedIds);
            $questionLearned->save();

        } else {
            //$lesson_current =
            $lesson_questions = Question::where('lesson_id', $lessonId)->where('course_id', $courseId)->where('parent_id', 0)->count();
            if ($lesson_questions > 1) {
                $questionlearnedIds[$lessonId] = [$questionParent];

                $questionLearned['content'] = json_encode($questionlearnedIds);

                $this->questionLearned($questionLearned);
            }
            return true;
        }

        $this->logUserQuestion($data);

        $this->logUserLesson($data);
    }

    /**
     * @return array
     */
    private function multiFlash()
    {
        $rely = $this->request->get('reply') == Question::REPLY_OK ? $this->request->get('reply') : Question::REPLY_ERROR;
        $dataLog = array(
            'question_id'   => $this->question->id,
            'status'        => $rely,
            'question_type' => Question::TYPE_FLASH_MUTI
        );
        $this->_saveLogQuestion($dataLog);

        return [
            'error'  => $rely,
            'question_id' => $this->question->id
        ];
    }

    /**
     * @return array
     */
    private function singleFlash()
    {
        $rely = $this->request->get('reply') == Question::REPLY_OK ? $this->request->get('reply') : Question::REPLY_ERROR;
        $dataLog = array(
            'question_id'   => $this->question->id,
            'status'        => $rely,
            'question_type' => Question::TYPE_FLASH_SINGLE
        );
        $this->_saveLogQuestion($dataLog);

        return [
            'error'  => (int)$rely,
            'question_id' => $this->question->id
        ];
    }

    private function multipleChoice()
    {
        $answers = $this->request->get('answers');
        $result = [];
        if(empty($answers)){
            throw new NotFoundException('bạn chưa chọn đáp án cho câu hỏi');
        }

        foreach ($answers as $key => $answer) {

            $reply = QuestionAnswer::REPLY_ERROR;
            //lay dap an dung
            $answerCheck = QuestionAnswer::where('question_id', $key)->where('status', QuestionAnswer::REPLY_OK)->first();
            if (!$answerCheck) {
                throw new NotFoundException('Câu hỏi chưa có đáp án');
            }
            if ($answerCheck && (int)$answer == (int)$answerCheck->id) {
                $reply = QuestionAnswer::REPLY_OK;
            }
            $dataLog = array(
                'question_id'   => $key,
                'status'        => $reply,
                'question_type' => $this->question->type
            );
            $this->_saveLogQuestion($dataLog);
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
        return $result;
    }

    private function fillWordIntoSentence()
    {
        $answers = $this->request->get('answers');
        $result = [];
        foreach ($answers as $key => $answer) {
            $an    = QuestionAnswer::where('question_id', $key)->first();
            $reply = Question::REPLY_ERROR;
            if (mb_strtolower($an->answer, 'UTF-8') == mb_strtolower($answer, 'UTF-8')) {
                $reply = Question::REPLY_OK;
            }

            $dataLog = array(
                'question_id'   => $key,
                'status'        => $reply,
                'question_type' => Question::TYPE_DIEN_TU
            );
            $this->_saveLogQuestion($dataLog);

            $result[$key] = array(
                'error'  => $reply,
                'input'  => !empty($answer) ? $answer : '',
                'answer' => $an->answer,
            );
        }
        return $result;
    }

    private function fillWordIntoParagraph()
    {
        $txtLearnWord = $this->request->get('txtLearnWord');
        $result = [];
        foreach ($txtLearnWord as $question_id => $value) {
            $question = Question::find($question_id);
            if ($question) {

                $check_pass_question = QuestionAnswer::REPLY_OK;
                $str     = $question->question;
                $pattern = '/<a .*?class="(.*?cloze.*?)">(.*?)<\/a>/';

                $content = preg_replace_callback($pattern, function ($m) use ($question_id, $value, &$result, &$check_pass_question) {

                    static $incr_sb = 0;
                    $incr_sb += 1;
                    if (isset($value[$incr_sb])) {
                        if (mb_strtolower($value[$incr_sb], 'UTF-8') == mb_strtolower($m[2], 'UTF-8')) {
                            $reply_status = QuestionAnswer::REPLY_OK;
                        } else {
                            $check_pass_question = QuestionAnswer::REPLY_ERROR;
                            $reply_status        = QuestionAnswer::REPLY_ERROR;
                        }
                        $result[$question_id][$incr_sb] = array(
                            'error'  => $reply_status,
                            'input'  => $value[$incr_sb],
                            'answer' => $m[2],
                        );
                    } else {
                        $check_pass_question            = QuestionAnswer::REPLY_ERROR;
                        $result[$question_id][$incr_sb] = array(
                            'error'  => QuestionAnswer::REPLY_ERROR,
                            'input'  => '',
                            'answer' => $m[2],
                        );
                    }
                }, $str);
                //luu log
                $dataLog = array(
                    'question_id'   => $question_id,
                    'status'        => $check_pass_question,
                    'question_type' => Question::TYPE_DIEN_TU_DOAN_VAN
                );
                $this->_saveLogQuestion($dataLog);
            }
        }
        return $result;
    }

    private function getLesson($lessonId)
    {
        return Lesson::where('id', $lessonId)->first();
    }

    /**
     * @param $params
     * @return mixed
     */
    private function questionLearned($params)
    {
        $params['user_id']     = $this->request->user()->id;
        $params['course_id']   = $this->lesson->course_id;
        $params['type']        = Question::LEARN_LAM_BAI_TAP;
        $params['create_date'] = time();
        $params['update_date'] = time();

        return QuestionLogCurrent::updateOrCreate($params, [
            'user_id'   => $params['user_id'],
            'course_id' => $params['course_id'],
            'type'      => $params['type']
        ]);
    }

    /**
     * @param $data
     */
    private function logUserQuestion($data)
    {
        $userId      = $this->request->user()->id;
        $type        = $this->request->get('type');
        $questionLog = UserQuestionLog::where('user_id', $userId)->where('question_id', $data['question_id'])->first();
        if ($questionLog) {
            $questionLog->status      = $data['status'];
            $questionLog->update_time = time();
            $questionLog->is_ontap    = $type == Question::LEARN_LAM_CAU_CU ? UserQuestionLog::TYPE_ON_TAP : 0;
            $questionLog->total_turn += 1;
            $questionLog->status_delete   = UserQuestionLog::ACTIVE;
            if ((int)$data['status'] == Question::REPLY_OK){
                $questionLog->correct_number += 1;
            }

            $questionLog->save();
        } else {
            $questionLog                  = new UserQuestionLog();
            $questionLog->user_id         = $userId;
            $questionLog->course_id       = $this->lesson->course_id;
            $questionLog->lesson_id       = $this->lesson->id;
            $questionLog->question_id     = $data['question_id'];
            $questionLog->question_parent = $this->question->id;
            $questionLog->note            = $data['note'] ?? '';
            $questionLog->status          = (int)$data['status'];
            $questionLog->create_at       = time();
            $questionLog->is_ontap        = $type == Question::LEARN_LAM_CAU_CU ? UserQuestionLog::TYPE_ON_TAP : 0;
            $questionLog->update_time     = time();
            $questionLog->status_delete   = UserQuestionLog::ACTIVE;

            $questionLog->total_turn += 1;

            if ((int)$data['status'] == Question::REPLY_OK){
                $questionLog->correct_number = 1;
            }

            $questionLog->save();
        }
    }

    /**
     * @param $data
     */
    private function logUserLesson($data)
    {
        $userId   = $this->request->user()->id;
        $courseId = $this->lesson->course_id;
        $lessonId = $this->lesson->id;
        $questionParent = $this->question->id;

        $up_question_true = false;


        $lesson_log = UserLessonLog::where('user_id', $userId)
            ->where('lesson_id', $lessonId)->first();

        if (!$lesson_log) {

            $lesson_log                      = new UserLessonLog();
            $lesson_log->user_id             = $userId;
            $lesson_log->course_id           = $courseId;
            $lesson_log->lesson_id           = $lessonId;
            $lesson_log->count               = 1;
            $lesson_log->count_all           = 1;
            $lesson_log->create_at           = time();
            $lesson_log->count_question_true = $up_question_true == true ? 1 : 0;
            $lesson_log->turn_right          = 0;
            $lesson_log->save();
        }
        event(new SubmitQuestionEvent($questionParent, $this->request->user()));
    }

    private function checkBookmark()
    {

        return $this->request->get('type') == Question::LEARN_LAM_BOOKMARK;
//        return !UserQuestionBookmark::query()
//            ->where([
//                'user_id'=> $this->request->user()->id,
//                'question_id' => $this->question->id
//            ])->exists();
    }

}