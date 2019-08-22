<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Transformers\User\UserFull;
use Illuminate\Http\Request;

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
}