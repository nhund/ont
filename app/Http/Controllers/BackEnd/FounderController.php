<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\UserStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\Founder;

class FounderController extends AdminBaseController
{
    public function index(){

        $limit = 20;
        $founder = Founder::orderBy('id','DESC')->paginate($limit);
        $var['founder'] = $founder;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.founder.index'),
                'title' => 'Danh sách founder',
            ),
        );
        return view('backend.founder.index',compact('var'));
    }
    public function add()
    {
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.founder.index'),
                'title' => 'Danh sách founder',
            ),
            array(
                'url'=> route('admin.founder.add'),
                'title' => 'Thêm founder ',
            )
        );
        return view('backend.founder.add',compact('var'));
    }
    public function save(Request $request)
    {
        $data = $request->all();
        if (empty($data['img'])) {
            alert()->error('Có lỗi','Cần tải lên ảnh đại diẹn');
            return redirect()->route('admin.founder.add');
        }
        $founder = new Founder();
        $founder->img = $data['img'];
        $founder->title = $data['title'];        
        $founder->name = $data['name'];
        $founder->status = $data['status'];
        $founder->content = $data['content'];
        $founder->create_at = time();        
        if($founder->save())
        {
            //Helper::thumbImages($name,$avatar,600,600,'fit',$destinationPath.'/600_600');
            alert()->success('Thông báo','Thêm dữ liệu thành công');
            return redirect()->route('admin.founder.index');
        }else{
            alert()->error('Có lỗi','Thêm dữ liệu không thành công');
            return redirect()->route('admin.founder.add');
        }
    }
    public function edit($id,Request $request)
    {
        $founder = Founder::find($id);
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.founder.index'),
                'title' => 'Danh sách founder',
            ),
            array(
                'url'=> route('admin.founder.edit',['id'=>$id]),
                'title' => 'Sửa : '.$founder->id,
            )
        );
        $var['founder'] = $founder; 
        return view('backend.founder.edit',compact('var'));
    }
    public function update(Request $request)
    {
       $data = $request->all();
       if(!isset($data['id']))
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.founder.index');
       }
       $founder = Founder::find($data['id']);
       if(!$founder)
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.founder.index');
       }
        $founder->img = $data['img'];
        $founder->title = $data['title'];        
        $founder->name = $data['name'];
        $founder->status = $data['status'];
        $founder->content = $data['content'];
        $founder->save();
       alert()->success('Thông báo','Cập nhật thành công');
       return redirect()->route('admin.founder.index');
    }
    public function delete(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $founder = Founder::find($data['id']);
        if(!$founder)
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        //$avatar = $partner->img;        
        if($founder->delete())
        {
            //Helper::removeFolder(public_path($avatar));
            //Helper::removeFolder(public_path($avatar_thumb));
            return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
        }
        return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
    }
}
