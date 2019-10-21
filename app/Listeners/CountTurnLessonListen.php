<?php

namespace App\Listeners;

use App\Events\SubmitQuestionEvent;
use App\Models\Question;
use App\Models\UserLessonLog;
use App\Models\UserQuestionLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CountTurnLessonListen
{
    /**
     * Handle the event.
     *
     * @param submitQuestionEvent $event
     */
    public function handle(SubmitQuestionEvent $event)
    {
        $question = Question::where('id', $event->questionId)->first();
        $user     = $event->user;

        $update = false;


        $userQuestion = UserQuestionLog::where([
            'user_id' => $user->id,
            'lesson_id' => $question->lesson_id
        ])
        ->orderBy('total_turn', 'ASC')
        ->orderBy('correct_number', 'ASC')
        ->first();

        $userLesson = UserLessonLog::where([
            'user_id' => $user->id,
            'lesson_id' => $question->lesson_id
        ])->first();


        if ($userQuestion->correct_number > $userLesson->turn_right){
            $userLesson->turn_right = $userQuestion->correct_number;
            $update = true;
        }

        if ($userQuestion->total_turn > $userLesson->turn){
            $userLesson->turn = $userQuestion->total_turn;
            $update = true;
        }

        if ($update){
            $userLesson->save();
        }
    }
}
