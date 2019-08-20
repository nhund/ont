<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Contracts\Auth\Factory as Auth;

class AuthenticateAdmin
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /***
     * AuthenticateAdmin constructor.
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user())
        {
            if ($request->user()->level === User::USER_ADMIN || $request->user()->level === User::USER_TEACHER || $request->user()->user_group === User::SUPPORT_TEACHER)
            {
                return $next($request);
            }
            else
            {
                return redirect()->route('home');
            }
        }
        else
        {
            return redirect()->route('home');
        }
    }
}
