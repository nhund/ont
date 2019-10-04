<?php

namespace App\Transformers\Comment;

use App\Models\CommentQuestion;
use App\Transformers\User\UserFull;
use League\Fractal\TransformerAbstract;

class CommentQuestionTransformer extends TransformerAbstract
{

    protected $defaultIncludes = ['user'];
    protected $availableIncludes = ['subComment'];

    protected $comment;

    public function transform(CommentQuestion $comment)
    {

        $this->comment = $comment;

        return [
            'id'          => $comment->id,
            'question_id' => $comment->question_id,
            'course_id'   => $comment->course_id,
            'lesson_id'   => $comment->lesson_id,
            'parent_id'   => $comment->parent_id,
            'content'     => $comment->content,
            'status'      => $comment->status,
            'user_id'     => $comment->user_id,
            'created_at'  => $comment->created_at
        ];
    }

    /**
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser()
    {
        $user = $this->comment->user;

        return $user ? $this->item($user, new UserFull) : null;
    }

    public function includeSubComment()
    {
        $subComments = $this->comment->subComment;

        return $subComments ? $this->collection($subComments, new self) : null;
    }
}