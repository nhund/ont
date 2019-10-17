<?php

namespace App\Http\Controllers\Api\Question;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookmarkQuestionRequest;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionCardMuti;
use App\Models\UserQuestionBookmark;
use Illuminate\Http\Request;
use Intervention\Image\Exception\NotFoundException;

class QuestionController extends Controller{

    public function index(){}
        
    public function show(){}
    public function store(){}
    public function update(){}
    public function delete(){}

    public function bookMark(Question $question, BookmarkQuestionRequest $request)
    {
        $user = $request->user();

        $bookmark = UserQuestionBookmark::where('user_id',$user->id)
            ->where('question_id',$question->id)->first();

        if($request->get('type') == UserQuestionBookmark::TYPE_DELETE)
        {
            if($bookmark){
                $bookmark->delete();
                return $this->message('Xóa câu hỏi hỏi bookmark thành công')->respondOk(['question_id' => $question->id]);
            }
            throw new NotFoundException('Câu hỏi này chưa từng được bookmark.');
        }

        UserQuestionBookmark::updateOrCreate([
             'user_id' => $user->id,
             'question_id' => $question->id,
             'lesson_id' => $question->lesson_id],[
            'course_id' => $question->course_id,
            'create_at' => time()]);

        return $this->message('Bookmark câu hỏi thành công')->respondOk(['question_id' => $question->id]);
    }

    public function feedback($questionId ,FeedbackRequest $request)
    {
        $data = $request->all();

        if(isset($data['type']) && $data['type'] == Question::TYPE_FLASH_MUTI)
        {
            $question = QuestionCardMuti::find($questionId);
        }else{
            $question = Question::find($questionId);
        }

        if(!$question)
        {
            throw new BadRequestException('Câu hỏi không tồn tại hoặc đã bị xóa.');
        }

        $lesson = Lesson::find($question->lesson_id);
        $feedback = new Feedback();
        $feedback->user_id = $request->user()->id;
        $feedback->title = $data['title'];
        $feedback->name = '';
        $feedback->email = $data['email'];
        $feedback->content = $data['content'];
        $feedback->course_id = $lesson->course_id;
        $feedback->teacher_id = $question->user_id;
        $feedback->question_id = $questionId;
        $feedback->question_type = isset($data['type']) ? $data['type'] : 0;
        $feedback->status = Feedback::STATUS_NOT_EDIT;
        $feedback->create_date = time();
        $feedback->save();

        return $this->message('Phản hỏi câu hỏi thành công')->respondOk();
    }
}