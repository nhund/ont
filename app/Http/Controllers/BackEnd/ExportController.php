<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\QuestionCardMuti;
use App\Models\QuestionAnswer;
use App\Models\Lesson;
use App\Helpers\Helper;

class ExportController extends AdminBaseController
{    
    public function exportQuestion($id, Request $request)
    {        
        $data = $request->all();
        if(!isset($id))
        {
            alert()->error('Thông báo','Xuất dữ liệu không thành công');
            return redirect()->route('dashboard');
        }
        $lesson = Lesson::find($id);
        if(!$lesson)
        {
            alert()->error('Thông báo','Xuất dữ liệu không thành công');
            return redirect()->route('dashboard');
        }
        $questions = Question::where('lesson_id',$id)->where('parent_id',0)->orderBy('id','ASC')->get();
        if(count($questions) == 0)
        {
            alert()->error('Thông báo','Bài tập chưa có câu hỏi');
            return redirect()->route('lesson.detail',['id'=>$id]);
        }
        foreach($questions as $question)
        {
            if($question->type == Question::TYPE_FLASH_SINGLE)
            {

            }
            if($question->type == Question::TYPE_FLASH_MUTI)
            {
                    $cardMutiles = QuestionCardMuti::where('parent_id',$question->id)->where('lesson_id',$id)->orderBy('id','ASC')->get();

                    foreach ($cardMutiles as $key => $card) {
                        $card->child = QuestionCardMuti::where('parent_id',$card->id)->where('lesson_id',$id)->orderBy('id','ASC')->get();
                    }
                    $question->child_cards = $cardMutiles;
                    //dd($question);
            }
            if($question->type == Question::TYPE_DIEN_TU)
            {
                $questions_child = Question::where('parent_id',$question->id)->where('lesson_id',$id)->get();
                foreach ($questions_child as $question_child) {
                    $question_child->answers = QuestionAnswer::where('question_id',$question_child->id)->get();
                }
                $question->childs = $questions_child;                   
            }
            if($question->type == Question::TYPE_TRAC_NGHIEM)
            {
                $questions_child = Question::where('parent_id',$question->id)->where('lesson_id',$id)->get();
                foreach ($questions_child as $question_child) {
                    $question_child->answers = QuestionAnswer::where('question_id',$question_child->id)->get();
                }
                $question->childs = $questions_child;                
                //dd($question);        
            }
            if($question->type == Question::TYPE_DIEN_TU_DOAN_VAN)
            {
                $sub_questions = Question::where('parent_id',$question->id)->where('lesson_id',$id)->get();
                foreach ($sub_questions as $key => $sub_q) {
                        $str = $sub_q->question; 
                        $pattern = '/<a .*?class="(.*?cloze.*?)">(.*?)<\/a>/';
                        $content = preg_replace_callback($pattern, function($m) use ($sub_q) { 
                            static $incr = 0; 
                            $incr += 1;
                            //$title = '';
                            if( strpos($m[1], 'clozetip' ) !== false) {
                                $get_title = '';
                                $title = preg_replace_callback('/title="(.*?)"/', function($m_x) use(&$get_title) {     
                                    $get_title = $m_x[1]; //dd($get_title);
                                    return ''.$m_x[1].'';
                                },$m[1]);
                                
                                return '<#'.$m[2].'|'.$get_title.'#>'; 
                            }else{
                                return '<#'.$m[2].'#>';
                            }
                            
                        }, $str);
                        
                        $sub_q->question_display = $content;                    
                    }
                $question->childs = $sub_questions;    
            }
        }
        Excel::create(str_slug($lesson->name), function ($excel) use ($questions) {
                $excel->sheet('sheet', function ($sheet) use ($questions) {
                    // $sheet->setColumnFormat(array(
                    //     'A' => '@',
                    //     'B' => '@',
                    //     'C' => '@',
                    //     'D' => '@',
                    // ));
                    $var['questions'] = $questions;
                    $sheet->loadView('backend.export.question', $var);
                });
        })->download('xlsx');
        //dd($questions);
        alert()->success('Thông báo','Xuất dữ liệu thành công');
        return redirect()->route('lesson.detail',['id'=>$id]);
    }
}
