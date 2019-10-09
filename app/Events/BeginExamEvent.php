<?php

namespace App\Events;

use App\Models\Lesson;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BeginExamEvent
{
    use Dispatchable, SerializesModels;

    public $exam;

    public $user;

    /**
     * BeginExamEvent constructor.
     * @param Lesson $exam
     * @param User $user
     */
    public function __construct(Lesson $exam, User $user)
    {
        $this->exam = $exam;
        $this->user = $user;
    }
}
