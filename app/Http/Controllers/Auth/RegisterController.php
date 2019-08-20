<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
    public function register(Request $request)
    {
        if(Auth::check())
        {
            return redirect('/home');
        }
        $data = $request->all();
        $check = $this->affirm($request);

        if($check)
        { 
            $msg = '';
            if(isset($check['email']))
            {
                $msg = $check['email'][0];
            }
            if(isset($check['password']))
            {
                $msg = $check['password'][0];
            }
            if(isset($check['password_confirmation']))
            {
                $msg = $check['password_confirmation'][0];
            }
            return response()->json(array(
                'error' => true,
                'msg' => $msg,
            ));
        }

        $user = new User();
        //$user->name = $data['name'];
        $user->email = $data['email'];
        //$user->full_name = $data['full_name'];
        $user->create_at = time();        
        $user->status = User::USER_STUDENT;        
        $user->password = bcrypt($data['password']);
        $user->level = User::USER_STUDENT;
        $user->avatar = '';
        if($user->save())
        {
            Auth::login($user, true);
            return response()->json(array(
                'error' => false,
                'msg' => 'Chúc mừng, Bạn đã đăng ký tài khoản thành công',
            ));
        }
        return response()->json(array(
            'error' => true,
            'msg' => 'Đăng ký tài khoản không thành công',
        ));

    }
    public function affirm(Request $request)
    {
        $data = $request->all();

        $rules  =  [
            //'name'              => 'required|min:4|max:30|unique:users',
            'email'             => 'required|email|unique:users',            
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ];

        $messsages = [
            //'name.required'                     => ' Tên dăng nhập không được để trống.',
            //'name.min'                          => ' Độ dài tên tối thiểu 5 ký tự.',
            //'name.max'                          => ' Độ dài tên tối đa 30 ký tự.',
            //'name.alpha_spaces'                 => ' Tên đăng nhập chứa ký tự đặc biệt.',
            //'name.unique'                       => ' Tên đăng nhập đã tồn tại.',
            'email.required'                    => ' Email không được để trống.',
            'email.email'                       => ' Email không đúng định dạng.',
            'email.unique'                      => ' Email đã được sử dụng.',            
            'password.required'                 => ' Mật khẩu không được để trống.',
            'password.min'                      => ' Mật khẩu tối thiểu 6 ký tự.',
            'password.confirmed'                => 'Mật khẩu xác nhận không đúng',
        ];

        $validator = Validator::make($data, $rules,$messsages);

        if ($validator->fails())
        {
            $error = $validator->getMessageBag()->toArray();
            return $error;
        }
        return false;

    }
}
