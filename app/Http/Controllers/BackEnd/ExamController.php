<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 24/09/2019
 * Time: 14:45
 */

namespace App\Http\Controllers\BackEnd;

use App\Components\Exam\ExamService;
use App\Models\ExamPart;
use App\Models\ExamQuestion;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
            $suggestQuestions = Question::where(function ($q) use ($keySearch){
                $q->where('question', 'like',  '%'.$keySearch.'%');
                $q->orWhere('content', 'like',  '%'.$keySearch.'%');
            })
            ->where('parent_id',0)->orderBy('order_s','ASC')
            ->paginate(30);
        }
        foreach($question as $q) {
            $q->subs = Question::where('lesson_id', '=', $lesson->id)->where('parent_id', '=', $q->id)->get();
        }

        $var['parts']           = ExamPart::where('exam_id', $id)->first();
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
            foreach ($addQuestionIds as $questionId){
                $question = [
                    'lesson_id'  => $exam_id,
                    'question_id'=> $questionId,
                    'part'       => $part
                ];
                ExamQuestion::updateOrCreate($question, ['lesson_id' => $exam_id, 'question_id' => $questionId ]);
            }
        }

        if ($removeQuestionIds and is_array($removeQuestionIds) && $exam_id && $part){
            ExamQuestion::whereIn('question_id',$removeQuestionIds)
                ->where('lesson_id', $exam_id)->delete();
        }

        return response()->json(['status' => 200, 'data' => $request->all()]);
    }

    public function partExam(Request $request)
    {
        $params = $request->only(['exam_id', 'part_1', 'part_2', 'part_3', 'part_4', 'part_5', 'part_6', 'part_7', 'part_8', 'part_9', 'part_10', 'repeat_time']);
        $examId = Arr::pull($params, 'exam_id');
        $repeatTime = Arr::pull($params, 'repeat_time');
        ExamPart::updateOrCreate(['exam_id' => $examId], $params);
        Lesson::where('id', $examId)->update(['repeat_time' => $repeatTime]);
        return response()->json(['status' => 200, 'data' => $params]);
    }

}