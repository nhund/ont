<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\ExamQuestion;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends AdminBaseController
{
    public function handle(Request $request) {
        $question       = $request->input('question');
        $explain        = $request->input('explain', '');
        $type           = $request->input('type');
        $sub_question   = $request->input('sub_question');
        $sub_explain    = $request->input('sub_explain');
        $lesson_id      = $request->input('lesson_id');

        $typeLesson     = $request->input('type_lesson');

        if ($question) {
            foreach ($question as $k => $quest) {
                $qid = Question::insertGetId([
                    'content'       => $quest,
                    'lesson_id'     => $lesson_id,
                    'user_id'       => Auth::user()['id'],
                    'type'          => $type[$k],
                    'explain'       => $explain[$k],
                    'created_at'    => time()
                ]);

                if ($sub_question[$k]) {
                    foreach ($sub_question[$k] as $key => $subq) {
                        Question::insert([
                            'content'       => $subq,
                            'lesson_id'     => $lesson_id,
                            'user_id'       => Auth::user()['id'],
                            'type'          => $type[$k],
                            'parent_id'     => $qid,
                            'explain'       => $sub_explain[$k][$key],
                            'created_at'    => time()
                        ]);
                    }
                }

                if ($typeLesson == Lesson::EXAM){
                    ExamQuestion::insert([
                        'lesson_id' => $lesson_id,
                        'question_id' => $lesson_id,
                        'part' => $lesson_id,
                     ]);
                }
            }
        }

        return redirect()->back();
    }

    public function upload(Request $request) {
        $file = $request->file('file');
        //dd($request->all());
        if ($file) {
            $path = '/images/exercise/';
            $destinationPath = public_path($path);
            $fileName = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            return response()->json(['status' => 1, 'name' => $fileName,'image'=>asset('public/'.$path.''.$fileName),'url'=>$path.''.$fileName]);
        }
    }
}
