<?php

namespace App\Listeners;

use App\Events\BeginExamEvent;
use App\Events\BeginLessonEvent;
use App\Exceptions\BadRequestException;
use App\Models\Exam;
use App\Models\ExamUser;
use App\Models\ExamUserAnswer;
use App\Models\UserLessonLog;
use App\Models\UserQuestionLog;

class BeginDidQuestionListener
{
    protected $lesson;
    protected $user;

    /**
     * @param BeginLessonEvent $event
     */
    public function handle(BeginLessonEvent $event)
    {
        $this->lesson = $event->lesson;
        $this->user = $event->user;

        $this->resetQuestions();
    }

    /**
     *
     */
    private function resetQuestions(){

        UserQuestionLog::where('user_id', $this->user->id)
            ->where('lesson_id', $this->lesson->id)
            ->update(['status_delete' => UserQuestionLog::INACTIVE]);

        $userLessonLog = UserLessonLog::where('user_id', $this->user->id)
            ->where('lesson_id', $this->lesson->id)->first()
            ;

        $userLessonLog->count_all += 1;
        $userLessonLog->save();
    }
}
