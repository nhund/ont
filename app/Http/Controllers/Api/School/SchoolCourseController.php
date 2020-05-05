<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 15:45
 */

namespace App\Http\Controllers\Api\School;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Components\Course\CourseService;
use App\Transformers\Course\ShortCourseTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class SchoolCourseController extends Controller
{

    public function show(Request $request){

    }

    public function store(){}

    public function update(){}

    public function delete(){}

    /**
     * @param $schoolId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function freeCourses($schoolId, Request $request){

        $freeCourse = (new CourseService())->getCoursesOfByStatus([Course::TYPE_FREE_TIME], $schoolId);

        return fractal()
            ->collection($freeCourse, new ShortCourseTransformer)
            ->respond();
    }

    /**
     * @param $schoolId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function StickyCourses($schoolId, Request $request)
    {

        $specialCourse = (new CourseService())->getStickyCourses($schoolId);

        return fractal()
            ->collection($specialCourse, new ShortCourseTransformer)
            ->respond();
    }

    /**
     * @param $schoolId
     * @param Request $request
     * @return mixed
     */
    public function otherCourses($schoolId, Request $request)
    {
        $otherCourse = (new CourseService())->getOtherCourseSchoolHome( $schoolId);

        return fractal()
            ->collection($otherCourse, new ShortCourseTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($otherCourse))
            ->respond();
    }

}