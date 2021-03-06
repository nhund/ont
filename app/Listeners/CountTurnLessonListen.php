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

        $correctQuestions = UserQuestionLog::where('user_id', $user->id)
            ->where('lesson_id',$question->lesson_id)
            ->where('status',Question::REPLY_OK)
            ->groupBy('question_parent')->get();

        $totalQuestions = Question::where('lesson_id', $question->lesson_id)
            ->typeAllow()
            ->where('parent_id', Question::PARENT_ID)->count();

        $userLesson = UserLessonLog::where([
            'user_id' => $user->id,
            'lesson_id' => $question->lesson_id
        ])->first();

        if ($correctQuestions->count() == $totalQuestions){
            $userLesson->turn_right += 1;
			UserQuestionLog::where('user_id', $user->id)
				->where('lesson_id',$question->lesson_id)
				->update(['status' => Question::NOT_YET]);
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
