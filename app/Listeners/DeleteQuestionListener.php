<?php

namespace App\Listeners;

use App\Events\BeginExamEvent;
use App\Events\DeleteQuestionEvent;
use App\Models\Exam;
use App\Models\ExamUser;
use App\Models\ExamUserAnswer;
use App\Models\QuestionLogCurrent;

class DeleteQuestionListener
{
    protected $question;
    protected $user;

    /**
     * @param DeleteQuestionEvent $event
     */
    public function handle(DeleteQuestionEvent $event)
    {
        $this->question = $event->question;
        $this->user = $event->user;
    }

    protected function deleteQuestionLogCurrent(){
        $log = QuestionLogCurrent::where('course_id', $this->question->course_id)->first();

        if ($log){
            $listId = json_decode($log->content,true);
            if(isset($listId[$this->question->lesson_id]))
            {
                $listQuestionLearned = $listId[$this->question->lesson_id];
                $listQuestionLearned = array_diff($listQuestionLearned, [$this->question->id]);

                $listId[$this->question->lesson_id] = $listQuestionLearned;

                $log->content = $listId;
                $log->save();
            }
        }
    }
}
