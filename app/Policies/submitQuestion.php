<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamUser;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\TeacherSupport;
use App\Models\UserCourse;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Intervention\Image\Exception\NotFoundException;

class submitQuestion
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Question $question
     * @return bool
     */
    public function submit(User $user, Question $question)
    {
        $course = Course::where('id', $question->course_id)->first();

        if (!$course){
            throw new NotFoundException('Khóa học không tồn tại hoặc đã bị xóa.');
        }

        if( $user->id === $course->user_id){
            return true;
        }

        if (!($user->id == $course->user_id || $user->level == User::USER_ADMIN)){
            return false;
        }

        $support = TeacherSupport::where('course_id', $course->id)
                    ->where('user_id', $user->id)
                    ->where('status', TeacherSupport::STATUS_ON)
                    ->first();

        $checkExist = UserCourse::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if ( !($support || $checkExist || $user->id == $course->user_id || $user->level == User::USER_ADMIN)
            || $checkExist->status == UserCourse::STATUS_APPROVAL) {
            return false;
        }

        if ($checkExist->and_date > 0 && $checkExist->and_date < time()) {
            return false;
        }

        return true;
    }


    public function submitExam(User $user, Question $question)
    {
        $examId = request('exam_id');

        $lesson = Lesson::where('id', $examId)->first();

        $examUser = ExamUser::where('lesson_id', $examId)->first();
        $exam     = Exam::where('lesson_id', $examId)->first();

//        if (){
//            $add_time=strtotime($old_date)+30;
//            $add_date= date('m/d/Y h:i:s a',$add_time);
//        }

        if ($examUser->status == ExamUser::INACTIVE || $examUser->status_stop == ExamUser::INACTIVE){
            throw new NotFoundException('Bài kiểm tra đang tạm dừng hoặc chưa được bắt đầu.');
        }



        if (!$lesson){
            throw new NotFoundException('Bài kiểm tra không tồn tại hoặc đã bị xóa.');
        }

        $course = Course::where('id', $lesson->course_id)->first();

        if (!$course){
            throw new NotFoundException('Khóa kiểm tra không tồn tại hoặc đã bị xóa.');
        }

        if( $user->id === $course->user_id){
            return true;
        }

        if (!($user->id == $course->user_id || $user->level == User::USER_ADMIN)){
            return false;
        }

        $support = TeacherSupport::where('course_id', $course->id)
                    ->where('user_id', $user->id)
                    ->where('status', TeacherSupport::STATUS_ON)
                    ->first();

        $checkExist = UserCourse::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if ( !($support || $checkExist || $user->id == $course->user_id || $user->level == User::USER_ADMIN)
            || $checkExist->status == UserCourse::STATUS_APPROVAL) {
            return false;
        }

        if ($checkExist->and_date > 0 && $checkExist->and_date < time()) {
            return false;
        }

        return true;
    }
}
