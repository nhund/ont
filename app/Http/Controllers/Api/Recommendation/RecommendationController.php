<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 11/10/2019
 * Time: 10:59
 */

namespace App\Http\Controllers\Api\Recommendation;

use App\Components\Recommendation\RecommendationService;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Question;
use App\Models\UserQuestionBookmark;
use App\Models\UserQuestionLog;
use Illuminate\Http\Request;

/**
 * Class RecommendationController
 * @package App\Http\Controllers\Api\Recommendation
 */
class RecommendationController extends Controller
{

    /**
     * @var RecommendationService
     */
    protected $recommendationService;

    /**
     * RecommendationController constructor.
     * @param RecommendationService $recommendationService
     */
    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * @param Course $course
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function replay(Course $course, Request $request){

        $question = $this->recommendationService->doingReplayQuestions($course, $request->user());
        return $this->respondOk($question);
    }

    /**
     * @param Course $course
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function new(Course $course, Request $request){
        $question = $this->recommendationService->doingNewQuestions($course, $request->user());
        return $this->respondOk($question);
    }

    /**
     * @param Course $course
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function wrong(Course $course, Request $request){
        $question = $this->recommendationService->doingWrongQuestions($course, $request->user());
        return $this->respondOk($question);
    }

    /**
     * @param Course $course
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookmark(Course $course, Request $request){
        $question = $this->recommendationService->doingBookmarkQuestions($course, $request->user());
        return $this->respondOk($question);
    }

    /**
     * @param Course $course
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggest(Course $course, Request $request){
        $question = $this->recommendationService->suggest($course, $request->user());
        return $this->respondOk($question);
    }

    public function report(Course $course, Request $request)
    {
        $questionDid = UserQuestionLog::where('course_id', $course->id)->where('user_id', $request->user()->id);

        $questionsIds = $questionDid->get()->pluck('question_parent')->toArray();

        $newQuestion = Question::where('course_id', $course->id)->whereNotIn('id', $questionsIds)
            ->where('parent_id', Question::PARENT_ID)
            ->count();

        UserQuestionLog::where('course_id', $course->id)->where('status', Question::REPLY_OK)->count();

        $report['countWrongQuestion'] = UserQuestionLog::where('course_id', $course->id)->where('user_id', $request->user()->id)->where('status', Question::REPLY_ERROR)->count();
        $report['countQuestionsBookmark'] = UserQuestionBookmark::where('course_id', $course->id)->where('user_id', $request->user()->id)->where('status', Question::REPLY_ERROR)->count();
        $report['countDid'] = $questionDid->count();
        $report['countNewQuestion'] = $newQuestion;

        return $this->respondOk($report);
    }
}