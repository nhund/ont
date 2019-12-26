<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 23/11/2019
 * Time: 11:06
 */

namespace App\Http\Controllers\FrontEnd;


use App\Components\Exam\ExamService;
use App\Components\Recommendation\RecommendationService;
use App\Events\BeginExamEvent;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamUser;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionLogCurrent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{

    /**
     * @param $title
     * @param $id
     * @param $type
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \App\Exceptions\BadRequestException
     */
    public function index($title, $id , Request $request){
        if(!Auth::check())
        {
            alert()->error('Bạn cần đăng nhập để thực hiện hành động này');
            return redirect()->route('home');
        }
        $var = [];
        $lesson = Lesson::find($id);
        if(!$lesson)
        {
            alert()->error('Bài học không tồn tại');
            return redirect()->route('home');
        }

        if ($request->has('lesson_id')){
            $var['parentLesson'] =  Lesson::findOrFail($request->get('lesson_id'));
        }

        $lesson = Lesson::findOrfail($id);

        $userExam = ExamUser::where('user_id', $request->user()->id)
            ->where('lesson_id', $id)
            ->first();

        $exam = Exam::where('lesson_id', $id)->first();

        $questions = (new ExamService())->getQuestionExam($lesson);

        $var['exam']    = $exam;
        $var['questions'] = $questions;
        $var['course'] = Course::find($lesson->course_id);
        $var['lesson'] = $lesson;
        $var['userExam'] = ExamUser::where(['user_id' => $request->user()->id, 'lesson_id' => $lesson->id])->first();
        $var['totalQuestion'] = count($var['questions']);
        $var['finish']        = ($var['totalQuestion'] && $var['userExam']->until_number > $var['totalQuestion']) || ($userExam && $exam && $userExam->turn > $exam->repeat_time);
        $var['overtime']      = $userExam && $exam && $userExam->turn > $exam->repeat_time;

        return view('exam.layoutQuestion',compact('var'));
    }

    public function startExam($title, $id , Request $request)
    {

        if(!Auth::check())
        {
            alert()->error('Bạn cần đăng nhập để thực hiện hành động này');
            return redirect()->back();
        }
        $lesson = Lesson::find($id);
        if(!$lesson)
        {
            alert()->error('Bài học không tồn tại');
            return redirect()->route('home');
        }

        $userExam = ExamUser::where('user_id', $request->user()->id)
            ->where('lesson_id', $id)
            ->first();

        $exam = Exam::where('lesson_id', $id)->first();

        if (!($userExam && $exam && $userExam->turn > $exam->repeat_time)){
            event(new BeginExamEvent($lesson, $request->user()));
        }

        return redirect()->route('exam.question', ['title' =>str_slug($title), 'id' =>$id ]);
    }
}