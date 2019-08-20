<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionLogCurrent extends Model
{
     const TYPE_ADD = 1;
     const TYPE_DELETE = 2;

    protected $table = 'question_log_current';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'course_id', 'content','type','create_date', 'update_date'
    ];
    public $timestamps = false;
    
    public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id')->withDefault(['name'=>'']);
    }    

}
