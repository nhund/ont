<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class CommentQuestion extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'question_comment';

    protected $fillable = [
        'user_id', 'question_id', 'course_id','lesson_id', 'status','parent_id','content','created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')
            ->withDefault(function ($user){
                $user->full_name = 'Default Name';
                $user->email = 'onthiez@gmail.com';
            });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subComment()
    {
        return $this->hasMany(CommentQuestion::class, 'parent_id', 'id');
    }
}
