<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 24/09/2019
 * Time: 16:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamUserAnswer extends Model
{
    protected $table = 'exam_user_answer';

    protected $fillable = ['lesson_id', 'user_id', 'question_id', 'turn', 'score', 'answer', 'status', 'part', 'submit_at'];

    public function getAnswerAttribute()
    {
        $answer = $this->getOriginal('answer');
        if ($answer){
            return \json_decode($answer);
        }
        return [];
    }

    public function part()
    {
        return $this->belongsTo(ExamPart::class, 'part');
    }
}