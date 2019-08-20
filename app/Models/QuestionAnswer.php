<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    const STATUS_ON     = 1;
    const STATUS_OFF    = 2;

    const REPLY_ERROR = 1;
    const REPLY_OK = 2;

    protected $table = 'question_answer';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id','question_id','answer','status','create_at','audio_answer','image'
    ];
    public $timestamps = false;


}
