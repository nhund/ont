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
use App\Transformers\Category\CategoryTransformer;
use Illuminate\Http\Request;
use App\Components\Course\CourseService;
use App\Transformers\Course\ShortCourseTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class SchoolController extends Controller
{
    public function index(Request $request){

        $categories = Category::where('status',Category::STATUS_ON)->get();

        return fractal()
            ->collection($categories)
            ->transformWith(new CategoryTransformer)
            ->respond();
    }

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

        $limit = $request->get('limit', 1);

        $freeCourse = (new CourseService())->getCoursesOfByStatus([Course::TYPE_FREE_TIME], $limit, $school_id);

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
        $limit = $request->get('limit', 3);

        $specialCourse = (new CourseService())->getStickyCourses($limit, $school_id);

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
        $limit = $request->get('limit', 4);

        $otherCourse = (new CourseService())->getCoursesOfByStatus([Course::TYPE_PUBLIC, Course::TYPE_FREE_NOT_TIME], $limit, $school_id);

        return fractal()
            ->collection($otherCourse, new ShortCourseTransformer)
            ->respond();
    }
}