<?php

namespace App\Http\Controllers\Api\Question;

use App\Components\Question\QuestionAnswerService;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\submitQuestionRequest;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\UserLessonLog;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller{

    protected $questionAnswerService;

    public function __construct(QuestionAnswerService $questionAnswerService)
    {
        $this->questionAnswerService = $questionAnswerService;
    }

    public function index(){}
        
    public function show(){}

    public function store(Question $question, submitQuestionRequest $request)
    {
        $this->authorize('submit', $question);

        $result = $this->questionAnswerService->submit($request, $question);

      return $this->message('gửi câu hỏi thành công')->respondOk($result);
    }

    public function theory(Lesson $lesson, Request $request){

        $logLesson = UserLessonLog::where('user_id',$request->user()->id)
            ->where('lesson_id', $lesson->id)->first();

        try {
            if($logLesson)
            {
                $logLesson->count += 1;
                $logLesson->pass_ly_thuyet = UserLessonLog::PASS_LY_THUYET;
                $logLesson->save();

            }else
            {
                $logLesson = new UserLessonLog();
                $logLesson->lesson_id = $lesson->id;
                $logLesson->user_id = $request->user()->id;
                $logLesson->count = 1;
                $logLesson->course_id = $lesson->course_id;
                $logLesson->count_question_true = 0;
                $logLesson->pass_ly_thuyet = UserLessonLog::PASS_LY_THUYET;
                $logLesson->create_at = time();
                $logLesson->save();
            }

            return $this->message('gửi câu hỏi thành công')->respondOk();

        }catch (\Exception $exception)
        {
            throw new BadRequestException('gửi câu hỏi không thành công.');
        }
    }

    public function delete(){}
}