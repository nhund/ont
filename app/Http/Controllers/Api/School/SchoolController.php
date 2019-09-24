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
use App\Models\ExamQuestion;
use App\Models\School;
use App\Transformers\Category\CategoryTransformer;
use App\Transformers\SchoolTransformer;
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

    public function allSchool(Request $request)
    {
        dd(ExamQuestion::where('lesson_id', 1386)->pluck('id'));

        $schools = School::where('status', School::STATUS_ON)->get();

        return fractal()
            ->collection($schools, new SchoolTransformer())
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
        $otherCourse = (new CourseService())->getSourcesForHomePage($school_id);

        return fractal()
            ->collection($otherCourse, new ShortCourseTransformer)
            ->respond();
    }

    public function report(){
        
    }
}