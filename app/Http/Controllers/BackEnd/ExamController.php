<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 24/09/2019
 * Time: 14:45
 */

namespace App\Http\Controllers\BackEnd;

use App\Components\Exam\ExamService;
use App\Models\Exam;
use App\Models\ExamPart;
use App\Models\ExamQuestion;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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

        $var['parts']           = ExamPart::where('lesson_id', $id)->get();
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

    public function detailPartExam($id, $part_id,  Request $request) {

        $lesson  = (new ExamService())->checkPermission($id);

        if (!$lesson) {
            return redirect()->route('dashboard');
        }

        $var['page_title'] = 'Chi tiết khóa học '.$lesson->course['name'];
        $var['course']     = $lesson->course;
        $var['lesson']     = $lesson;

        $questionIds = ExamQuestion::query()->where('lesson_id', $id)
                        ->where('part', $part_id);

        $questionIds = $questionIds->get()->pluck('question_id');

        $question = Question::whereIn('id', $questionIds)
            ->typeAllow()
            ->where('parent_id',0)->orderBy('order_s','ASC')
            ->orderBy('id','ASC')->paginate(30);

        $suggestQuestions = null;

        $keySearch = $request->get('key_search');
        if ($keySearch) {

            $suggestQuestions = Question::query()->typeAllow()
                ->where(function ($q) use ($keySearch){
                $q->where('question', 'like',  '%'.$keySearch.'%');
                $q->orWhere('content', 'like',  '%'.$keySearch.'%');
            });

             if (!empty($request->get('part'))){
                 $ExceptQuestionIds = ExamQuestion::query()->where('lesson_id', $id);
                 $ExceptQuestionIds->where('part', '<>',  $request->get('part'));
                 $ExceptQuestionIds = $ExceptQuestionIds->get()->pluck('question_id');
                 $suggestQuestions->whereNotIn('id', $ExceptQuestionIds);
             };

            $suggestQuestions = $suggestQuestions->where('parent_id',0)
                ->orderBy('order_s','ASC')->paginate(30);
        }
        foreach($question as $q) {
            $q->subs = Question::where('lesson_id', '=', $lesson->id)
                ->typeAllow()
                ->where('parent_id', '=', $q->id)->get();
        }

        $var['part']           = ExamPart::where('id', $part_id)->first();
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
        return view('backend.exam.detail_part', $var);
    }

    public function store(Request $request)
    {
        $addQuestionIds = $request->get('addQuestion');
        $removeQuestionIds = $request->get('removeQuestion');
        $part = $request->get('part');
        $exam_id = $request->get('exam_id');

        if ($removeQuestionIds and is_array($removeQuestionIds) && $exam_id && $part){
            ExamQuestion::whereIn('question_id',$removeQuestionIds)
                ->where('lesson_id', $exam_id)->delete();
        }

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


        return response()->json(['status' => 200, 'data' => $request->all()]);
    }

    public function partDelete(Request $request)
    {
        $examPart = ExamPart::where('id', $request->get('part_id'))->first();

        if ($examPart){
            $examPart->delete();
        }

        return response()->json(['status' => 200, 'data' => $request->all()]);
    }

    public function partAdd(Request $request)
    {
        $params  = $request->only(['lesson_id', 'name', 'score', 'number_question']);

        $exam = Exam::where('lesson_id', $params['lesson_id'])->first();

        $examPart = ExamPart::select(DB::raw('sum(score) as total_score'))
                    ->where('lesson_id', $params['lesson_id'])
                    ->whereNotIn('id', [$request->get('id')])
                    ->groupBy('lesson_id')->first();

        $currentPart = ExamPart::where('lesson_id', $params['lesson_id'])
            ->where('id', [$request->get('id')])
            ->first();
        $totalScore = $examPart ? $examPart->total_score + (int) $params['score'] : (int) $params['score'];

        if ($exam->total_score < $totalScore){
            return response()->json(['status' => 201, 'message' => "Mức điểm tổng các phần vượt quá mức điểm tổng là {$exam->total_score} điểm"]);
        }
        if ($exam->total_question < $params['number_question']){
            return response()->json(['status' => 201, 'message' => "Số câu hỏi vượt quá tổng câu hỏi bài thi là  {$exam->total_question} câu hỏi"]);
        }

        ExamPart::updateOrCreate(['id' => $request->get('id')], $params);

        return response()->json(['status' => 200, 'data' => $request->all()]);
    }

}