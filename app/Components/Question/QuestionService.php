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

class QuestionService
{
    protected $request;

    protected $question;
    protected $lesson;

    public function __construct(Request $request, Question $question)
    {
        $this->request  = $request;
        $this->question = $question;
        $this->lesson   = $this->getLesson();
    }

    public function submit()
    {
        $question = Question::find($this->request->get('id'));
        if (!$question) {
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra, vui lòng thử lại sau'));
        }
        $lesson = Lesson::find($question->lesson_id);
        if (!$question) {
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra'));
            //return redirect()->route('home');
        }
        if (!$lesson) {
            //khong ton tai lesson chi cau hoi nay
            //xoa bo lich su lam bai
            UserQuestionLog::where('question_id', $this->request->get('id'))->delete();
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra, vui lòng thử lại sau'));
        }

        $check_permision = $this->checkPermission($this->request->user()->id, $lesson->course_id);
        if ($check_permision['error'] == true) {
            return response()->json(array('error' => true, 'msg' => $check_permision['msg']));
        }

        if ($question->type == Question::TYPE_FLASH_MUTI) {
            $this->multiFlash();
        }
        if ($question->type == Question::TYPE_FLASH_SINGLE) {
            $this->singleFlash();
        }
        if ($question->type == Question::TYPE_DIEN_TU) {
            $this->fillWordIntoSentence();
        }
        if ($question->type == Question::TYPE_TRAC_NGHIEM) {
            $this->multipleChoice();
        }
        if ($question->type == Question::TYPE_DIEN_TU_DOAN_VAN) {
            $this->fillWordIntoParagraph();
        }
        return response()->json(array('error' => false, 'msg' => 'succsess'));
    }

    public function checkPermission($user_id, $course_id)
    {
        $course = Course::find($course_id);
        if (!$course) {
            return array(
                'error' => true,
                'msg'   => 'Khóa học không tồn tại',
            );
        }
        $user = User::find($user_id);

        if ($user_id == $course->user_id || $user->level == User::USER_ADMIN) {
            return array(
                'error' => false,
                'msg'   => '',
            );
        }
        //lay danh sach tro giang
        $support = TeacherSupport::where('course_id', $course_id)->where('user_id', $user_id)->where('status', TeacherSupport::STATUS_ON)->first();
        if ($support) {
            return array(
                'error'   => false,
                'msg'     => '',
                'support' => true,
            );
        }
        $checkExist = UserCourse::where('user_id', $user_id)->where('course_id', $course_id)->first();
        if (!$checkExist) {
            return array(
                'error' => true,
                'msg'   => 'Bạn chưa mua khóa học này',
            );
        }
        //kiem tra xem trạng thai khoa hoc
        if ($checkExist->status == UserCourse::STATUS_APPROVAL) {
            return array(
                'error' => true,
                'msg'   => 'Bạn chưa được duyệt để tham gia khóa học này',
            );

        }
        //kiem tra xem trạng thai khoa hoc
        if ($checkExist->status == UserCourse::STATUS_OFF) {
            return array(
                'error' => true,
                'msg'   => 'Bạn đã bị block khỏi khóa học',
            );
        }
        if ($checkExist->and_date > 0 && $checkExist->and_date < time()) {
            return array(
                'error' => true,
                'msg'   => 'Khóa học của bạn đã hết hạn. Vui lòng gia hạn để học tiếp',
            );
        }
        return array(
            'error' => false,
            'msg'   => '',
        );
    }

    protected function _saveLogQuestion($user, $data)
    {
        if ($data['type'] == Question::LEARN_LAM_BOOKMARK) {
            $questionlearnedIds = [];
            $questionLearned    = QuestionLogCurrent::where('user_id', $user->id)->where('course_id', $data['course_id'])->where('type', $data['type'])->first();
            if ($questionLearned) {
                $questionlearnedIds = json_decode($questionLearned->content, true);
                if (!in_array($data['question_parent'], $questionlearnedIds)) {
                    array_push($questionlearnedIds, $data['question_parent']);
                    //lay tat ca cac cau bookmark
                    $questionLogs = UserQuestionBookmark::where('user_id', $user->id)->where('course_id', $data['course_id'])->count();
                    if ($questionLogs == count($questionlearnedIds)) {
                        $questionlearnedIds = [];
                    }
                    $questionLearned->content = json_encode($questionlearnedIds);
                    $questionLearned->save();
                }

            } else {

                array_push($questionlearnedIds, $data['question_parent']);
                $questionLearned              = new QuestionLogCurrent();
                $questionLearned->user_id     = $user->id;
                $questionLearned->course_id   = $data['course_id'];
                $questionLearned->content     = json_encode($questionlearnedIds);
                $questionLearned->type        = $data['type'];
                $questionLearned->create_date = time();
                $questionLearned->update_date = time();
                $questionLearned->save();
            }
            return true;
        }
        if ($data['type'] == Question::LEARN_LAM_BAI_TAP) {
            $questionlearnedIds = [];
            $questionLearned    = QuestionLogCurrent::where('user_id', $user->id)->where('course_id', $data['course_id'])->where('type', $data['type'])->first();
            if ($questionLearned) {
                $questionlearnedIds = json_decode($questionLearned->content, true);
                if (isset($questionlearnedIds[$data['lesson_id']])) {
                    if (!in_array($data['question_parent'], $questionlearnedIds[$data['lesson_id']])) {
                        array_push($questionlearnedIds[$data['lesson_id']], $data['question_parent']);
                    }
                } else {

                    $questionlearnedIds[$data['lesson_id']] = [$data['question_parent']];
                }
                //lay tat ca cau hoi cua lesson
                $lesson_questions = Question::where('lesson_id', $data['lesson_id'])->where('course_id', $data['course_id'])->where('parent_id', 0)->count();

                if ($lesson_questions == count($questionlearnedIds[$data['lesson_id']])) {
                    // neu so cau da lam xong thi reset log
                    $questionlearnedIds[$data['lesson_id']] = [];
                }
                $questionLearned->content = json_encode($questionlearnedIds);
                $questionLearned->save();

            } else {
                //$lesson_current =
                $lesson_questions = Question::where('lesson_id', $data['lesson_id'])->where('course_id', $data['course_id'])->where('parent_id', 0)->count();
                if ($lesson_questions > 1) {
                    $questionlearnedIds[$data['lesson_id']] = [$data['question_parent']];
                    //array_push($questionlearnedIds, $data['question_parent']);
                    $questionLearned              = new QuestionLogCurrent();
                    $questionLearned->user_id     = $user->id;
                    $questionLearned->course_id   = $data['course_id'];
                    $questionLearned->content     = json_encode($questionlearnedIds);
                    $questionLearned->type        = $data['type'];
                    $questionLearned->create_date = time();
                    $questionLearned->update_date = time();
                    $questionLearned->save();
                }

            }
            //neu dang click lam 1 bai bat ky
            //tong so cau hoi trong 1 lesson
            $lesson_questions = Question::where('lesson_id', $data['lesson_id'])->where('parent_id', 0)->count();
            //tong so cau hoi user da lam
            $userQuestionLog = UserQuestionLog::where('lesson_id', $data['lesson_id'])->where('user_id', $user->id)->count();
            if ($lesson_questions == $userQuestionLog) {
                UserQuestionLog::where('lesson_id', $data['lesson_id'])->where('user_id', $user->id)->delete();
            }
        }
        //dd($data);

        $questionLog = UserQuestionLog::where('user_id', $user->id)->where('question_id', $data['question_id'])->first();
        if ($questionLog) {
            $questionLog->status      = $data['status'];
            $questionLog->update_time = time();
            $questionLog->is_ontap    = $data['type'] == Question::LEARN_LAM_CAU_CU ? UserQuestionLog::TYPE_ON_TAP : 0;
            $questionLog->save();

        } else {
            $questionLog                  = new UserQuestionLog();
            $questionLog->user_id         = $user->id;
            $questionLog->course_id       = $data['course_id'];
            $questionLog->lesson_id       = $data['lesson_id'];
            $questionLog->question_id     = $data['question_id'];
            $questionLog->question_parent = $data['question_parent'];
            $questionLog->note            = $data['note'];
            $questionLog->status          = (int)$data['status'];
            $questionLog->create_at       = time();
            $questionLog->is_ontap        = $data['type'] == Question::LEARN_LAM_CAU_CU ? UserQuestionLog::TYPE_ON_TAP : 0;
            $questionLog->update_time     = time();
            $questionLog->save();
        }
        //ghi log neu dang lam on tap
        if ($data['type'] == Question::LEARN_LAM_CAU_CU) {
            $questionlearnedIds = [];
            $questionLearned    = QuestionLogCurrent::where('user_id', $user->id)->where('course_id', $data['course_id'])->where('type', $data['type'])->first();
            if ($questionLearned) {
                $questionlearnedIds = json_decode($questionLearned->content, true);
                if (!in_array($data['question_parent'], $questionlearnedIds)) {
                    array_push($questionlearnedIds, $data['question_parent']);
                    //lay tat ca cac cau hoi da lam
                    $questionLogs = UserQuestionLog::where('course_id', $data['course_id'])
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

                array_push($questionlearnedIds, $data['question_parent']);
                $questionLearned              = new QuestionLogCurrent();
                $questionLearned->user_id     = $user->id;
                $questionLearned->course_id   = $data['course_id'];
                $questionLearned->content     = json_encode($questionlearnedIds);
                $questionLearned->type        = $data['type'];
                $questionLearned->create_date = time();
                $questionLearned->update_date = time();
                $questionLearned->save();
            }
        }

        $up_question_true = false;
        //tong so cau hoi cua lesson
        $lesson_questions = Question::where('lesson_id', $data['lesson_id'])->where('parent_id', 0)->count();
        if ($data['question_type'] == Question::TYPE_FLASH_SINGLE || $data['question_type'] == Question::TYPE_FLASH_MUTI) {
            if ((int)$data['status'] == QuestionAnswer::REPLY_OK) {
                $up_question_true = true;
            }
        } // if($data['question_type'] == Question::TYPE_DIEN_TU || $data['question_type'] == Question::TYPE_TRAC_NGHIEM)
        else {
            $count_question_child = Question::where('parent_id', $data['question_parent'])->count();
            //kiem tra xem da lam dung bn cau
            $count_question_true = UserQuestionLog::where('question_parent', $data['question_parent'])->where('lesson_id', $data['lesson_id'])->where('user_id', $user->id)->where('status', QuestionAnswer::REPLY_OK)->count();
            if ($count_question_child == $count_question_true && $count_question_true > 0) {

                $up_question_true = true;
            }
        }
        $lesson_log = UserLessonLog::where('user_id', $user->id)->where('lesson_id', $data['lesson_id'])->first();
        if ($lesson_log) {
            if ($up_question_true) {
                // tang so cau tra loi dung
                $lesson_log->count_question_true += 1;
                $lesson_log->save();
                //dem so cau tra loi dung cua user trong lesson
                $countUserLearnPass = UserQuestionLog::where('user_id', $user->id)->where('lesson_id', $data['lesson_id'])->where('status', QuestionAnswer::REPLY_OK)->count();
                if ($countUserLearnPass >= $lesson_questions) {
                    // lam dung het tat ca cau hoi. reset tong so cau tra loi dung
                    // tang luot lam len
                    $lesson_log->count_question_true = 0;
                    $lesson_log->count               += 1;
                    $lesson_log->save();
                }
            }
            // xem user lam het luot chua
            $userQuestionLog = UserQuestionLog::where('lesson_id', $data['lesson_id'])->where('user_id', $user->id)->count();
            if ($userQuestionLog >= $lesson_questions) {
                //$lesson_log->count_all += 1;
                //$lesson_log->save();
            }
        } else {
            $lesson_log                      = new UserLessonLog();
            $lesson_log->user_id             = $user->id;
            $lesson_log->course_id           = $data['course_id'];
            $lesson_log->lesson_id           = $data['lesson_id'];
            $lesson_log->count               = 1;
            $lesson_log->count_all           = 1;
            $lesson_log->create_at           = time();
            $lesson_log->count_question_true = $up_question_true == true ? 1 : 0;
            $lesson_log->save();
        }
    }


    private function multiFlash()
    {
        $dataLog = array(
            'question_id'     => $this->request->get('id'),
            'course_id'       => $this->lesson->course_id,
            'lesson_id'       => $this->question->lesson_id,
            'question_parent' => $this->request->get('id'),
            'note'            => '',
            'status'          => $this->request->get('reply') == Question::REPLY_OK ? $this->request->get('reply') : Question::REPLY_ERROR,
            'type'            => $this->request->get('type'),
            'question_type'   => Question::TYPE_FLASH_MUTI
        );
        $this->_saveLogQuestion($this->request->user(), $dataLog);
    }

    private function singleFlash()
    {
        $dataLog = array(
            'question_id'     => $this->request->get('id'),
            'course_id'       => $this->lesson->course_id,
            'lesson_id'       => $this->question->lesson_id,
            'question_parent' => $this->request->get('id'),
            'note'            => '',
            'status'          => $this->request->get('reply') == Question::REPLY_OK ? $this->request->get('reply') : Question::REPLY_ERROR,
            'type'            => $this->request->get('type'),
            'question_type'   => Question::TYPE_FLASH_SINGLE
        );
        $this->_saveLogQuestion($this->request->user(), $dataLog);
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
                    'question_id'     => $key,
                    'course_id'       => $this->lesson->course_id,
                    'lesson_id'       => $this->question->lesson_id,
                    'question_parent' => $this->request->get('id'),
                    'note'            => '',
                    'status'          => $reply,
                    'type'            => $this->request->get('type'),
                    'question_type'   => Question::TYPE_TRAC_NGHIEM
                );
                $this->_saveLogQuestion($this->request->user(), $dataLog);
                $question_child = Question::find($key);
                $text         = $question_child ? $question_child->interpret : '';
                $result[$key] = array(
                    'question_id' => $key,
                    'error'       => $reply,
                    'input'       => !empty($answer) ? (int)$answer : '',
                    'answer'      => $answerCheck->id,
                    'interpret'   => !empty($text) ? $text : '',
                );
            }
            $text = $this->question ? $this->question->interpret_all : '';
            return response()->json(array(
                'error'         => false,
                'question_id'   => $this->request->get('id'),
                'msg'           => 'succsess',
                'data'          => $result,
                'interpret_all' => !empty($text) ? $text : '',
            ));
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
                    'question_id'     => $key,
                    'course_id'       => $this->lesson->course_id,
                    'lesson_id'       => $this->question->lesson_id,
                    'question_parent' => $this->request->get('id'),
                    'note'            => '',
                    'status'          => $reply,
                    'type'            => $this->request->get('type'),
                    'question_type'   => Question::TYPE_DIEN_TU
                );
                $this->_saveLogQuestion($this->request->user(), $dataLog);

                $result[$key] = array(
                    'error'  => $reply,
                    'input'  => !empty($answer) ? $answer : '',
                    'answer' => $an->answer,
                );
            }
            return response()->json(array(
                'error' => false,
                'msg'   => 'succsess',
                'data'  => $result,
            ));
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
                        'question_id'     => $question_id,
                        'course_id'       => $this->lesson->course_id,
                        'lesson_id'       => $question->lesson_id,
                        'question_parent' => $this->request->get('id'),
                        'note'            => '',
                        'status'          => $check_pass_question,
                        'type'            => $this->request->get('type'),
                        'question_type'   => Question::TYPE_DIEN_TU_DOAN_VAN
                    );
                    $this->_saveLogQuestion($this->request->user(), $dataLog);
                }
            }
            return response()->json(array(
                'error' => false,
                'msg'   => 'succsess',
                'data'  => $result,
            ));
        } else {
            return response()->json(array(
                'error' => true,
                'msg'   => 'Bạn chưa điền câu trả lời',
                'data'  => '',
            ));
        }
    }

    private function getLesson()
    {
        return Lesson::where('id', $this->question->lesson_id)->first();
    }
}