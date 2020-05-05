<?php

namespace App\Listeners;

use App\Events\AddQuestionEvent;
use App\Models\Question;
use App\Models\UserLessonLog;
use App\Models\UserQuestionLog;

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

        $this->checkResult();
    }

    protected function resetUserLesson(){
        UserLessonLog::where('lesson_id', $this->lesson_id)->update(['turn_right' => 0]);
    }

    protected function checkResult(){

		UserQuestionLog::query()->select('user_id', \DB::raw('count(user_id) as total'))
			->whereHas('question', function ($q){
				$q->typeAllow();
			})
			->where('lesson_id', $this->lesson_id)
			->where('status', Question::NOT_YET)
			->groupBy('user_id')
			->get()->map(function ($userLesson) {

				$didTotal =  UserQuestionLog::query()->where('lesson_id',  $this->lesson_id)
					->whereHas('question', function ($q){
						$q->typeAllow();
					})
					->where('user_id', $userLesson->user_id);

				if ($userLesson->total == $didTotal->count()){
					$didTotal->update(['status' => Question::REPLY_OK]);
				}
			});
		;
	}
}
