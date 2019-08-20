<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\School;

class UserController extends Controller
{        
    public function courseList()
    {
        return view('course.index');
    }
    public function courseDetail()
    {
        return view('course.detail.course');
    }
    public function myCourse()
    {
        
    }
    public function userInfo()
    {
        if(!Auth::check())
        {
             return redirect()->route('home');   
        }
        $user = Auth::user();
        $var = [];
        $var['user'] = $user;
        $var['schools'] = School::where('status',School::STATUS_ON)->get();
        return view('user.info',compact('var'));
    }
    public function updateUserInfo(Request $request)
    {
        $data = $request->all();
        if(!Auth::check())
        {
             return redirect()->route('home');   
        }
        $user = Auth::user();
        if(isset($data['full_name']) && !empty($data['full_name']))
        {
            $user->full_name = $data['full_name'];
        }
        if(isset($data['gender']) && !empty($data['gender']))
        {
            $user->gender = $data['gender'];
        }
        if(isset($data['birthday']) && !empty($data['birthday']))
        {
            $user->birthday = strtotime($data['birthday']);
        }
        if(isset($data['phone']) && !empty($data['phone']))
        {
            //check exist phone
            $user_check = User::where('phone',$data['phone'])->where('id','!=',$user->id)->first();
            if($user_check)
            {
                alert()->error('Số điện thoại đã có người sử dụng');
                return redirect()->route('userInfo');  
            }
            $user->phone = $data['phone'];
        }
        if(isset($data['note']) && !empty($data['note']))
        {
            $user->note = $data['note'];
        }
        if(isset($data['school_id']) && !empty($data['school_id']))
        {
            $user->school_id = $data['school_id'];
        }
        if($user->save())
        {
            alert()->success('Cập nhật thành công'); 
        }else{
            alert()->error('Cập nhật không thành công');
        }
        return redirect()->route('userInfo');  

    }
    public function userChangePass()
    {
        if(!Auth::check())
        {
             return redirect()->route('home');   
        }
        $user = Auth::user();
        if((int)$user->social_type > 0)
        {
            return redirect()->route('home');   
        }
        $var['user'] = $user;        
        return view('user.change_password',compact('var'));
    }
    public function saveChangePass(Request $request)
    {
        if(!Auth::check())
        {
             return redirect()->route('home');   
        }
        $user = Auth::user();
        if((int)$user->social_type > 0)
        {
            return redirect()->route('home');   
        }
        $data = $request->all(); 
        if(!isset($data['password_old']) || !isset($data['password_new']))
        {
            alert()->error('Bạn cần nhập đẩy đủ thông tin');
            return redirect()->route('user.change.password');  
        }
        if($data['password_old'] == $data['password_new'])
        {
            alert()->error('Mật khẩu mới của bạn không được trùng với mật khẩu cũ');
            return redirect()->route('user.change.password');  
        }
        if(Auth::attempt(['email' => $user->email, 'password' => $data['password_old']])){
            $user->password = bcrypt($data['password_new']);
            $user->save();
            alert()->success('Đổi mật khẩu thành công'); 
            return redirect()->route('home');
        }else{
            alert()->error('Mật khẩu cũ không chính xác');
            return redirect()->route('user.change.password'); 
        }

    }
    public function uploadAvatar(Request $request)
    {
        if(!Auth::check())
        {
            return response()->json(array('error' => true, 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $user = User::find(Auth::user()->id);
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = time().'_'.str_slug($user->name_full).'.'.$image->getClientOriginalExtension();
            $path = 'images/user/avatar/'.Auth::user()->id;
            $this->removeFolder(public_path($path));
            $destinationPath = public_path($path);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777);
            }
            $image->move($destinationPath, $name);
            $avatar = 'public/images/user/avatar/'.Auth::user()->id.'/'.$name;
            @chmod(public_path($path.'/'.$name, 0777));
            @chown(public_path($path.'/'.$name),"onthiez");
            $user->avatar = $avatar;            
            if($user->save())
            {
                //Helper::thumbImages($name,$avatar,180,180,'fit',$destinationPath.'/180_180');
                //Helper::thumbImages($name,$avatar,75,75,'fit',$destinationPath.'/75_75');
                return response()->json(array('error' => false,'url'=>asset($avatar), 'msg' => 'Cập nhật ảnh đại diện thành công'));
            }else{
                return response()->json(array('error' => true, 'msg' => 'Tải ảnh không thành công'));
            }
        }else{
            return response()->json(array('error' => true, 'msg' => 'Tải ảnh không thành công'));
        }
    }
    protected function removeFolder($str)
    {
        if (is_file($str)) {
            //Attempt to delete it.
            return unlink($str);
        }
        //If it's a directory.
        elseif (is_dir($str)) {
            //Get a list of the files in this directory.
            $scan = glob(rtrim($str,'/').'/*');
            //Loop through the list of files.
            foreach($scan as $index=>$path) {
                //Call our recursive function.
                $this->removeFolder($path);
            }
            //Remove the directory itself.
            return @rmdir($str);
        }
    }
}
