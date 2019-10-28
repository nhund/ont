<?php

namespace App\Transformers\User;

use App\Components\Course\UserCourseService;
use App\Models\Course;
use App\Transformers\Category\CategoryTransformer;
use League\Fractal\TransformerAbstract;

class UserCourseTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['school'];

    /**
     * A Fractal transformer Course.
     *
     * @param Course $course
     * @return array
     */
    public function transform(Course $course)
    {
        $user = request()->user();

        $userCourse = $course->userCourse()->where('user_id', $user->id)->first();

        $remainDay  = ceil((time() - $userCourse->created_at)/(60*60*24));

        $expired = $remainDay > $userCourse->learn_day ? 0 : $remainDay;

        return [
            'id'          => $course->id,
            'name'        => $course->name,
            'avatar_thumb'=> $course->avatar_thumb,
            'price'       => $course->price,
            'discount'    => $course->discount,
            'description' => $course->description,
            'description_format' => strip_tags($course->description),
            'avatar_paht' => $course->avatar_paht,
            'status'      => $course->status,
            'sticky'      => $course->sticky,
            'expired'     => $expired,
            'percent'    => UserCourseService::getPercentCourse($userCourse)
        ];
    }

    public function includeSchool(Course $course)
    {
        $school = $course->category;

        return $school ? $this->item($school, new CategoryTransformer) : null;
    }

    public function getPercentCourse()
    {

    }
}
