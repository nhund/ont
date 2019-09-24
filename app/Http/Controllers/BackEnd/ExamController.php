<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 24/09/2019
 * Time: 14:45
 */

namespace App\Http\Controllers\BackEnd;


use App\Components\Exam\ExamService;
use App\Models\ExamQuestion;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;

class ExamController
{

    public function detail($id, Request $request) {

        $lesson  = (new ExamService())->checkPermission($id);

        if (!$lesson) {
            return redirect()->route('dashboard');
        }

        $var['page_title'] = 'Chi tiết khóa học '.$lesson->course['name'];
        $var['course']     = $lesson->course;
        $var['lesson']     = $lesson;

        $questionIds = ExamQuestion::where('lesson_id', $id)->pluck('question_id');

        $question = Question::whereIn('id', $questionIds)
            ->where('parent_id',0)->orderBy('order_s','ASC')
            ->orderBy('id','ASC')->paginate(30);

        $suggestQuestions = null;
        if ($request->get('key_search')){
            $keySearch = $request->get('key_search');
            $suggestQuestions = Question::where('question', 'like', "%{$keySearch}%")
                ->where('parent_id',0)->orderBy('order_s','ASC')
                ->paginate(30);
            dd($suggestQuestions);
        }
        foreach($question as $q) {
            $q->subs = Question::where('lesson_id', '=', $lesson->id)->where('parent_id', '=', $q->id)->get();
        }

        $var['questions']       = $question;
        $var['suggestQuestions']  = $suggestQuestions;
        $var['user_course']     = $lesson->user_course->count();
        $var['course_lesson']   = Lesson::getCourseLesson($lesson->course['id']);

        $var['breadcrumb']['breadcrumb'] = array(
            array(
                'url'=> route('course.detail',['id'=>$lesson->course->id]),
                'title' => $lesson->course->name,
            ),
            array(
                'url'=>'#',
                'title'=>$lesson->name
            )
        );
        return view('backend.exam.detail', $var);
    }

}