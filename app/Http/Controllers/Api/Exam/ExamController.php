<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 23/09/2019
 * Time: 16:17
 */

namespace App\Http\Controllers\Api\Exam;

use App\Components\Exam\ExamService;
use App\Components\Exam\SubmitQuestionExam;
use App\Http\Controllers\Controller;
use App\Http\Requests\submitQuestionExamRequest;
use App\Http\Requests\submitQuestionRequest;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    public function show( $lessonId, Request $request)
    {
        $lesson = Lesson::findOrfail($lessonId);
        $questions = (new ExamService())->getQuestionExam($lesson);

        return $this->respondOk($questions);
    }

    public function submitQuestion(Question $question, submitQuestionExamRequest $request)
    {
        $this->authorize('submitExam', $question);

        $result = (new SubmitQuestionExam())->submit($request, $question);

        return $this->respondOk($result);
    }
}