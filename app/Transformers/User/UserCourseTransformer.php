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

        $expired = UserCourseService::checkExpiredCourse($userCourse);

        return [
            'id'          => $course->id,
            'name'        => $course->name,
            'avatar_thumb'=> $course->avatar_thumb,
            'price'       => $course->price,
            'discount'    => $course->discount,
            'description' => $course->description,
            'description_format' => strip_tags($course->description),
            'avatar_paht' => $course->avatar_paht,
            'sticky'      => $course->sticky,
            'expired'     => $expired,
            'percent'     => UserCourseService::getPercentCourse($userCourse),
            'date_buy'     => date('d-m-Y', $userCourse->created_at) ?? '',
            'learn_day'     => $userCourse->learn_day ?? 0
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
