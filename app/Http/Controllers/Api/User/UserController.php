<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Transformers\Course\ShortCourseTransformer;
use App\Transformers\User\UserFull;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Components\Course\CourseService;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\User
 */
class UserController extends Controller{

    public function index(){}

    public function show(Request $request){
        return fractal()
            ->item($request->user())
            ->transformWith(new UserFull)
            ->respond();
    }

    public function store(){}

    public function update(){}

    public function delete(){}

    public function courses(Request $request){

        $courses = (new CourseService($request))->searchByUser();

        return fractal()
            ->collection($courses)
            ->transformWith(new ShortCourseTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($courses))
            ->respond();
    }
}