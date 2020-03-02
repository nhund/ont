<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Feedback extends Model
{
    const STATUS_NOT_EDIT = 1;
    const STATUS_EDIT = 2;    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'feedback';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'name', 'email', 'content','course_id', 'question_id', 'user_id', 'status', 'create_date','update_date','teacher_id','question_type'];

    public $timestamps = false;
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id')->withDefault(['name'=>'']);
    } 
    public function teacher()
    {
        return $this->hasOne('App\User', 'id', 'teacher_id')->withDefault(['name'=>'']);
    } 
    public function question()
    {
        if($this->question_type == Question::TYPE_FLASH_MUTI)
        {
            return $this->hasOne('App\Models\QuestionCardMuti', 'id', 'question_id')->withDefault(['question'=>'']);
        }
        return $this->hasOne('App\Models\Question', 'id', 'question_id')->withDefault(['question'=>'']);
    }
    public function course()
    {
        return $this->hasOne('App\Models\Course', 'id', 'course_id')->withDefault(['id'=>'']);
    }

    public function lesson()
    {
        return $this->hasOne(Lesson::class, 'id', 'lesson_id')->withDefault(['id'=>'']);
    }

    public function bookmark()
    {
        return $this->belongsTo(UserQuestionBookmark::class, 'question_id', 'question_id');
    }
}
