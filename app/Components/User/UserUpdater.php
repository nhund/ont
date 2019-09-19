<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 19/09/2019
 * Time: 15:43
 */

namespace App\Components\User;

use App\User;
use Illuminate\Support\Str;
use function Illuminate\Support\Str;

class UserUpdater
{
    /**
     * updating info of user
     *
     * @param User $user
     * @param $params
     * @return User
     */
    public function update(User $user, $params)
    {
        $attributes = $this->transformAttributes($params);
        $user->update($attributes);
        return $user->refresh();
    }

    /**
     * @param User $user
     * @param $image
     * @return User
     */
    public function updateAvatar(User $user, $image)
    {
        $name = time().'_'.Str::slug($user->name_full).'.'.$image->getClientOriginalExtension();
        $path = 'images/user/avatar/'.$user->id;
        $this->removeFolder(public_path($path));
        $destinationPath = public_path($path);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777);
        }
        $image->move($destinationPath, $name);
        $avatar = 'public/images/user/avatar/'.$user->id.'/'.$name;
        @chmod(public_path($path.'/'.$name, 0777));
        @chown(public_path($path.'/'.$name),"onthiez");
        $user->avatar = $avatar;
        $user->save();
        return $user->refresh();
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
    /**
     * refactor params request
     *
     * @param  array $attributes
     * @return array
     */
    protected function transformAttributes(array $attributes)
    {
        $map = [
            'name',
            'full_name',
            'phone',
            'gender',
            'birthday',
            'status',
            'avatar',
            'level',
            'school_id',
            'user_group',
            'status',
        ];

        foreach ($attributes as $dbKey => $key) {
            if (!in_array($dbKey, $map)){
                unset($attributes[$dbKey]);
            }
        }

        return $attributes;
    }
}