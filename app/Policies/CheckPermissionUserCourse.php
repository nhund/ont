<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\UserCourse;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CheckPermissionUserCourse
{
    use HandlesAuthorization;

    public function permission(User $user, Course $course)
    {
        return UserCourse::where('user_id', $user->id)
                    ->where('course_id',$course->id)->exists() || $user->level == User::USER_ADMIN;
    }
}
