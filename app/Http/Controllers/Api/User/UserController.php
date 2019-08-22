<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller{

    public function index(){}

    public function show(Request $request){
        dd($request->user());
    }

    public function store(){}

    public function update(){}

    public function delete(){}
}