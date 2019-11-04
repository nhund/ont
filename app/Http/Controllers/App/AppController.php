<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;

class AppController extends Controller {

	public function getQuestion(Request $request) {

		$input = $request->all();
		$question_id = 0;
		if (isset($input['question_id']) && !empty($input['question_id'])) {
			$question_id = $input['question_id'];
		}
		$question = Question::find($question_id);
		if (!$question) {

			//return redirect()->route('home');
		}
		if($question->type == Question::TYPE_TRAC_NGHIEM)
        {
            if ($question->parent_id == 0) {
                $questionChilds = Question::where('parent_id', $question_id)->orderBy('id', 'ASC')->get();
                if (count($questionChilds) > 0) {
                    foreach ($questionChilds as $key => $questionChild) {
                        $questionChilds[$key]->answers = QuestionAnswer::where('question_id', $questionChild->id)->orderByRaw('RAND()')->get();
                    }
                }
                $question->childs = $questionChilds;
            }

        }
		if($question->type == Question::TYPE_DIEN_TU)
        {
            if ($question->parent_id == 0) {
                $question->childs = Question::where('parent_id', $question_id)->orderBy('id', 'ASC')->get();
            }
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

                            return '<nobr><input title="" type="text" name="txtLearnWord['.$sub_q->id.']['.$incr.']" class="input_answer" value= ""><img class="show_suggest" data-title='.$get_title.' src="'.asset('/public/images/course/icon/bong_den_size.png').'" align="baseline" border="0" title="Xem gợi ý" style="margin-left:6px;cursor: pointer;"></nobr>';
                        }else{
                            return '<input title="" type="text" name="txtLearnWord['.$sub_q->id.']['.$incr.']" class="input_answer" value= "">';
                        }

                    }, $str);

                    $sub_q->question_display = $content;
                }
                $question->childs =  $quesChilds;
            }
        }

		//dd($question);
		$var = [];
		$var['question'] = $question;
		//$var['answers'] =  $answers;
		return view('app.question', $var);
	}
}
