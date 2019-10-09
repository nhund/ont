<?php

namespace App\Events;

use App\Models\Course;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class RemoveUserCourse
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $course;
    public $user;
    /**
     * RemoveUserCourse constructor.
     * @param Course $course
     * @param User $user
     */
    public function __construct(Course $course, User $user)
    {
        $this->user   = $user;
        $this->course = $course;
    }
}
