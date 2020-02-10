<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Auth;
use App\Models\Slide;
use App\Models\Course;
use App\Models\About;
use App\Models\Founder;

class SearchController extends Controller
{    
    public function search(Request $request)
    {
        $data = $request->all();
        $limit = 20;
        $var = [];  
        if(isset($data['q']))
        {
            $var['courses'] = Course::where('name','like', '%' . $data['q'] . '%')->where('status','!=',Course::TYPE_PRIVATE)->paginate($limit);
            $var['q'] = $data['q'];
            $var['params']['q'] = $data['q'];
        }         
        //dd($var['courses']);                           
        return view('search.index',compact('var'));
    }
    
}
