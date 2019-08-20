<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutController extends AdminBaseController
{
    public function index()
    {
        $about = About::first();
        return view('backend.about.index',compact('about'));
    }
    public function save(Request $request)
    {
        $data = $request->all();
        if(isset($data['id']))
        {
            $about = About::find($data['id']);
        }else{
            $about = new About();
            $about->create_date = time();
        }
        $about->title = $data['title'];
        $about->url = $data['url'];
        $about->address = $data['address'];
        $about->phone = $data['phone'];
        $about->email = $data['email'];
        $about->about_us = $data['about_us'];
        $about->page_facebook = $data['page_facebook'];
        $about->group_facebook = $data['group_facebook'];       
        $about->logo = isset($data['logo']) ? $data['logo'] : '';
        $about->map = $data['map'];
        $about->status = 1;
        $about->twitter = $data['twitter'];
        $about->google = $data['google'];
        $about->instagram = $data['instagram'];
        $about->youtube = $data['youtube'];
        if($about->save())
        {
            alert()->success('Cập nhật thành công');                 
        }else{
            alert()->error('Cập nhật không thành công');
        }
        return redirect()->route('admin.about.index');
    }
}
