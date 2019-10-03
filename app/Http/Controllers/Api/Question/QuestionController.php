<?php

namespace App\Http\Controllers\Api\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookmarkQuestionRequest;
use App\Models\Question;
use App\Models\UserQuestionBookmark;
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
}