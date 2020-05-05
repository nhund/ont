<?php

namespace App\Events;

use App\Models\Lesson;
use App\Models\Question;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AddQuestionEvent
{
    use Dispatchable, SerializesModels, Queueable;

    public $lesson_id;


	/**
	 * AddQuestionEvent constructor.
	 * @param $lesson_id
	 */
    public function __construct($lesson_id)
    {
        $this->lesson_id = $lesson_id;
    }

}
