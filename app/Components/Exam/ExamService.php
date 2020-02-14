<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 20/09/2019
 * Time: 16:06
 */

namespace App\Components\Exam;


use App\Components\Question\QuestionService;
use App\Events\BeginExamEvent;
use App\Models\ExamPart;
use App\Models\ExamQuestion;
use App\Models\ExamUserAnswer;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\TeacherSupport;
use App\User;
use Auth;

class ExamService
{
    public function checkPermission($id) {
        if (!$id || !$lesson = Lesson::find($id)) {
            return false;
        }
        //check support
        $course_support = TeacherSupport::where('course_id',$lesson->course_id)->where('user_id',Auth::user()['id'])->first();

        if ($lesson->course['user_id'] != Auth::user()['id'] && !$course_support && Auth::user()['level'] != User::USER_ADMIN) {
            return false;
        }
        return $lesson;
    }

    public function insertExamQuestion( $question_id, $lesson_id, $part = null){
        return ExamQuestion::create([
             'lesson_id' => $lesson_id,
             'question_id' => $question_id,
             'part' => $part,
        ]);
    }

    public function getQuestionExam(Lesson $lesson)
    {
        $questionIds = ExamQuestion::where('lesson_id', $lesson->id)
            ->where('status', ExamQuestion::ACTIVE)->pluck('question_id');

        $questions = Question::whereIn('id', $questionIds)
            ->typeAllow()
            ->where('parent_id',0)->orderBy('order_s','ASC')
            ->orderBy('id','ASC')->get();

        $questions = (new QuestionService())->getQuestions($questions, $lesson);

        return $questions;
    }

    public function resultQuestion($lessonId, $userId)
    {
        return ExamPart::where('lesson_id', $lessonId)
            ->whereHas('userExamAnswer', function ($q) use ($userId){
                $q->where('exam_user_answer.user_id',$userId);
            })
            ->with(['userExamAnswer' => function ($q) use ($userId){
                $q->where('exam_user_answer.user_id',$userId);
            }])->get()->toArray();
    }
}