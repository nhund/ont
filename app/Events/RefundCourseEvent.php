<?php

namespace App\Events;

use App\Models\Lesson;
use App\Models\UserCourse;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class RefundCourseEvent
{
    use Dispatchable, SerializesModels;

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
