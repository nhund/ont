<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 24/09/2019
 * Time: 16:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{

    protected $table = 'exam';

    const ACTIVE = 'Active';
    const INACTIVE = 'Inactive';

    public $timestamps = true;

    protected $fillable = ['lesson_id', 'minutes', 'parts', 'repeat_time', 'stop_time', 'total_score', 'start_time_at', 'end_time_at', 'min_score', 'total_question'];

    public static function updateOrCreateExam($params)
    {
        $exam = Exam::where('lesson_id', $params['lesson_id'])->first();

        if (!$exam){
            $exam = new Exam();
        }

        $exam->lesson_id = $params['lesson_id'];
        $exam->minutes = $params['minutes'];
        $exam->parts = $params['parts'];
        $exam->repeat_time = $params['repeat_time'];
        $exam->stop_time = $params['stop_time'];
        $exam->total_score = $params['total_score'];
        $exam->min_score = $params['min_score'];
        $exam->total_question = $params['total_question'];
        $exam->start_time_at = date('Y-m-d h:i:s', strtotime($params['start_time_at']));
        $exam->end_time_at = date('Y-m-d h:i:s', strtotime($params['end_time_at']));
        $exam->save();
    }

    public function part()
    {
        return $this->hasMany(ExamPart::class, 'lesson_id', 'lesson_id');
    }
}