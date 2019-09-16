<?php

namespace App\Components\Auth\Social;

use App\User;

class SocialService
{
    /**
     * * If a user has registered before using social auth, return the user
     * else, create a new user object.
     *
     * @param $user
     * @param $social_type
     * @return array
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
           return true;
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
}