<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 21/08/2019
 * Time: 09:41
 */
namespace App\Http\Controllers\Api\Auth\Social;

use App\Components\Soical\SocialAccountService;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callback($social)
    {
//        dd($social);
//        $user = SocialAccountService::createOrGetUser(Socialite::driver($social)->user(), $social);
//        auth()->login($user);

        return redirect()->to('/home');
    }
}