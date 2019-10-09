<?php

namespace App\Listeners;

use App\Events\RemoveUserCourse;
use App\Models\QuestionLogCurrent;
use App\Models\UserLessonLog;
use App\Models\UserQuestionLog;

class RemoveUserCourseListen
{
    private $course;
    private $user;

    /**
     * @param RemoveUserCourse $event
     */
    public function handle(RemoveUserCourse $event)
    {
        $this->course = $event->course;
        $this->user   = $event->user;
        $this->removeQuestionLogCurrent();
        $this->removeUserLessonLog();
        $this->removeUserQuestionLog();
    }

    private function removeUserQuestionLog(){
        UserQuestionLog::where('course_id', $this->course->id)
            ->where('user_id', $this->user->id)
            ->delete();
    }

    private function removeUserLessonLog(){
        UserLessonLog::where('course_id', $this->course->id)
            ->where('user_id', $this->user->id)
            ->delete();
    }

    private function removeQuestionLogCurrent(){
        QuestionLogCurrent::where('course_id', $this->course->id)
            ->where('user_id', $this->user->id)
            ->delete();
    }
}
