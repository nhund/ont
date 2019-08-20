<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRating extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'course_rating';
    protected $primaryKey = 'id';

    protected $fillable = [
        'course_id', 'rating_1', 'rating_2', 'rating_3', 'rating_4','rating_5','create_date','update_date'
    ];
    public $timestamps = false;
  
}
