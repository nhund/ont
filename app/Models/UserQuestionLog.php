<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuestionLog extends Model
{

     const TYPE_ON_TAP = 1;

    protected $table = 'user_question_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'course_id',
        'lesson_id',
        'question_id',
        'question_parent',
        'note',
        'status',
        'create_at',
        'update_time',
        'is_ontap',
        'correct_number',
        'wrong_number',
        'status_delete'
    ];
    public $timestamps = true;

    const ACTIVE = 'Active';
    const INACTIVE = 'Inactive';
    
    public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id')->withDefault(['name'=>'']);
    }

    public function scopeActive($query)
    {
        return $query->where('status_delete', self::ACTIVE);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

}
