<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 20/09/2019
 * Time: 17:17
 */

namespace App\Components\BookMark;


use App\Exceptions\BookMarkException;
use App\Exceptions\OnthiezException;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\UserQuestionBookmark;
use Illuminate\Http\Request;

class BookMarkService
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws OnthiezException
     */
    public function bookMarkQuestion()
    {
        $user = $this->request->user();

        $question = Question::where([
            'id' => $this->request->get('question_id'),
            'status' => Question::STATUS_ON
        ])->first();

        if (!$question)
        {
            throw new BookMarkException('Câu hỏi không tồn tại hoặc đã bị xoắ');
        }

        $lesson = Lesson::where([
            'id' => $question->lesson_id,
            'status' => Question::STATUS_ON
        ])->first();

        if (!$lesson)
        {
            throw new BookMarkException('Câu hỏi không hợp lệ');
        }

        $bookmark = UserQuestionBookmark::where('user_id',$user->id)
                ->where('question_id', $question->id)
                ->first();

        if($bookmark)
        {
            return $bookmark->delete();
        }else
        {
            return (new UserQuestionBookmark())->forceFill([
                'user_id' => $user->id,
                'question_id' => $question->id,
                'course_id' => $lesson->course_id,
                'lesson_id' => $question->lesson_id,
                'create_at' =>  time(),
             ])->save();
        }
    }
}