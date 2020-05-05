<?php

namespace App\Events;

use App\Models\Lesson;
use App\Models\UserCourse;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class RefundCourseEvent
{
    use Dispatchable, SerializesModels, Queueable;

    public $userCourse;

    /**
     * RefundCourseEvent constructor.
     * @param UserCourse $userCourse
     * @param User $user
     */
    public function __construct(UserCourse $userCourse)
    {
        $this->userCourse = $userCourse;
    }
}
