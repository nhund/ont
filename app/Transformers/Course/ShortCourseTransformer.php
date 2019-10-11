<?php

namespace App\Transformers\Course;

use App\Models\Course;
use App\Transformers\Category\CategoryTransformer;
use League\Fractal\TransformerAbstract;

class ShortCourseTransformer extends TransformerAbstract
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
        return [
            'id'          => $course->id,
            'name'        => $course->name,
            'avatar_thumb'=> $course->avatar_thumb,
            'price'       => $course->price,
            'study_time'  => $course->study_time,
            'discount'    => $course->discount,
            'category_id' => $course->category_id,
            'description' => $course->description,
            'description_format' => strip_tags($course->description),
            'avatar_paht' => $course->avatar_paht,
            'status'      => $course->status,
            'sticky'      => $course->sticky,
        ];
    }

    public function includeSchool(Course $course)
    {
        $school = $course->category;

        return $school ? $this->item($school, new CategoryTransformer) : null;
    }
}
