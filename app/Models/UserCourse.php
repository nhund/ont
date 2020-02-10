<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    const STATUS_APPROVAL = 3;

    protected $table = 'user_course';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'course_id', 'status', 'created_at', 'updated_at','and_date','learn_day'
    ];
    public $timestamps = false;

    public function course()
    {
        return $this->hasOne('App\Models\Course', 'id', 'course_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }


    public function getExpiredAttribute()
    {
        return (int)$this->getOriginal('and_date') > 0 ?  ((int)$this->getOriginal('and_date') - time()) * 24 * 60 * 60 : 0;

    }
}
