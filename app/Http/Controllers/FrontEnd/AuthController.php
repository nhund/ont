<?php
namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Socialite;
use Auth;

class AuthController extends Controller
{
    public function FBRedirect()
    {        
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function FBCallback(Request $request) {         
        $data = $request->all();
        
        $user = Socialite::driver('facebook')->stateless()->user();       //dd($user);
        $authUser = $this->findOrCreateUser($user, User::LOGIN_FB);//facebook
        if($authUser['error'])
        {
            alert()->error($authUser['msg']);
        }else{
            alert()->success($authUser['msg']);
            Auth::login($authUser['user'], true);        
        }
        return redirect()->route('home');
        
    }
    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $social_type)
    {
        $authUser = User::where('social_id', $user->id)->where('social_type', '=', $social_type)->first();
        if ($authUser) {
            //update avatar facebook and google

            if(empty($authUser->avatar) && isset($user->avatar) && !empty($user->avatar))
            {
             $this->_updateAvatar($authUser,$user->avatar); 
            }
            //alert()->success('Đăng nhập thành công');  
            return array(
                'error'=>false,
                'msg'=>'Đăng nhập thành công',
                'user'=>$authUser
            );
           // return $authUser;
        }
        $social_name = $social_type == User::LOGIN_FB ? 'facebook' : 'google';
        if(empty($user->email))
        {
            return array(
                'error'=>true,
                'msg'=>'Bạn không thể đăng ký tài khoản , do tài khoản '.$social_name.' của bạn không có email',
            );
            $user->email = $user->id.'@gmail.com';
        }
        $check_email = User::where('email', $user->email)->first();
        if($check_email)
        {
            return array(
                'error'=>true,
                'msg'=>'Bạn không thể đăng ký tài khoản , do tài khoản '.$social_name.' của bạn không có email',
            );
            
            $user->email = $user->id.'@gmail.com';
        }
        $user_new = new User();
        //$user->name = $data['name'];
        $user_new->email = $user->email;
        $user_new->full_name = $user->name;
        $user_new->create_at = time();        
        $user_new->status = User::USER_STUDENT;        
        $user_new->password = bcrypt($user->id);
        $user_new->level = User::USER_STUDENT;
        $user_new->avatar = '';
        $user_new->social_id = $user->id;
        $user_new->social_type = $social_type;
        $user_new->save();
        //update avatar
        if(isset($user->avatar) && !empty($user->avatar))
        {
            $this->_updateAvatar($user_new,$user->avatar); 
        }
        return array(
                'error'=>false,
                'msg'=>'Đăng ký tài khoản thành công',
                'user'=>$user_new
            );
        //alert()->success('Đăng ký tài khoản thành công');  
        //return $user_new;
    }
    protected function _updateAvatar($user,$avatar)
    {
        if(empty($user->avatar) && !empty($avatar))
        {
            $name = time().'_'.str_slug($user->name_full).'.png';
            $path = 'images/user/avatar/'.$user->id;
            //$this->removeFolder(public_path($path));
            $destinationPath = public_path($path);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777);
            }
            $this->downloadFile($avatar,public_path($path.'/'.$name));
            $user->avatar = 'public/'.$path.'/'.$name;
            $user->save();
        }
    }
    public function downloadFile($url, $path)
    {
        $newfname = $path;
        $file = fopen ($url, 'rb');
        if ($file) {
            $newf = fopen ($newfname, 'wb');
            if ($newf) {
                while(!feof($file)) {
                    fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
                }
            }
        }
        if ($file) {
            fclose($file);
        }
        if ($newf) {
            fclose($newf);
        }
    }
    public function GGRedirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function GGCallback()
    {
        $user = Socialite::driver('google')->stateless()->user(); //dd($user);
        $authUser = $this->findOrCreateUser($user, User::LOGIN_GG);  //google
        if($authUser['error'])
        {
            alert()->error($authUser['msg']);
        }else{
            alert()->success($authUser['msg']);
            Auth::login($authUser['user'], true);        
        }        
        return redirect()->route('home');
    }
    protected function _call_api($data,$url)
    {
        $params = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result,true);
        return $result;
    }

}