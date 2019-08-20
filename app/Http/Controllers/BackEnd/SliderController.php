<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use App\User;
use App\Models\Slide;
class SliderController extends AdminBaseController
{
    public function index(){

        $limit = 20;
        $sliders = Slide::orderBy('id','DESC')->paginate($limit);
        $var['sliders'] = $sliders;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.slider.index'),
                'title' => 'Danh sách slider',
            ),
        );
        return view('backend.slider.index',compact('var'));
    }
    public function add()
    {
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.slider.index'),
                'title' => 'Danh sách slider',
            ),
            array(
                'url'=> route('admin.slider.add'),
                'title' => 'Thêm ảnh slider ',
            )
        );
        return view('backend.slider.add',compact('var'));
    }
    public function save(Request $request)
    {
        $data = $request->all();
        $slider = new Slide();
        $slider->img = $data['avatar'];
        $slider->title = $data['title'];
        $slider->content = $data['des'];
        $slider->url = $data['url'];
        $slider->status = $data['status'];
        $slider->create_at = time();    
        if($slider->save())
        {            
            alert()->success('Thông báo','Thêm dữ liệu thành công');
            return redirect()->route('admin.slider.index');
        }else{
            alert()->error('Có lỗi','Thêm dữ liệu không thành công');
            return redirect()->route('admin.slider.add');
        }
    }
    public function edit($id,Request $request)
    {
        $slider = Slide::find($id);
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.slider.index'),
                'title' => 'Danh sách slider',
            ),
            array(
                'url'=> route('admin.slider.edit',['id'=>$id]),
                'title' => 'Sửa : '.$slider->id,
            )
        );
        $var['slider'] = $slider;
        return view('backend.slider.edit',compact('var'));
    }
    public function update(Request $request)
    {
       $data = $request->all();
       if(!isset($data['id']))
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.slider.index');
       }
       $slider = Slide::find($data['id']);
       if(!$slider)
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.slider.index');
       }
        $slider->img = $data['avatar'];
        $slider->title = $data['title'];
        $slider->content = $data['des'];
        $slider->url = $data['url'];
        $slider->status = $data['status'];
        $slider->save();
       alert()->success('Thông báo','Cập nhật thành công');
       return redirect()->route('admin.slider.index');
    }
    public function delete(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $slider = Slide::find($data['id']);
        if(!$slider)
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $avatar = $slider->img;        
        if($slider->delete())
        {        
            return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
        }
        return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
    }
}
