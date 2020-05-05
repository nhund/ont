<?php

namespace App\Components\Auth\Social;

use App\User;
use Exception;

class SocialService
{
    const FACEBOOK = 'facebook';
    const GOOGLE = 'google';

    protected $fields;

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return [
            'id' => '',
            'name' => '',
            'email' => '',
            'avatar' => '',
        ];
    }

    /**
     *  If a user has registered before using social auth, return the user
     * else, create a new user object.
     *
     * @param $social_type
     * @return User|array|bool
     */
    public function findOrCreateUser($social_type)
    {
        $authUser = User::where('social_id', $this->fields['id'])->where('social_type', '=', $social_type)->first();
        if ($authUser) {
            //update avatar facebook and google

            if(empty($authUser['avatar']))
            {
                $this->_updateAvatar($authUser);
            }
           return $authUser;
        }

        $user_new = new User();
        $user_new->email = $this->fields['email'];
        $user_new->full_name = $this->fields['name'];
        $user_new->create_at = time();
        $user_new->status = User::USER_STUDENT;
        $user_new->password = bcrypt($this->fields['id']);
        $user_new->level = User::USER_STUDENT;
        $user_new->avatar = '';
        $user_new->social_id = $this->fields['id'];
        $user_new->social_type = $social_type;
        $user_new->save();

        //update avatar
        $this->_updateAvatar($user_new);

        return $user_new;
    }

    /**
     * @param $user
     */
    protected function _updateAvatar($user)
    {
        if(empty($user->avatar) && !empty($this->fields['avatar']))
        {
            try {
                $avatar = $this->fields['avatar'];

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
            }catch (Exception $exception){
                \Log::error('message'.'---'.$exception->getMessage().'---file---'.$exception->getCode());
            }

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

    /**
     * @param $prams
     * @return $this
     */
    public function refactorFields($prams)
    {
        $fields = $this->getFields();

        $keyFields = array_keys($fields);

        foreach ($prams as $key => $pram)
        {
            if (in_array($key, $keyFields))
            {
                $fields[$key] = $pram;
            }
        }

        $this->fields = $prams;
        return $this;
    }
}