<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;
use Illuminate\Session\Store;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;


class AdminBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, AuthenticatesUsers;

    protected $_visitor;    

    public function __construct(Store $session)
    {
        $this->middleware('admin', ['except' => ['doLogin', 'loginAdmin']]);        
    }

    public function loginAdmin()
    {

        // $this->_visitor = Auth::user();
        // if ($this->_visitor)
        // {

        //     if ((int)$this->_visitor->user_group === 1)
        //     {
        //         // only admin login
        //         return redirect()->route('admin.home');
        //     }
        //     else
        //     {
        //         return redirect()->route('home');
        //     }
        // }
        // return view('admin.dashbroad.login');
    }
    public function doLogin(Request $request)
    {
        // $data = $request->all();
        // if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']]))
        // {
        //     $user = User::where('email',$data['email'])->first();
            
        //     if((int)$user->user_group != 1)
        //     {
        //         return redirect()->route('home');
        //     }
        //     if(isset($data['remember']) && $data['remember'])
        //     {
        //         Auth::login($user, true);
        //     }
        //     else
        //     {
        //         Auth::login($user, false);
        //     }
        //     return redirect()->route('admin.home');
        // }else{            
        //     alert()->error('Có lỗi','Sai tên đăng nhập hoặc mật khẩu');
        //     return redirect()->route('admin.login');
        // }

    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('dashboard');
    }

    public function callAction($method, $parameters)
    {
        return parent::callAction($method, $parameters);
    }

}
