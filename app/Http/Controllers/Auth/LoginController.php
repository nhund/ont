<?php

namespace App\Http\Controllers\Auth;

use App\Components\Auth\Authenticator;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';


    /**
     * {@inheritdoc}
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Authenticate a given user.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        return $this->login($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            $this->username() => $request->input('email'),
            'password'        => $request->input('password'),
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * @param Request $request
     * @param $user
     * @return mixed
     * @throws \Exception
     */
    protected function authenticated(Request $request, $user)
    {
        $authenticator = new Authenticator();

        $tokenEntity = $authenticator->issueTokensUsingPasswordGrant(
            'password',
            config('auth.web_app_client.id'),
            config('auth.web_app_client.secret'),
            $user->{$this->username()},
            $request->input('password')
        );

        return $authenticator->respondWithTokens($request, $tokenEntity);
    }


    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }
        Auth::logout();
        return redirect()->route('home');
    }
}
