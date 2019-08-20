<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Post;

class PostController extends Controller
{    
    
    public function detail($title,$id)
    {
        $post = Post::find($id);
        if(!$post)
        {

            return redirect()->route('home');
        }
        $var = [];
        $var['post'] =  $post;       
        return view('post.detail',$var);
    }    
}
