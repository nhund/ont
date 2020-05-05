<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\UserCourse;
use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models\School;

class UserController extends AdminBaseController
{
    public function index(Request $request)
    {

        $data = $request->all();
        $params = [];
        if (!empty($data['create_at']) || !empty($data['full_name']) || !empty($data['phone']) || !empty($data['email'])) {
            $params = $data;
            //dd($params);
        }

        $users = User::searchUser($params);
        $var['users'] = $users;
        $var['breadcrumb'] = array(
            array(
                'url' => route('admin.user.index'),
                'title' => 'Danh sách thành viên',
            ),
        );
        $var['params'] = $params;
        return view('backend.user.index', compact('var'));
    }

    public function add()
    {
        $var['breadcrumb'] = array(
            array(
                'url' => route('admin.user.index'),
                'title' => 'Danh sách thành viên',
            ),
            array(
                'url' => route('admin.user.add'),
                'title' => 'Thêm thành viên',
            )
        );
        $var['schools'] = School::where('status', School::STATUS_ON)->get();
        return view('backend.user.add', compact('var'));
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $check = $this->affirm($request);
        if ($check) {
            alert()->error('Có lỗi', $check);
            return redirect()->route('admin.user.add');
        }
        if (!empty($data['phone'])) {
            //check exist phone
            $user_check = User::where('phone', $data['phone'])->first();
            if ($user_check) {
                alert()->error('Số điện thoại đã có người sử dụng');
                return redirect()->route('admin.user.add');
            }
        }
        if (!empty($data['email'])) {
            //check exist phone
            $user_check = User::where('email', $data['email'])->first();
            if ($user_check) {
                alert()->error('email đã có người sử dụng');
                return redirect()->route('admin.user.add');
            }
        }
        $user = new User();
        //$user->name = $data['name'];
        $user->full_name = $data['full_name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->gender = $data['gender'];
        if (!empty($data['birthday'])) {
            $user->birthday = strtotime($data['birthday']);
        }
        if (!empty($data['school_id'])) {
            $user->school_id = (int)$data['school_id'];
        }
        $user->create_at = time();
        $user->level = $data['level'];
        $user->status = $data['status'];
        $user->school_id = $data['school_id'];
        $user->password = bcrypt($data['password']);
        // $user->avatar = $data['gender'] == 'Female' ? User::GENDER_FEMALE : User::GENDER_MALE;
        if ($user->save()) {
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $name = time() . '_' . $user->name . '.' . $image->getClientOriginalExtension();
                $path = 'images/user/avatar/' . $user->id;
                $this->removeFolder(public_path($path));
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $image->move($destinationPath, $name);
                $avatar = 'public/images/user/avatar/' . $user->id . '/' . $name;
                $user->avatar = $avatar;
                $user->save();
            }
            alert()->success('Thông báo', 'đăng ký tài khoản thành công');
            return redirect()->route('admin.user.index');
        }
        alert()->error('Có lỗi', 'Đăng ký không thành công');
        return redirect()->route('admin.user.add');
    }

    public function edit($id, Request $request)
    {
        $user = User::find($id);
        $var['breadcrumb'] = array(
            array(
                'url' => route('admin.user.index'),
                'title' => 'Danh sách thành viên',
            ),
            array(
                'url' => route('admin.user.edit', ['id' => $id]),
                'title' => 'Sửa : ' . $user->name_full,
            )
        );
        $var['user'] = $user;
        $var['schools'] = School::where('status', School::STATUS_ON)->get();
        return view('backend.user.edit', compact('var'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        if (!isset($data['id'])) {
            alert()->error('Có lỗi', 'Có lỗi xẩy ra');
            return redirect()->route('admin.user.index');
        }
        $user = User::find($data['id']);
        $check = $this->affirm($request, false);
        if ($check) {
            alert()->error('Có lỗi', $check);
            return redirect()->route('admin.user.edit', ['id' => $user->id]);
        }
        if (!empty($data['phone'])) {
            //check exist phone
            $user_check = User::where('phone', $data['phone'])->where('id', '!=', $user->id)->first();
            if ($user_check) {
                alert()->error('Số điện thoại đã có người sử dụng');
                return redirect()->route('admin.user.edit', ['id' => $user->id]);
            }
        }
        if (!empty($data['email'])) {
            //check exist phone
            $user_check = User::where('email', $data['email'])->where('id', '!=', $user->id)->first();
            if ($user_check) {
                alert()->error('email đã có người sử dụng');
                return redirect()->route('admin.user.edit', ['id' => $user->id]);
            }
        }
        //$user->name = $data['name'];
        $user->full_name = $data['full_name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->gender = $data['gender'];

        // $user->create_at = time();
        if (!empty($data['birthday'])) {
            $user->birthday = strtotime($data['birthday']);
        }
        if (!empty($data['school_id'])) {
            $user->school_id = (int)$data['school_id'];
        }
        $user->level = $data['level'];
        $user->status = $data['status'];
        if (!empty($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
        alert()->success('Thông báo', 'Cập nhật thành công');
        return redirect()->route('admin.user.index');
    }

    public function delete(Request $request)
    {
        $data = $request->all();
        if (!isset($data['id'])) {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $user = User::find($data['id']);
        if (!$user) {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }

        if ($user->delete()) {
            return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
        }
        return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
    }

    public function affirm(Request $request, $check_pass = true)
    {
        $data = $request->all();

        $rules = [
            //'name'              => 'required|min:4|max:30|unique:users',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];

        $messsages = [
            //'name.required'                     => ' Tên dăng nhập không được để trống.',
            //'name.min'                          => ' Độ dài tên tối thiểu 5 ký tự.',
            //'name.max'                          => ' Độ dài tên tối đa 30 ký tự.',
            // 'name.unique'                       => ' Tên đăng nhập đã tồn tại.',
            'email.required' => ' Email không được để trống.',
            'email.email' => ' Email không đúng định dạng.',
            'email.unique' => ' Email đã được sử dụng.',
            'password.required' => ' Mật khẩu không được để trống.',
            'password.min' => ' Mật khẩu tối thiểu 6 ký tự.',

        ];

        $validator = Validator::make($data, $rules, $messsages);

        if ($validator->fails()) {
            $error = $validator->getMessageBag()->toArray();
            $msg = '';
            if (isset($error['name'])) {
                $msg = $error['name'][0];
            }
            if (isset($error['email'])) {
                $msg = $error['email'][0];
            }
            if (isset($error['password']) && $check_pass) {
                $msg = $error['password'][0];
            }
            return $msg;
        }
        return false;

    }

    protected function removeFolder($str)
    {
        if (is_file($str)) {
            //Attempt to delete it.
            return unlink($str);
        } //If it's a directory.
        elseif (is_dir($str)) {
            //Get a list of the files in this directory.
            $scan = glob(rtrim($str, '/') . '/*');
            //Loop through the list of files.
            foreach ($scan as $index => $path) {
                //Call our recursive function.
                $this->removeFolder($path);
            }
            //Remove the directory itself.
            return @rmdir($str);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report(){
        $limit = 20;
        $var = [];
        $var['breadcrumb'] = array(
            array(
                'url' => route('admin.report.index'),
                'title' => 'Danh sách thành viên',
            ),
        );

        $var['users'] = Wallet::where('user_wallet.status', Wallet::STATUS_ON)
            ->leftJoin('users', 'user_wallet.user_id', '=', 'users.id')
            ->orderBy('user_wallet.id', 'DESC')->paginate($limit);

        return view('backend.user.report_user', compact('var'));
    }

    /**
     * @param $id
     */
    public function detailReport($id){

        $limit = 25;
        $var = [];
        $var['histories'] =UserCourse::where('user_id',$id )->with(['user', 'course'])->orderBy('created_at','DESC')->paginate($limit);


//        dd($var['histories']);
        $var['breadcrumb'] = array(
            array(
                'url' => '',
                'title' => 'Chi tiết tài khoản',
            ),
        );
        return view('backend.user.detail_report', compact('var'));
    }
}
