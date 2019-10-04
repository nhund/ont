<?php

namespace App\Http\Controllers\Api\Comment;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentToQuestionRequest;
use App\Models\CommentCourse;
use App\Models\CommentQuestion;
use App\Models\Question;
use App\Transformers\Comment\CommentQuestionTransformer;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class CommentQuestionController extends Controller
{

    public function index(Question $question, Request $request){

        $comments = $question->comment()->where('parent_id', 0)->paginate(10);

        return fractal()->collection($comments, new CommentQuestionTransformer)
                ->paginateWith(new IlluminatePaginatorAdapter($comments))
                ->respond();
    }

    public function show(){}

    /**
     * @param Question $question
     * @param AddCommentToQuestionRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestException
     */
    public function store(Question $question, AddCommentToQuestionRequest $request)
    {
        $data = $request->only(['parent_id', 'content', 'course_id']);

        try {
            $comment = CommentQuestion::create( [
                'question_id' => $question->id,
               'parent_id'  => $data['parent_id'] ?? 0,
               'user_id'     => $request->user()->id,
               'status'     => CommentCourse::STATUS_ON,
               'course_id'  => $question->course_id,
               'lesson_id'  => $question->lesson_id,
               'content'    => $data['content'],
               'updated_at' => time()
           ]);

            return fractal()->item($comment, new CommentQuestionTransformer)->respond();

        }catch (\Exception $exception){
            throw new BadRequestException('Thêm bình luận cho câu hỏi không thành công');
        }
    }

    public function update()
    {
    }

    public function delete()
    {
    }

}