<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\CommentCourse;
use Auth;
use App\Models\Rating;
use App\Models\Lesson;
use App\Models\UserCourse;
use App\Models\Question;
use App\Models\UserQuestionLog;
use App\Models\QuestionAnswer;
use App\Models\QuestionCardMuti;
use App\Models\UserQuestionBookmark;

class BookmarkController extends Controller
{        
    
    public function bookMark(Request $request)
    {
        $data = $request->all();
        if(!Auth::check())
        {
            return response()->json(array('error' => true, 'action'=>'login','msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        $type = UserQuestionBookmark::TYPE_ADD;
        if(isset($data['type']) && $data['type'] == UserQuestionBookmark::TYPE_DELETE)
        {
            $type = UserQuestionBookmark::TYPE_DELETE;
        }
        if(!isset($data['question_id']))
        {
            return response()->json(array('error' => true,'msg' => 'Có lỗi xẩy ra'));
        }
        $question = Question::find($data['question_id']);
        if(!$question)
        {
            return response()->json(array('error' => true,'msg' => 'Có lỗi xẩy ra, câu hỏi không tồn tại hoặc đã bị xóa'));
        }
        $lesson = Lesson::find($question->lesson_id);
        if(!$lesson)
        {
            return response()->json(array('error' => true,'msg' => 'Có lỗi xẩy ra, bài học không tồn tại hoặc đã bị xóa'));
        }
        $bookmark = UserQuestionBookmark::where('user_id',$user->id)->where('question_id',$data['question_id'])->first();
        if($bookmark)
        {
            $bookmark->delete();
            return response()->json(array('error' => false,'type'=>'delete','msg' => 'Xóa câu hỏi khỏi bookmark thành công'));
        }else{

            $bookmark = new UserQuestionBookmark();
            $bookmark->user_id = $user->id;
            $bookmark->question_id = $data['question_id'];            
            $bookmark->course_id = $lesson->course_id;
            $bookmark->lesson_id = $question->lesson_id;
            $bookmark->create_at = time();
            $bookmark->save();
            return response()->json(array('error' => false,'type'=>'add','msg' => 'Thêm bookmark thành công'));
        }
    }
    public function questionSubmit(Request $request)
    {
        $data = $request->all();
        $question = Question::find($data['id']);
        $lesson =    Lesson::find($question->lesson_id);
        if(!$question)
        {
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra'));
            //return redirect()->route('home');
        }
        if(!Auth::check())
        {
            return response()->json(array('error' => true, 'action'=>'login','msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        if($question->type == Question::TYPE_FLASH_SINGLE)
        {            
            $questionLog = new UserQuestionLog();
            $questionLog->user_id = $user->id;
            $questionLog->course_id = $lesson->course_id;
            $questionLog->lesson_id = $question->lesson_id;
            $questionLog->question_id = $data['id'];
            $questionLog->note = '';
            $questionLog->status = $data['reply'] == Question::REPLY_OK ? $data['reply'] : Question::REPLY_ERROR;
            $questionLog->create_at = time();
            $questionLog->save();
        }
        if($question->type == Question::TYPE_DIEN_TU)
        {
            if(isset($data['answers']) && count($data['answers']) > 0)
            {
                $result = [];
                //dd($data['answers']);
                foreach($data['answers'] as $key => $answer)
                {
                    $an = QuestionAnswer::where('question_id',$key)->first();
                    $reply = Question::REPLY_ERROR;
                    if(strtolower($an->answer) == strtolower($answer))
                    {
                        $reply = Question::REPLY_OK;
                    }
                    $questionLog = new UserQuestionLog();
                    $questionLog->user_id = $user->id;
                    $questionLog->course_id = $lesson->course_id;
                    $questionLog->lesson_id = $question->lesson_id;
                    $questionLog->question_id = $key;
                    $questionLog->note = '';
                    $questionLog->status = $reply;
                    $questionLog->create_at = time();
                    $questionLog->save();

                    $result[$key] = array(
                        'error'=>$reply,
                        'input'=>!empty($answer) ? $answer: '',
                        'answer'=>$an->answer,
                    );
                }
                return response()->json(array(
                    'error' => false, 
                    'msg' => 'succsess',
                    'data'=> $result,
                ));
            }
        }
        if($question->type == Question::TYPE_TRAC_NGHIEM)
        {
            if(isset($data['answers']) && count($data['answers']) > 0)
            {
                $result = [];
                foreach ($data['answers'] as $key => $answer) {

                    $reply = QuestionAnswer::REPLY_ERROR;
                    //lay dap an dung
                    $answerCheck = QuestionAnswer::where('question_id',$key)->where('status',QuestionAnswer::REPLY_OK)->first();
                    if($answerCheck && (int)$answer == (int)$answerCheck->id)
                    {
                        $reply = QuestionAnswer::REPLY_OK;
                    }
                    $questionLog = new UserQuestionLog();
                    $questionLog->user_id = $user->id;
                    $questionLog->course_id = $lesson->course_id;
                    $questionLog->lesson_id = $question->lesson_id;
                    $questionLog->question_id = $key;
                    $questionLog->note = '';
                    $questionLog->status = $reply;
                    $questionLog->create_at = time();
                    $questionLog->save();

                    $result[$key] = array(
                        'error'=>$reply,
                        'input'=>!empty($answer) ? (int)$answer: '',
                        'answer'=>$answerCheck->id,
                    );
                }
                return response()->json(array(
                    'error' => false, 
                    'msg' => 'succsess',
                    'data'=> $result,
                ));
            }
            return response()->json(array(
                'error' => true, 
                'msg' => 'bạn chưa chọn đáp án cho câu hỏi',
                'data'=> '',
            ));
            
           // dd($data);
        }
        return response()->json(array('error' => false, 'msg' => 'succsess'));

    }
}
