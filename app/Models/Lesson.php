<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    const IS_EXERCISE = 1;
    const IS_DOC = 0;

    const TRAC_NGHIEM_ANSWER_RANDOM = 2;
    const TRAC_NGHIEM_ANSWER_NOT_RANDOM = 0;

    const PARENT_ID = 0;

    const LESSON = 'lesson';
    const EXAM   = 'exam';

    const LEVEL_1 = 1;
    const LEVEL_2 = 2;

    protected $table = 'lesson';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'status', 'description', 'created_at','image', 'updated_at', 'is_exercise', 'type', 'level', 'repeat_time'
    ];
    public $timestamps = false;

    public function course()
    {
        return $this->hasOne('App\Models\Course', 'id', 'course_id');
    }

    public function question()
    {
        return $this->hasMany('App\Models\Question', 'lesson_id', 'id');
    }

    public function user_course()
    {
        return $this->hasMany('App\Models\UserCourse', 'course_id', 'course_id');
    }

    public static  function getCourseLesson($couseId) {
        $lesson = self::where('course_id', '=', $couseId)
            ->where('level', '<>', 0)
            ->orderBy('order_s','ASC')
            ->orderBy('created_at','ASC')
            ->get(['id', 'name', 'parent_id', 'is_exercise', 'status', 'type', 'level'])
            ->keyBy('id');
        if ($lesson) {
            $lesson = $lesson->toArray();
            foreach ($lesson as $value) {
                if ($value['parent_id']) {
                    $lesson[$value['parent_id']]['sub'][$value['id']] = $value['id'];
                }
            }
        }
        return $lesson;
    }
    public static function boot()
    {
        parent::boot();

        self::deleted(function($model){
            if (isset($model->attributes['id']))
            {
                $questions = Question::where('lesson_id',$model->attributes['id'])->delete();
                if($model->attributes['type'] == Lesson::EXAM){
                    Exam::where('lesson_id', $model->id)->delete();
                }

                if($model->attributes['parent_id'] == 0)
                {
                    $lesson_childs = Lesson::where('parent_id',$model->attributes['id'])->delete();
                }
            }
        });
    }

    public static function reportLesson($couseId){
        $report = self::where('status', self::STATUS_ON)
                    ->where('course_id', $couseId)
                    ->where('parent_id' , '<>', self::PARENT_ID)
                    ->whereIn('type', [self::EXAM, self::LESSON])
                    ->groupBy()
                    ->get();

        $count = [
            'theory' => 0,
            'exercise' => 0,
            'exam'  => 0
        ];

        $report->map(function($lesson) use (&$count)
        {
            if($lesson->type == self::LESSON)
            {
                if($lesson->is_exercise == self::IS_EXERCISE )
                {
                    $count['exercise'] += 1;
                }else
                {
                    $count['theory'] += 1;
                }
            }
            if($lesson->type == self::EXAM)
            {
                $count['exam'] =+ 1;
            }
        });

        return $count;
    }

    public function scopeActive($query){
        return $query->where('status', self::STATUS_ON);
    }

    public function scopeExercise($query){
        return $query->where('is_exercise', self::IS_EXERCISE);
    }

    public function is_exercise(){
        return $this->getOriginal('is_exercise') === self::IS_EXERCISE;
    }

    public function subLesson()
    {
        return $this->hasMany(Lesson::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function exam()
    {
        return $this->hasOne(Exam::class);
    }


    public function examUser()
    {
        return $this->hasMany(ExamUser::class);
    }

    public function lessonLog()
    {
        return $this->hasMany(UserLessonLog::class);
    }
}
