<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Transformers\User\UserFull;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\User
 */
class UserController extends Controller{

    public function index(){}

    public function show(Request $request){
        dd(Auth::user(),  auth()->guard('api'));
        return fractal()
            ->item($request->user())
            ->transformWith(new UserFull)
            ->respond();
    }

    public function store(){}

    public function update(){}

    public function delete(){}
}