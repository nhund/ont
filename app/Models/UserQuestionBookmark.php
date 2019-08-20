<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuestionBookmark extends Model
{
     const TYPE_ADD = 1;
     const TYPE_DELETE = 2;

    protected $table = 'question_bookmark';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'course_id', 'lesson_id','question_id','status', 'create_at'
    ];
    public $timestamps = false;
    
    public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id')->withDefault(['name'=>'']);
    }    

}
