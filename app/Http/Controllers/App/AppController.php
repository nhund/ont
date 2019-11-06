<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;

class AppController extends Controller {

	public function getQuestion(Request $request) {

		$input = $request->all();
		$user_id = 0;
        $question_ids = [];
		if (isset($input['question_ids']) && !empty($input['question_ids'])) {
		    //dd(explode(',',$input['question_ids']));
			$question_ids = explode(',',$input['question_ids']);
		}
		if(isset($input['user_id']) && !empty($input['user_id']))
        {
            $user_id = $input['user_id'];
        }
		$questions = Question::whereIn('id',$question_ids)->get();
		if (count($questions) == 0) {

			//return redirect()->route('home');
		}

        foreach ($questions as $question)
        {
            $question->childs = $this->getQuestionDetail($question);
        }
		//dd($questions);
		$var = [];
		$var['questions'] = $questions;
		//$var['answers'] =  $answers;
		return view('app.question', $var);
	}

	public function getQuestionDetail($question)
    {
        if($question->type == Question::TYPE_TRAC_NGHIEM)
        {
            if ($question->parent_id == 0) {
                $questionChilds = Question::where('parent_id', $question->id)->orderBy('id', 'ASC')->get();
                if (count($questionChilds) > 0) {
                    foreach ($questionChilds as $key => $questionChild) {
                        $questionChilds[$key]->answers = QuestionAnswer::where('question_id', $questionChild->id)->orderByRaw('RAND()')->get();
                    }
                }
                return $questionChilds;
            }
            return [];

        }
        if($question->type == Question::TYPE_DIEN_TU)
        {
            if ($question->parent_id == 0) {
                return Question::where('parent_id', $question->id)->orderBy('id', 'ASC')->get();
            }
            return [];
        }
        if($question->type == Question::TYPE_DIEN_TU_DOAN_VAN)
        {
            if ($question->parent_id == 0) {
                $quesChilds = Question::where('parent_id',$question->id)->orderBy('id','asc')->get();
                foreach ($quesChilds as $key => $sub_q) {
                    $str = $sub_q->question;
                    $pattern = '/<a .*?class="(.*?cloze.*?)">(.*?)<\/a>/';
                    $content = preg_replace_callback($pattern, function($m) use ($sub_q) {
                        static $incr = 0;
                        $incr += 1;
                        //$title = '';
                        if( strpos($m[1], 'clozetip' ) !== false) {
                            $get_title = '';
                            $title = preg_replace_callback('/title="(.*?)"/', function($m_x) use(&$get_title) {
                                $get_title = $m_x[1];
                                return ''.$m_x[1].'';
                            },$m[1]);

                            return '<nobr>
                                        <span class="text">
                                            <span class="input">
                                                <span class="stt">'.$incr.'. </span>
                                                <input title="" type="text" data-question="'.$sub_q->id.'" data-stt="'.$incr.'" name="txtLearnWord['.$sub_q->id.']['.$incr.']" class="input_answer" value= "">
                                            </span>
                                            <span class="result"></span>
                                            </span>
                                            <img class="icon-error" src="'.asset('/public/app/icon/question-error.png').'">     
                                            <img class="icon-success" src="'.asset('/public/app/icon/question-success.png').'">     
                                            <img class="show_suggest" src="'.asset('/public/app/icon/question-sugess.png').'" align="baseline" border="0" title="Xem gợi ý" style="margin-left:6px;cursor: pointer;">
                                    </nobr>';
                        }else{
                            return '<nobr>
                                <span class="text">
                                    <span class="input">
                                        <span class="stt">'.$incr.'. </span>
                                        <input title="" type="text" data-question="'.$sub_q->id.'" data-stt="'.$incr.'" name="txtLearnWord['.$sub_q->id.']['.$incr.']" class="input_answer" value= "">
                                    </span>
                                    <span class="result"></span>
                                    </span>
                                    <img class="icon-error" src="'.asset('/public/app/icon/question-error.png').'">     
                                    <img class="icon-success" src="'.asset('/public/app/icon/question-success.png').'">                                     
                            </nobr>';
                        }

                    }, $str);

                    $sub_q->question_display = $content;
                }
                return  $quesChilds;
            }
            return [];
        }

    }
}
