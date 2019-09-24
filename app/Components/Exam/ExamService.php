<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 20/09/2019
 * Time: 16:06
 */

namespace App\Components\Exam;


use App\Models\ExamQuestion;
use App\Models\Lesson;
use App\Models\TeacherSupport;
use App\User;
use Auth;

class ExamService
{
    public function getQuestionOfExam()
    {
        
    }

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

    public function insertExamQuestion($lesson_id, $question_id, $part = null){
        return ExamQuestion::insert([
             'lesson_id' => $lesson_id,
             'question_id' => $question_id,
             'part' => $part,
        ]);
    }
}