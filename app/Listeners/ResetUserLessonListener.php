<?php

namespace App\Listeners;

use App\Events\AddQuestionEvent;
use App\Models\UserLessonLog;

class ResetUserLessonListener
{
    protected $lesson_id;
    protected $user;

	/**
	 * @param AddQuestionEvent $event
	 */
    public function handle(AddQuestionEvent $event)
    {
        $this->lesson_id = $event->lesson_id;

        $this->resetUserLesson();
    }

    protected function resetUserLesson(){
        UserLessonLog::where('lesson_id', $this->lesson_id)->update(['turn_right' => 0]);
    }
}
