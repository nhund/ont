<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\UserStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\School;

class SchoolController extends AdminBaseController
{
    public function index(){

        $limit = 20;
        $schools = School::orderBy('id','DESC')->paginate($limit);
        $var['schools'] = $schools;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.school.index'),
                'title' => 'Danh sách trường học',
            ),
        );
        //dd($schools);
        return view('backend.school.index',compact('var'));
    }
    public function add()
    {
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.school.index'),
                'title' => 'Danh sách trường học',
            ),
            array(
                'url'=> route('admin.school.add'),
                'title' => 'Thêm trường học',
            )
        );
        return view('backend.school.add',compact('var'));
    }
    public function save(Request $request)
    {
        $data = $request->all();
        // if (empty($data['avatar'])) {
        //     alert()->error('Có lỗi','Cần tải lên ảnh đại diện');
        //     return redirect()->route('admin.user_feel.add');
        // }
        $school = new School();      
        $school->name = $data['name'];
        $school->city = 1;       
        $school->create_at = time();   
        $school->status = $data['status'];
        if($school->save())
        {
            //Helper::thumbImages($name,$avatar,600,600,'fit',$destinationPath.'/600_600');
            alert()->success('Thông báo','Thêm dữ liệu thành công');
            return redirect()->route('admin.school.index');
        }else{
            alert()->error('Có lỗi','Thêm dữ liệu không thành công');
            return redirect()->route('admin.school.add');
        }
    }
    public function edit($id,Request $request)
    {
        $school = School::find($id);
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.school.index'),
                'title' => 'Danh sách trường học',
            ),
            array(
                'url'=> route('admin.school.edit',['id'=>$id]),
                'title' => 'Sửa : '.$school->name,
            )
        );
        $var['school'] = $school; 
        return view('backend.school.edit',compact('var'));
    }
    public function update(Request $request)
    {
       $data = $request->all();
       if(!isset($data['id']))
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.school.index');
       }
       $school = School::find($data['id']);
       if(!$school)
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.school.index');
       }
        $school->name = $data['name'];
        $school->status = $data['status'];
        $school->save();
       alert()->success('Thông báo','Cập nhật thành công');
       return redirect()->route('admin.school.index');
    }
    public function delete(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $school = School::find($data['id']);
        if(!$school)
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        //$avatar = $partner->img;        
        if($school->delete())
        {
            //Helper::removeFolder(public_path($avatar));
            //Helper::removeFolder(public_path($avatar_thumb));
            return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
        }
        return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
    }
}
