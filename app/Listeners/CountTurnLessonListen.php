<?php

namespace App\Listeners;

use App\Events\SubmitQuestionEvent;
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
        $question = $event->question;
        $user     = $event->user;

        $userQuestion = UserQuestionLog::where([
            'user_id' => $user->id,
            'lesson_id' => $question->lesson_id
        ])
        ->orderBy('total_turn', 'ASC')
        ->first();

        $userLesson = UserLessonLog::where([
            'user_id' => $user->id,
            'lesson_id' => $question->lesson_id
        ])->first();

        if ($userQuestion->total_turn > $userLesson->turn){
            $userLesson->turn = $userQuestion->total_turn;
            $userLesson->save();
        }
    }
}
