<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 23/09/2019
 * Time: 16:47
 */

namespace App\Transformers\Exam;


use App\Models\Lesson;
use League\Fractal\TransformerAbstract;

class FullExamTransformer extends TransformerAbstract
{
    protected $exam;
    public function transform(Lesson $lesson)
    {
        $this->exam = $lesson->exam;

        $parts = [];
        if ($this->exam){
            $parts = $this->exam->part ? $this->exam->part->toArray() : [];
        }

        return [
            'id'                 => $lesson->id,
            'name'               => $lesson->name,
            'description'        => $lesson->description,
            'description_format' => strip_tags($lesson->description),
            'minutes'            => $this->exam->minutes,
            'parts'              => $this->exam->parts,
            'repeat_time'        => $this->exam->repeat_time,
            'stop_time'          => $this->exam->stop_time,
            'min_score'          => $this->exam->min_score,
            'total_question'     => $this->exam->total_question,
            'start_time_at'      => date('d-m-Y h:i', strtotime($this->exam->start_time_at)),
            'end_time_at'        => date('d-m-Y h:i', strtotime($this->exam->end_time_at)),
            'sub_parts'          => $parts
        ];
    }
}