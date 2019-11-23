<?php

namespace App\Http\Controllers\Auth\Web;

use App\Components\Auth\Authenticator;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
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

}
