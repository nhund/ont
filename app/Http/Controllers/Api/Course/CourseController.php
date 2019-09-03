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

    public function show(Course $course, Request $request){
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
}