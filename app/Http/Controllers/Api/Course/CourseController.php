<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 14:20
 */

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Transformers\Course\FullCourseTransformer;
use App\Transformers\Course\ShortCourseTransformer;
use App\Components\Course\CourseService;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class CourseController extends Controller
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request){
        $courses = (new CourseService($request))->getSourcesForHomePage();

        return fractal()
            ->collection($courses)
            ->transformWith(new ShortCourseTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($courses))
            ->respond();
    }

    /**
     * @param Request $request
     * @param $courseId
     * @return mixed
     */
    public function show(Request $request,  $courseId){

        $course = Course::where('id', $courseId)->first();
        if (!$course){
            return $this->message('the course wa\'nt fount')->respondNotFound();
        }
        return fractal()
        ->item($course)
        ->transformWith(new FullCourseTransformer)
        ->respond();
    }

    public function store(){}

    public function update(){}

    public function delete(){}

    public function search(Request $request){
        $courses = (new CourseService($request))->search();

        return fractal()
        ->collection($courses)
        ->transformWith(new ShortCourseTransformer)
        ->paginateWith(new IlluminatePaginatorAdapter($courses))
        ->respond();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function freeCourses(Request $request){

        $freeCourse = $this->courseService->getCoursesOfByStatus([Course::TYPE_FREE_TIME]);

        return fractal()
            ->collection($freeCourse, new ShortCourseTransformer)
            ->respond();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function StickyCourses(Request $request)
    {
        $specialCourse = $this->courseService->getStickyCourses();

        return fractal()
            ->collection($specialCourse, new ShortCourseTransformer)
            ->respond();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function otherCourses(Request $request)
    {
        $otherCourse = $this->courseService->getCoursesOfByStatus([Course::TYPE_PUBLIC, Course::TYPE_FREE_NOT_TIME]);

        return fractal()
            ->collection($otherCourse, new ShortCourseTransformer)
            ->respond();
    }
}