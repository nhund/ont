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
    public function transform(Lesson $lesson)
    {
        $exam = $lesson->exam;

        $parts = [];
        if ($exam){
            $parts = $exam->part ? $exam->part->toArray() : [];
        }

        return [
            'id'          => $lesson->id,
            'name'        => $lesson->name,
            'description' => $lesson->description,
            'minutes'   => $exam->minutes,
            'parts'     => $exam->parts,
            'repeat_time'   => $exam->repeat_time,
            'stop_time'     => $exam->stop_time,
            'start_time_at' => date('d-m-Y h:i', strtotime($exam->start_time_at)),
            'end_time_at'   => date('d-m-Y h:i', strtotime($exam->end_time_at)),
            'sub_parts'         => $parts
        ];
    }
}