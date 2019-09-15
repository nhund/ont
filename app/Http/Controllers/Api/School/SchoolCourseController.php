<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 15:45
 */

namespace App\Http\Controllers\Api\School;


use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Components\Course\CourseService;
use App\Transformers\Course\ShortCourseTransformer;

class SchoolCourseController extends Controller
{

    public function show(Request $request){

    }

    public function store(){}

    public function update(){}

    public function delete(){}

    /**
     * @param $school_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function freeCourses($school_id, Request $request){

        $freeCourse = (new CourseService())->getCoursesOfByStatus([Course::TYPE_FREE_TIME], $school_id);

        return fractal()
            ->collection($freeCourse, new ShortCourseTransformer)
            ->respond();
    }

    /**
     * @param $school_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function StickyCourses($school_id, Request $request)
    {

        $specialCourse = (new CourseService())->getStickyCourses($school_id);

        return fractal()
            ->collection($specialCourse, new ShortCourseTransformer)
            ->respond();
    }

    /**
     * @param $school_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function otherCourses($school_id, Request $request)
    {
        $otherCourse = (new CourseService())->getCoursesOfByStatus([Course::TYPE_PUBLIC, Course::TYPE_FREE_NOT_TIME], $school_id);

        return fractal()
            ->collection($otherCourse, new ShortCourseTransformer)
            ->respond();
    }

}