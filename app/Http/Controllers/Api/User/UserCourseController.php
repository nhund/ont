<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\UserCourse;
use App\Transformers\Course\ShortCourseTransformer;
use Illuminate\Http\Request;
use App\Components\Course\CourseService;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\User
 */
class UserCourseController extends Controller{

    public function index(){}

    public function store(){}

    public function update(){}

    public function delete(){}

    /**
     * searching source of user
     *
     * @param Request $request
     * @return mixed
     */
    public function courses(Request $request){

        $courses = (new CourseService($request))->searchByUser();

        return fractal()
            ->collection($courses)
            ->transformWith(new ShortCourseTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($courses))
            ->respond();
    }

    /**
     * report total courses by user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function report(Request $request)
    {
        $countMYCourses = UserCourse::where('user_id',$request->user()->id)->count();

        return $this->respondOk(['total_courses' => $countMYCourses]);
    }
}