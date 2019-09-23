<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 23/09/2019
 * Time: 16:17
 */

namespace App\Http\Controllers\Api\Exam;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Transformers\Exam\FullExamTransformer;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    public function show($examId, Request $request)
    {
        $question = Question::where('lesson_id', '=', $examId)
            ->where('parent_id',0)->orderBy('order_s','ASC')
            ->orderBy('id','ASC')->get();

        return fractal()
            ->collection($question, new FullExamTransformer)
            ->respond();
    }
}