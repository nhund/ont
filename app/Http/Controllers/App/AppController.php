<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Question;
use App\Models\QuestionAnswer;

class AppController extends Controller
{

    public function getQuestion(Request $request)
    {
        $input = $request->all();
        $question_id = 0;
        if(isset($input['question_id']) && !empty($input['question_id']))
        {
            $question_id = $input['question_id'];
        }
        $question = Question::find($question_id);
        if(!$question)
        {

            //return redirect()->route('home');
        }
        if($question->parent_id == 0)
        {
            $questionChilds = Question::where('parent_id',$question_id)->orderBy('id','ASC')->get();
            if(count($questionChilds) > 0)
            {
                 foreach ($questionChilds as $key => $questionChild)
                 {
                     $questionChilds[$key]->answers = QuestionAnswer::where('question_id',$questionChild->id)->orderByRaw('RAND()')->get();
                 }
            }
            $question->childs = $questionChilds;
        }
        dd($question);
        $var = [];
        $var['question'] =  $question;
        //$var['answers'] =  $answers;
        return view('app.question',$var);
    }
}
