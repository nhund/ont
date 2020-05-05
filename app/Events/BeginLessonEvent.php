<?php

namespace App\Events;

use App\Models\Lesson;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class BeginLessonEvent
{
    use Dispatchable, SerializesModels, Queueable;

    public $lesson;

    public $user;

    /**
     * BeginLessonEvent constructor.
     * @param Lesson $lesson
     * @param User $user
     */
    public function __construct(Lesson $lesson, User $user)
    {
        $this->lesson = $lesson;
        $this->user = $user;
    }
}
