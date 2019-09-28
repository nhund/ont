<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 23/09/2019
 * Time: 16:17
 */

namespace App\Http\Controllers\Api\Exam;

use App\Components\Exam\ExamService;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    public function show( $lessonId, Request $request)
    {
        $lesson = Lesson::findOrfail($lessonId);
        $questions = (new ExamService())->getQuestionExam($lesson);

        return $this->respondOk($questions);
    }
}