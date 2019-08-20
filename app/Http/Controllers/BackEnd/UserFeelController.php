<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\UserStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\UserFeel;

class UserFeelController extends AdminBaseController
{
    public function index(){

        $limit = 20;
        $users = UserFeel::orderBy('id','DESC')->paginate($limit);
        $var['users'] = $users;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.user_feel.index'),
                'title' => 'Danh sách đánh giá',
            ),
        );
        return view('backend.user_feel.index',compact('var'));
    }
    public function add()
    {
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.user_feel.index'),
                'title' => 'Danh sách đánh giá',
            ),
            array(
                'url'=> route('admin.user_feel.add'),
                'title' => 'Thêm đánh giá ',
            )
        );
        return view('backend.user_feel.add',compact('var'));
    }
    public function save(Request $request)
    {
        $data = $request->all();
        // if (empty($data['avatar'])) {
        //     alert()->error('Có lỗi','Cần tải lên ảnh đại diện');
        //     return redirect()->route('admin.user_feel.add');
        // }
        $user = new UserFeel();
        $user->avatar = $data['avatar'];
        $user->title = $data['title'];        
        $user->name = $data['name'];
        $user->status = $data['status'];
        $user->school = $data['school'];
        $user->create_date = time();        
        if($user->save())
        {
            //Helper::thumbImages($name,$avatar,600,600,'fit',$destinationPath.'/600_600');
            alert()->success('Thông báo','Thêm dữ liệu thành công');
            return redirect()->route('admin.user_feel.index');
        }else{
            alert()->error('Có lỗi','Thêm dữ liệu không thành công');
            return redirect()->route('admin.user_feel.add');
        }
    }
    public function edit($id,Request $request)
    {
        $user = UserFeel::find($id);
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.user_feel.index'),
                'title' => 'Danh sách đánh giá',
            ),
            array(
                'url'=> route('admin.user_feel.edit',['id'=>$id]),
                'title' => 'Sửa : '.$user->name,
            )
        );
        $var['user'] = $user; 
        return view('backend.user_feel.edit',compact('var'));
    }
    public function update(Request $request)
    {
       $data = $request->all();
       if(!isset($data['id']))
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.user_feel.index');
       }
       $user = UserFeel::find($data['id']);
       if(!$user)
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.user_feel.index');
       }
        $user->avatar = $data['avatar'];
        $user->title = $data['title'];        
        $user->name = $data['name'];
        $user->status = $data['status'];
        $user->school = $data['school'];
        $user->save();
       alert()->success('Thông báo','Cập nhật thành công');
       return redirect()->route('admin.user_feel.index');
    }
    public function delete(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $user = UserFeel::find($data['id']);
        if(!$user)
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        //$avatar = $partner->img;        
        if($user->delete())
        {
            //Helper::removeFolder(public_path($avatar));
            //Helper::removeFolder(public_path($avatar_thumb));
            return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
        }
        return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
    }
}
