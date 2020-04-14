<?php

namespace App\Http\Controllers\Auth\Web;

use App\Components\Auth\Authenticator;
use App\Http\Requests\RegisterUserRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


    /**
     * Create a new controller instance.
     *
     * RegisterController constructor.
     * @param Authenticator $authenticator
     */
    public function __construct(){
        $this->middleware('guest');

    }

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';


    /**
     * @param RegisterUserRequest $request
     * @return mixed
     * @throws \Exception
     */

    public function store(RegisterUserRequest $request)
    {
        $data = $request->all();

        $user = User::create([
             'email'     => $data['email'],
             'full_name' => $data['full_name'] ?? null,
             'phone'     => $data['phone'] ?? null,
             'password'  => bcrypt($data['password']),
             'level'     => User::USER_STUDENT,
             'status'    => User::USER_STUDENT,
             'create_at' => time()
         ]);

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * @param Request $request
     * @param $user
     * @return mixed
     * @throws \Exception
     */
    protected function registered(Request $request, $user)
    {
        return $this->message('Đăng kí tài khoản thành công')-> respondOk();
    }
}
