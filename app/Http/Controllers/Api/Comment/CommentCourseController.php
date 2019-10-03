<?php

namespace App\Http\Controllers\Api\Comment;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCommentToQuestionRequest;
use App\Models\CommentCourse;
use App\Models\Course;
use App\Transformers\Comment\CommentCourseTransformer;

class CommentCourseController extends Controller
{

    public function index(){}

    public function show(){}

    /**
     * @param Course $course
     * @param AddCommentToQuestionRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BadRequestException
     */
    public function store(Course $course, AddCommentToQuestionRequest $request)
    {
        $data = $request->only(['parent_id', 'content']);
        try {
        $comment = CommentCourse::updateOrCreate([
             'user_id'   => $request->user()->id,
             'course_id' => $course->id], [
             'parent_id'  => $data['parent_id'] ?? 0,
             'status'     => CommentCourse::STATUS_ON,
             'content'    => $data['content'],
             'created_at' => time()
         ]);

        return fractal()->item($comment, new CommentCourseTransformer)->respond();

        } catch (\Exception $exception) {
            throw new BadRequestException('Thêm bình luận cho khóa học không thành công');

        }

    }

    public function update()
    {
    }

    public function delete()
    {
    }

}