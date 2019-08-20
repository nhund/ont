<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use App\User;
use App\Models\Slide;
use App\Models\Course;
use App\Models\TeacherSupport;

class SupportController extends AdminBaseController
{
    public function index($id){

        $course = Course::find($id);
        if(!$course)
        {
            return redirect()->route('dashboard');
        }
        $limit = 20;
        $supports = TeacherSupport::where('course_id',$id)->orderBy('id','DESC')->paginate($limit);
        $var['course'] = $course;
        $var['supports'] = $supports;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('course.detail',['id'=>$id]),
                'title' => $course->name,
            ),
            array(
                'url'=> route('admin.course.support.index',['id'=>$id]),
                'title' => 'Danh sách trợ giảng',
            ),
        );
        return view('backend.course.support.index',compact('var'));
    }
    public function suggesUser(Request $request)
    {
        $data = $request->all();
        if(!isset($data['name']))
        {
            return response()->json(array('error' => true, 'msg' => 'Thiếu tham số'));
        }
        $user_search = $data['name'];
        $users = User::where(function($q) use ($user_search) {
            $q->where('users.full_name', 'LIKE',  '%'.$user_search.'%')
            ->orWhere('users.email', 'LIKE', '%'.$user_search.'%');
        })->take(10)->get();
        $var['users'] = $users;
        return response()->json([
                'error' => false,
                'html' => view('backend.course.support.list_user',$var)->render(),
                'msg' => 'Thành công'
            ]);
    }
    public function save(Request $request)
    {
        $data = $request->all();
        if(!isset($data['user_id']))
        {
            alert()->error('Có lỗi','Thêm dữ liệu không thành công');
            return redirect()->route('admin.course.support.index',['id'=>$data['course_id']]);
        }
        $course = Course::find($data['course_id']);
        //kiem tra xem da ton tai support chua
        $check = TeacherSupport::where('course_id',$data['course_id'])->where('user_id',$data['user_id'])->first();
        if($check)
        {
            alert()->error('Có lỗi','Trợ giảng đã tồn tại');
            return redirect()->route('admin.course.support.index',['id'=>$data['course_id']]);
        }
        //kiem tra xem user co phai ng tao ra khoa hoc ko
        if((int)$data['user_id'] == (int)$course->user_id)
        {
            alert()->error('Có lỗi','Thêm trợ giảng không thành công');
            return redirect()->route('admin.course.support.index',['id'=>$data['course_id']]);
        }
        $support = new TeacherSupport();
        $support->user_id = $data['user_id'];
        $support->course_id = $data['course_id'];
        $support->status = $data['status'];        
        $support->create_date = time();    
        if($support->save())
        {            
            alert()->success('Thông báo','Thêm dữ liệu thành công');
            
        }else{
            alert()->error('Có lỗi','Thêm dữ liệu không thành công');
            
        }
        return redirect()->route('admin.course.support.index',['id'=>$data['course_id']]);
    }
    
    public function delete(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $support = TeacherSupport::find($data['id']);
        if(!$support)
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
            
        if($support->delete())
        {        
            return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
        }
        return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
    }
}
