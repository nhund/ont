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

        $keySearch = $request->get('key_search');
        if ($keySearch){
            $suggestQuestions = Question::where('question', 'like', "%{$keySearch}%")
                ->where('parent_id',0)->orderBy('order_s','ASC')
                ->paginate(30);
        }
        foreach($question as $q) {
            $q->subs = Question::where('lesson_id', '=', $lesson->id)->where('parent_id', '=', $q->id)->get();
        }

        $var['questions']       = $question;
        $var['questionIds']     = $questionIds->toArray();
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

    public function store(Request $request)
    {
        $addQuestionIds = $request->get('addQuestion');
        $removeQuestionIds = $request->get('removeQuestion');
        $part = $request->get('part');
        $exam_id = $request->get('exam_id');

        if ($addQuestionIds and is_array($addQuestionIds) && $exam_id && $part){
            $questions = [];
            foreach ($addQuestionIds as $questionId){
                $question = [
                    'lesson_id' => $exam_id,
                    'question_id'=> $questionId,
                    'part'=> $part
                ];
                array_push($questions, $question);
            }

            ExamQuestion::updateOrCreate($questions);
        }

        if ($removeQuestionIds and is_array($removeQuestionIds) && $exam_id && $part){
            ExamQuestion::whereIn('question_id',$removeQuestionIds)
                ->where('lesson_id', $exam_id)->delete();
        }

        return response()->json(['status' => 200, 'data' => $request->all()]);
    }

}