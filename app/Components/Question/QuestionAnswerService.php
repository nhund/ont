<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 20/09/2019
 * Time: 17:16
 */

namespace App\Components\Question;


use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionLogCurrent;
use App\Models\TeacherSupport;
use App\Models\UserCourse;
use App\Models\UserLessonLog;
use App\Models\UserQuestionBookmark;
use App\Models\UserQuestionLog;
use App\User;
use Illuminate\Http\Request;

class QuestionAnswerService
{
    protected $request;

    protected $question;
    protected $lesson;

    public function submit(Request $request, Question $question)
    {
        $this->request  = $request;
        $this->question = $question;
        $this->lesson   = $this->getLesson($this->question->course_id);

        if (!$this->lesson) {
            //khong ton tai lesson chi cau hoi nay
            //xoa bo lich su lam bai
            UserQuestionLog::where('question_id', $this->request->get('id'))->delete();
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra, vui lòng thử lại sau'));
        }

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

        return response()->json(array('error' => false, 'msg' => 'succsess'));
    }

    protected function _saveLogQuestion($data)
    {
        $courseId       = $this->lesson->course_id;
        $lessonId       = $this->lesson->id;
        $type           = $this->request->get('type');
        $user           = $this->request->user();
        $questionParent = $this->request->get('id');

        if ($type == Question::LEARN_LAM_BOOKMARK) {
            $questionlearnedIds = [];
            $questionLearned    = QuestionLogCurrent::where('user_id', $user->id)
                ->where('course_id', $courseId)
                ->where('type', $type)->first();
            if ($questionLearned) {
                $questionlearnedIds = json_decode($questionLearned->content, true);
                if (!in_array($questionParent, $questionlearnedIds)) {
                    array_push($questionlearnedIds, $questionParent);
                    //lay tat ca cac cau bookmark
                    $questionLogs = UserQuestionBookmark::where('user_id', $user->id)->where('course_id', $courseId)->count();
                    if ($questionLogs == count($questionlearnedIds)) {
                        $questionlearnedIds = [];
                    }
                    $questionLearned->content = json_encode($questionlearnedIds);
                    $questionLearned->save();
                }

            } else {
                array_push($questionlearnedIds, $questionParent);
                $questionLearned['content'] = json_encode($questionlearnedIds);
                $this->questionLearned($questionLearned);
            }
        }
        if ($type == Question::LEARN_LAM_BAI_TAP) {
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

            }
            //neu dang click lam 1 bai bat ky
            //tong so cau hoi trong 1 lesson
            $lesson_questions = Question::where('lesson_id', $lessonId)->where('parent_id', 0)->count();
            //tong so cau hoi user da lam
            $userQuestionLog = UserQuestionLog::where('lesson_id', $lessonId)->where('user_id', $user->id)->count();
            if ($lesson_questions == $userQuestionLog) {
                UserQuestionLog::where('lesson_id', $lessonId)->where('user_id', $user->id)->delete();
            }
        }

        //ghi log neu dang lam on tap
        if ($type == Question::LEARN_LAM_CAU_CU) {
            $questionlearnedIds = [];
            $questionLearned    = QuestionLogCurrent::where('user_id', $user->id)->where('course_id', $courseId)->where('type', $type)->first();
            if ($questionLearned) {
                $questionlearnedIds = json_decode($questionLearned->content, true);
                if (!in_array($questionParent, $questionlearnedIds)) {
                    array_push($questionlearnedIds, $questionParent);
                    //lay tat ca cac cau hoi da lam
                    $questionLogs = UserQuestionLog::where('course_id', $courseId)
                        ->where('user_id', $user->id)
                        ->groupBy('question_parent')->get()->count();
                    if ($questionLogs == count($questionlearnedIds)) {
                        // neu so cau da lam xong thi reset log
                        $questionlearnedIds = [];
                    }
                    $questionLearned->content = json_encode($questionlearnedIds);
                    $questionLearned->save();
                }

            } else {

                array_push($questionlearnedIds, $questionParent);
                $questionLearned['content'] = json_encode($questionlearnedIds);
                $this->questionLearned($questionLearned);
            }
        }

        $this->logUserQuestion($data);

        $this->logUserLesson($data);
    }


    private function multiFlash()
    {
        $dataLog = array(
            'question_id'   => $this->request->get('id'),
            'status'        => $this->request->get('reply') == Question::REPLY_OK ? $this->request->get('reply') : Question::REPLY_ERROR,
            'question_type' => Question::TYPE_FLASH_MUTI
        );
        $this->_saveLogQuestion($dataLog);
    }

    private function singleFlash()
    {
        $dataLog = array(
            'question_id'   => $this->request->get('id'),
            'status'        => $this->request->get('reply') == Question::REPLY_OK ? $this->request->get('reply') : Question::REPLY_ERROR,
            'question_type' => Question::TYPE_FLASH_SINGLE
        );
        $this->_saveLogQuestion($dataLog);
    }

    private function multipleChoice()
    {
        $answers = $this->request->get('answers');
        if ($this->request->has('answers') && is_array($answers) && count($answers) > 0) {
            $result = [];
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
                if ($answerCheck && (int)$answer == (int)$answerCheck->id) {
                    $reply = QuestionAnswer::REPLY_OK;
                }
                $dataLog = array(
                    'question_id'   => $key,
                    'status'        => $reply,
                    'question_type' => Question::TYPE_TRAC_NGHIEM
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
        return response()->json(array(
            'error' => true,
            'msg'   => 'bạn chưa chọn đáp án cho câu hỏi',
            'data'  => '',
        ));
    }

    private function fillWordIntoSentence()
    {
        $answers = $this->request->get('answers');
        if ($this->request->has('answers') && is_array($answers) && count($answers) > 0) {
            $result = [];
            //dd($data['answers']);
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
    }

    private function fillWordIntoParagraph()
    {
        $txtLearnWord = $this->request->get('txtLearnWord');
        if ($this->request->has('txtLearnWord') && is_array($txtLearnWord) && count($txtLearnWord) > 0) {
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

        } else {
            return response()->json(array(
                'error' => true,
                'msg'   => 'Bạn chưa điền câu trả lời',
                'data'  => '',
            ));
        }
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
        $params['type']        = $this->request->get('type');
        $params['create_date'] = time();
        $params['update_date'] = time();

        return QuestionLogCurrent::updateOrCreate($params, [
            'user_id'   => $params['user_id'],
            'course_id' => $params['course_id'],
            'type'      => $params['type']
        ]);
    }

    private function logUserQuestion($data)
    {
        $userId      = $this->request->user()->id;
        $questionLog = UserQuestionLog::where('user_id', $userId)->where('question_id', $data['question_id'])->first();
        if ($questionLog) {
            $questionLog->status      = $data['status'];
            $questionLog->update_time = time();
            $questionLog->is_ontap    = $data['type'] == Question::LEARN_LAM_CAU_CU ? UserQuestionLog::TYPE_ON_TAP : 0;
            $questionLog->save();
        } else {
            $questionLog                  = new UserQuestionLog();
            $questionLog->user_id         = $userId;
            $questionLog->course_id       = $this->lesson->course_id;
            $questionLog->lesson_id       = $this->lesson->id;
            $questionLog->question_id     = $data['question_id'];
            $questionLog->question_parent = $data['question_parent'];
            $questionLog->note            = $data['note'] ?? '';
            $questionLog->status          = (int)$data['status'];
            $questionLog->create_at       = time();
            $questionLog->is_ontap        = $data['type'] == Question::LEARN_LAM_CAU_CU ? UserQuestionLog::TYPE_ON_TAP : 0;
            $questionLog->update_time     = time();
            $questionLog->save();
        }
    }

    private function logUserLesson($data)
    {

        $userId = $this->request->user()->id;

        $courseId = $this->lesson->course_id;
        $lessonId = $this->lesson->id;

        $up_question_true = false;

        //tong so cau hoi cua lesson
        $lesson_questions = Question::where('lesson_id', $lessonId)
            ->where('parent_id', 0)->count();

        if ($data['question_type'] == Question::TYPE_FLASH_SINGLE || $data['question_type'] == Question::TYPE_FLASH_MUTI) {
            if ((int)$data['status'] == QuestionAnswer::REPLY_OK) {
                $up_question_true = true;
            }
        } // if($data['question_type'] == Question::TYPE_DIEN_TU || $data['question_type'] == Question::TYPE_TRAC_NGHIEM)
        else {

            $count_question_child = Question::where('parent_id', $data['question_parent'])->count();
            //kiem tra xem da lam dung bn cau
            $count_question_true = UserQuestionLog::where('question_parent', $data['question_parent'])
                ->where('lesson_id', $lessonId)
                ->where('user_id', $userId)
                ->where('status', QuestionAnswer::REPLY_OK)->count();

            if ($count_question_child == $count_question_true && $count_question_true > 0) {
                $up_question_true = true;
            }
        }

        $lesson_log = UserLessonLog::where('user_id', $userId)
            ->where('lesson_id', $lessonId)->first();

        if ($lesson_log) {
            if ($up_question_true) {
                // tang so cau tra loi dung
                $lesson_log->count_question_true += 1;
                $lesson_log->save();

                //dem so cau tra loi dung cua user trong lesson
                $countUserLearnPass = UserQuestionLog::where('user_id', $userId)
                    ->where('lesson_id', $lessonId)
                    ->where('status', QuestionAnswer::REPLY_OK)->count();

                if ($countUserLearnPass >= $lesson_questions) {
                    // lam dung het tat ca cau hoi. reset tong so cau tra loi dung
                    // tang luot lam len
                    $lesson_log->count_question_true = 0;
                    $lesson_log->count               += 1;
                    $lesson_log->save();
                }
            }
        } else {
            $lesson_log                      = new UserLessonLog();
            $lesson_log->user_id             = $userId;
            $lesson_log->course_id           = $courseId;
            $lesson_log->lesson_id           = $lessonId;
            $lesson_log->count               = 1;
            $lesson_log->count_all           = 1;
            $lesson_log->create_at           = time();
            $lesson_log->count_question_true = $up_question_true == true ? 1 : 0;
            $lesson_log->save();
        }
    }

}