<?php

namespace App\Http\Controllers\Api\User;

use App\Components\User\UserUpdater;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInfoUserRequest;
use App\Http\Requests\UpdatingAvatarRequest;
use App\Transformers\Course\ShortCourseTransformer;
use App\Transformers\User\UserFull;
use Illuminate\Http\Request;
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
            ->item($request->user(), new UserFull)
            ->respond();
    }

    public function store(){}

    /**
     * @param UpdateInfoUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateInfoUserRequest $request){

        $params = $request->only(['name', 'full_name', 'phone', 'gender', 'birthday', 'status',
                                  'avatar', 'level', 'school_id', 'user_group', 'status']);
        $user = (new UserUpdater())->update($request->user(), $params);
        return fractal()
            ->item($user, new UserFull)
            ->respond();

    }

    public function delete(){}

    public function courses(Request $request)
    {
        $courses = (new CourseService($request))->searchByUser();
        return fractal()
            ->collection($courses, new ShortCourseTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($courses))
            ->respond();
    }

    /**
     * @param UpdatingAvatarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(UpdatingAvatarRequest $request)
    {
        $user = (new UserUpdater())
            ->updateAvatar($request->user(), $request->file('avatar'));

        return fractal()
            ->item($user, new UserFull)
            ->respond();
    }
}