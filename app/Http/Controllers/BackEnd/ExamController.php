<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 24/09/2019
 * Time: 14:45
 */

namespace App\Http\Controllers\BackEnd;


use App\Components\Exam\ExamService;
use App\Models\Lesson;
use App\Models\Question;

class ExamController
{

    public function detail($id) {

        $lesson             = (new ExamService())->checkPermission($id);

        if (!$lesson) {
            return redirect()->route('dashboard');
        }

        $var['page_title'] = 'Chi tiết khóa học '.$lesson->course['name'];
        $var['course']     = $lesson->course;
        $var['lesson']     = $lesson;
        $question          = Question::where('lesson_id', '=', $lesson->id)
            ->where('parent_id',0)->orderBy('order_s','ASC')
            ->orderBy('id','ASC')->paginate(30);

        foreach($question as $q) {
            $q->subs = Question::where('lesson_id', '=', $lesson->id)->where('parent_id', '=', $q->id)->get();
        }

        $var['questions']       = $question;
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