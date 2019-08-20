<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLessonLog extends Model
{
     const PASS_LY_THUYET = 1;
    // const TYPE_MUA_KHOA_HOC = 2;

    protected $table = 'user_lesson_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'course_id', 'lesson_id','count','create_at','count_question_true','count_all','pass_ly_thuyet'
    ];
    public $timestamps = false;
    
    public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id')->withDefault(['name'=>'']);
    }    

}
