<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExceptionController extends Controller {

    public function index($error, $mess = null) {
        $message = !empty($mess) ? $mess : 'Không tìm thấy trang';
        return view('error.404',compact('message','error'));
    }

}
