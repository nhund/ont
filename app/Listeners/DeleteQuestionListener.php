<?php

namespace App\Listeners;

use App\Events\BeginExamEvent;
use App\Models\Exam;
use App\Models\ExamUser;
use App\Models\ExamUserAnswer;

class DeleteQuestionListener
{
    protected $question;
    protected $user;

    /**
     * @param DeleteQuestionListener $event
     */
    public function handle(DeleteQuestionListener $event)
    {
        $this->question = $event->question;
        $this->user = $event->user;
    }

    protected function deleteQuestionLog(){


    }
}
