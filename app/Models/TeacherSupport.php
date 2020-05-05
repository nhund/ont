<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class TeacherSupport extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'teacher_support';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'course_id','create_date','status'
    ];
    public $timestamps = false;

    public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id')->withDefault(['name'=>'']);
    }  
    public static function boot()
    {
        parent::boot();


        self::creating(function($model){

        });
        self::created(function($model){
            if (isset($model->attributes['id']))
            { 
                $user_support = User::where('id',$model->attributes['user_id'])->first();
                if($user_support)
                {
                    if($user_support->user_group != User::SUPPORT_TEACHER)
                    {
                        $user_support->user_group = User::SUPPORT_TEACHER;
                        $user_support->save();
                    }
                }
            }
        });

        self::updating(function($model){

        });

        self::updated(function($model){
                      
        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            if (isset($model->attributes['id']))
            {
                $user_support_count = self::where('user_id',$model->attributes['user_id'])->count();
                if($user_support_count == 0)
                {
                    $user_support = User::where('id',$model->attributes['user_id'])->first();
                    if($user_support)
                    {
                        if($user_support->user_group == User::SUPPORT_TEACHER)
                        {
                            $user_support->user_group = User::USER_STUDENT;
                            $user_support->save();
                        }
                    }
                    
                }
            }
        });
    }
}
