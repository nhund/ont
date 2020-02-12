<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\UserStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\Feedback;
use App\Models\Question;
use App\Models\QuestionCardMuti;

class FeedbackController extends AdminBaseController
{
    public function index(Request $request){

        $limit = 20;
        $data = $request->all();
        $feedback = Feedback::select('*')->with(['bookmark' => function ($q){
            $q->where('user_id',Auth::user()->id);
        }]);
        if(isset($data['create_date']) && !empty($data['create_date']))
        {
            $time = explode('-',$data['create_date']);
            $feedback = $feedback->where('create_date','>',strtotime($time[0].'00:00:01'))
            ->where('create_date','<',strtotime($time[1].'23:59:59'));
        }
        if(Auth::user()->level != User::USER_ADMIN)
        {
            $feedback = $feedback->where('teacher_id',Auth::user()->id);
        }
        $feedback = $feedback->orderBy('id','DESC')->paginate($limit);
        $var['feedbacks'] = $feedback;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.feedback.index'),
                'title' => 'Danh sách phản hồi',
            ),
        );
        //session
        $request->session()->put('REQUEST_URI', $request->server('REQUEST_URI'));
        //d($var);
        return view('backend.feedback.index',compact('var','data'));
    }
    
    public function editQuestion(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']) || !isset($data['feedback_id']))
        {
            alert()->error("Nội dung không tồn tại");
            return redirect()->route('admin.feedback.index');
        }
        $feedback = Feedback::find($data['feedback_id']);
        if($feedback && $feedback->question_type == Question::TYPE_FLASH_MUTI)
        {
            $question_muti = QuestionCardMuti::find($data['id']);
            if($question_muti)
            {
                return redirect()->route('admin.question.edit',['id'=>$question_muti->question_id,'feedback_id'=>$data['feedback_id'],'feedback_question'=>$data['id']]);    
            }
        }

        $question = Question::find($data['id']);
        if(!$question)
        {
            alert()->error("Nội dung không tồn tại");
            return redirect()->route('admin.feedback.index');
        }
        if($question->type == Question::TYPE_FLASH_SINGLE)
        {
            return redirect()->route('admin.question.edit',['id'=>$data['id'],'feedback_id'=>$data['feedback_id']]);
        }
        if($question->parent_id > 0)
            {
                return redirect()->route('admin.question.edit',['id'=>$question->parent_id,'feedback_id'=>$data['feedback_id'],'feedback_question'=>$data['id']]);       
            }
            return redirect()->route('admin.question.edit',['id'=>$data['id'],'feedback_id'=>$data['feedback_id']]);
        // if($question->type == Question::TYPE_DIEN_TU || Question::TYPE_TRAC_NGHIEM || Question::TYPE_DIEN_TU_DOAN_VAN){
            
        // }
        
    }
}
