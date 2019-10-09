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
use App\Events\BeginExamEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\submitQuestionExamRequest;
use App\Http\Requests\submitQuestionRequest;
use App\Models\ExamUser;
use App\Models\Lesson;
use App\Models\Question;
use App\Transformers\Exam\ExamUserTransformer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ExamController extends Controller
{

    public function show( $lessonId, Request $request)
    {
        $lesson = Lesson::findOrfail($lessonId);
        $questions = (new ExamService())->getQuestionExam($lesson);

        event(new BeginExamEvent($lesson, $request->user()));

        return $this->respondOk($questions);
    }

    public function submitQuestion(Question $question, submitQuestionExamRequest $request)
    {
        $this->authorize('submitExam', $question);

        $result = (new SubmitQuestionExam())->submit($request, $question);

        return $this->respondOk($result);
    }

    /**
     * @param $examId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rank($examId, Request $request)
    {
        $examUser = ExamUser::where('lesson_id', $examId)
            ->orderBy('highest_score', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->orderBy('turn', 'ASC')
            ->paginate(10);


        return fractal()->collection($examUser, new ExamUserTransformer)
                ->paginateWith(new IlluminatePaginatorAdapter($examUser))
                ->respond();
    }
}