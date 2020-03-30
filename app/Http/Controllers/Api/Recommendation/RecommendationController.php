<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 11/10/2019
 * Time: 10:59
 */

namespace App\Http\Controllers\Api\Recommendation;

use App\Components\Lesson\LessonService;
use App\Components\Recommendation\RecommendationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecommendationRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\UserQuestionBookmark;
use App\Models\UserQuestionLog;
use App\Transformers\Course\ShortCourseTransformer;
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
     * @param RecommendationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function replay(Course $course, RecommendationRequest $request)
    {
        $this->authorize('permission', $course);

        $question = $this->recommendationService->doingReplayQuestions($course, $request->user());
        return $this->respondOk($question);
    }

    /**
     * @param Course $course
     * @param RecommendationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function new(Course $course, RecommendationRequest $request)
    {
        $this->authorize('permission', $course);

        $question = $this->recommendationService->doingNewQuestions($course, $request->user());
        return $this->respondOk($question);
    }

    /**
     * @param Course $course
     * @param RecommendationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function wrong(Course $course, RecommendationRequest $request)
    {
        $this->authorize('permission', $course);

        $question = $this->recommendationService->doingWrongQuestions($course, $request->user());
        return $this->respondOk($question);
    }

    /**
     * @param Course $course
     * @param RecommendationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function bookmark(Course $course, RecommendationRequest $request)
    {
        $this->authorize('permission', $course);

        $question = $this->recommendationService->doingBookmarkQuestions($course, $request->user());
        return $this->respondOk($question);
    }

    /**
     * @param Course $course
     * @param RecommendationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function suggest(Course $course, RecommendationRequest $request)
    {
        $this->authorize('permission', $course);

        $question = $this->recommendationService->suggest($course, $request->user());
        return $this->respondOk($question);
    }

    /**
     * @param Course $course
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function report(Course $course, Request $request)
    {
        $this->authorize('permission', $course);

        $questionDid = UserQuestionLog::where('course_id', $course->id)
			->whereHas('question', function ($q){
				$q->typeAllow();
			})
            ->where('user_id', $request->user()->id);

        $questionsIds = $questionDid->get()->pluck('question_parent')->toArray();

        $newQuestion = Question::where('course_id', $course->id)
            ->whereNotIn('id', $questionsIds)
            ->where('parent_id', Question::PARENT_ID)
            ->count();

        $wrongQuestions = UserQuestionLog::where('course_id', $course->id)
			->whereHas('question', function ($q){
				$q->typeAllow();
			})
            ->where('user_id', $request->user()->id)
            ->where('status', Question::REPLY_ERROR)
            ->count();

        $bookmarkQuestions = UserQuestionBookmark::where('course_id', $course->id)
            ->where('user_id', $request->user()->id)
			->whereNotNull('question_id')
			->groupBy('question_id')
            ->count();

        $report['countWrongQuestion'] = $wrongQuestions;
        $report['countQuestionsBookmark'] = $bookmarkQuestions;
        $report['countDid'] = $questionDid->count();
        $report['countNewQuestion'] = $newQuestion;


        return fractal()->item($course, new ShortCourseTransformer)
            ->addMeta($report)
            ->respond();
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function click(Lesson $lesson, Request $request)
    {
        $question = $this->recommendationService->clickLesson($lesson, $request->user());
        return $this->respondOk($question);
    }
}