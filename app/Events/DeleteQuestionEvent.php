<?php

namespace App\Events;

use App\Models\Lesson;
use App\Models\Question;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class DeleteQuestionEvent
{
    use Dispatchable, SerializesModels;

    public $question;

    public $user;

    /**
     * DeleteQuestionEvent constructor.
     * @param Question $question
     * @param User $user
     */
    public function __construct(Question $question, User $user)
    {
        $this->question = $question;
        $this->user = $user;
    }

}
