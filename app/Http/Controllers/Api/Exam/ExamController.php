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
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\submitQuestionExamRequest;
use App\Http\Requests\submitQuestionRequest;
use App\Models\Exam;
use App\Models\ExamUser;
use App\Models\ExamUserAnswer;
use App\Models\Lesson;
use App\Models\Question;
use App\Transformers\Exam\ExamUserTransformer;
use App\Transformers\Exam\FullExamTransformer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ExamController extends Controller
{

    public function show( $lessonId, Request $request)
    {
        $lesson = Lesson::findOrfail($lessonId);

        $userExam = ExamUser::where('user_id', $request->user()->id)
            ->where('lesson_id', $lessonId)
            ->first();

        $exam = Exam::where('lesson_id', $lessonId)->first();

        if ($userExam && $exam && $userExam->turn > $exam->repeat_time){
            throw new BadRequestException('Bạn đã hết lượt làm bài kiểm tra, vui lòng mua thêm');
        }

        event(new BeginExamEvent($lesson, $request->user()));

        $questions = (new ExamService())->getQuestionExam($lesson, $userExam);


        return $this->respondOk($questions);
    }

    public function submitQuestion(Question $question, submitQuestionExamRequest $request)
    {
        $this->authorize('submitExam', $question);

        $result = (new SubmitQuestionExam())->submit($request, $question);

        $examService    = new ExamService();
        $answerQuestions   = $examService->resultQuestion($request->exam_id, $request->user()->id);

        return $this->respondOk(['result' =>$answerQuestions, 'answer' => $result]);
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
            ->paginate(15);

        return fractal()->collection($examUser, new ExamUserTransformer)
                ->paginateWith(new IlluminatePaginatorAdapter($examUser))
                ->respond();
    }


    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return mixed
     */
    public function resultExam(Lesson $lesson, Request $request)
    {
        $examService    = new ExamService();
        $answerQuestions   = $examService->resultQuestion($lesson->id, $request->user()->id);
        return $this->respondOk($answerQuestions);
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Lesson $lesson, Request $request)
    {
        return fractal()->item($lesson, new FullExamTransformer)
            ->respond();
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestException
     */
    public function submitExam(Lesson $lesson, Request $request)
    {
        $userExam = ExamUser::where('lesson_id', $lesson->id)->first();

        $userExam->last_at = now();
        $userExam->status = ExamUser::INACTIVE;

        if ($userExam->save()){
            return $this->message('Chúc mừng bạn đã hoàn thành bài kiểm tra')->respondOk();
        }

        throw new BadRequestException('Nộp bài kiểm tra không thành công.');
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestException
     */
    public function stopExam(Lesson $lesson, Request $request)
    {
        $userExam = ExamUser::where('lesson_id', $lesson->id)->first();

        $exam  = Exam::where('lesson_id', $lesson->id)->first();

        if($exam->stop_time <= $userExam->turn_stop){
            throw new BadRequestException('Số lần tạm dừng của bạn đã hết.');
        }

        $userExam->turn_stop += 1;
        $userExam->stopped_at = now();
        $userExam->status_stop = ExamUser::INACTIVE;
        $userExam->save();

        return fractal()->item($userExam, new ExamUserTransformer)->respond();
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestException
     */
    public function restartExam(Lesson $lesson, Request $request)
    {
        $userExam = ExamUser::where('lesson_id', $lesson->id)->first();

        if ($userExam->status_stop === ExamUser::ACTIVE){
            throw new BadRequestException('Bài kiểm tra vẫn đang chạy.');
        }

        $second = time() - strtotime($userExam->stopped_at);

        $userExam->status_stop = ExamUser::ACTIVE;
        $userExam->second_stop += $second;
        $userExam->save();
        return fractal()->item($userExam, new ExamUserTransformer)->respond();
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailResult(Lesson $lesson, Request $request)
    {
        $examUser = ExamUser::where(['user_id' => $request->user()->id, 'lesson_id' => $lesson->id])->first();

        return fractal()->item($examUser, new ExamUserTransformer)->respond();
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function finish(Lesson $lesson, Request $request)
    {
        $examUser = ExamUser::where(['user_id' => $request->user()->id, 'lesson_id' => $lesson->id])->first();
        $examUser->status = ExamUser::STOPPED ;
        $examUser->save();

        return fractal()->item($examUser, new ExamUserTransformer)->respond();
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resultBySortQuestion(Lesson $lesson, Request $request)
    {
        $result = ExamUserAnswer::where('lesson_id', $lesson->id)
            ->where('user_id',$request->user()->id)
            ->get()->toArray();

        return $this->respondOk($result);
    }
}