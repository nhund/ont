<?php

namespace App\Policies;

use App\Exceptions\BadRequestException;
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


    /**
     * @param User $user
     * @param Question $question
     * @return bool
     * @throws BadRequestException
     */
    public function submitExam(User $user, Question $question)
    {
        $examId   = request('exam_id');
        $examUser = ExamUser::where('lesson_id', $examId)->first();

        if ($examUser->status == ExamUser::INACTIVE || $examUser->status_stop == ExamUser::INACTIVE){
            throw new BadRequestException('Bài kiểm tra đang tạm dừng hoặc chưa được bắt đầu.');
        }

        $exam   = Exam::where('lesson_id', $examId)->first();
        $lesson = Lesson::where('id', $examId)->first();
        $course = Course::where('id', $lesson->course_id)->first();


        if (!($lesson || $exam || $course)){
            throw new NotFoundException('Bài kiểm tra không tồn tại hoặc đã bị xóa.');
        }

        $passTime = (time() - strtotime($examUser->begin_at) - $examUser->second_stop)/60;

        if ($exam->minutes < $passTime){
            throw new BadRequestException('Bạn đã hết thời gian làm bài.');
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
