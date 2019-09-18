<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentCourse extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'course_comment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'course_id', 'status','parent_id','content','created_at', 'updated_at'
    ];
    public $timestamps = false;

    public function course()
    {
        return $this->hasOne('App\Models\Course', 'id', 'course_id');
    }
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id')
            ->withDefault(function ($user){
                $user->full_name = 'Default Name';
                $user->email = 'onthiez@gmail.com';
            });
    }    

    public static function boot()
    {
        parent::boot();


        self::creating(function($model){

        });
        self::created(function($model){
            
        });

        self::updating(function($model){

        });

        self::updated(function($model){

        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            if((int)$model->attributes['parent_id'] == 0)
            {
                CommentCourse::where('parent_id',$model->attributes['id'])->delete();
            }
        });
    }
}
