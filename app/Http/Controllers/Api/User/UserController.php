<?php

namespace App\Http\Controllers\Api\User;

use App\Components\User\UserUpdater;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInfoUserRequest;
use App\Http\Requests\UpdatingAvatarRequest;
use App\Http\Requests\UpdatingPasswordRequest;
use App\Transformers\Course\ShortCourseTransformer;
use App\Transformers\User\UserFull;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use App\Components\Course\CourseService;
use Illuminate\Support\Facades\Hash;
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
     * updating avatar of user
     *
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

    /**
     *  updating password of user
     *
     * @param UpdatingPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthenticationException
     */
    public function updatePassword(UpdatingPasswordRequest $request)
    {

        if (!Hash::check($request->get('old_password'), $request->user()->password)){
            throw new AuthenticationException('mật khẩu cũ không chính xác');
//            return $this->respondUnauthorized();
        }

        $user = (new UserUpdater())
            ->updatePassword($request->user(), $request->get('password'));

        return fractal()
            ->item($user, new UserFull)
            ->respond();
    }
}