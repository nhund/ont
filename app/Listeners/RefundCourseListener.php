<?php

namespace App\Listeners;

use App\Events\BeginExamEvent;
use App\Events\RefundCourseEvent;
use App\Models\ExamUser;
use App\Models\ExamUserAnswer;
use App\Models\QuestionAnswer;
use App\Models\UserLessonLog;
use App\Models\UserQuestionLog;

class RefundCourseListener
{
    protected $userCourse;
    protected $condition;

    /**
     * @param RefundCourseEvent $event
     */
    public function handle(RefundCourseEvent $event)
    {
        $this->userCourse = $event->userCourse;

        $this->condition = [
            'user_id' => $this->userCourse->user_id,
            'course_id' => $this->userCourse->course_id
        ];

        $this->removeUserQuestionLog();
        $this->removeUserLessonLog();
        $this->removeQuestionAnswer();
    }

    private function removeQuestionAnswer()
    {
        QuestionAnswer::where($this->condition)->delete();
    }

    private function removeUserLessonLog()
    {
        UserLessonLog::where($this->condition)->delete();
    }

    private function removeUserQuestionLog(){
        UserQuestionLog::where($this->condition)->delete();
    }
}
