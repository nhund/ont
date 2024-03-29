<?php

namespace App\Transformers\Comment;

use App\Models\CommentCourse;
use App\Transformers\User\UserFull;
use League\Fractal\TransformerAbstract;

class CommentCourseTransformer extends TransformerAbstract
{

    protected $defaultIncludes   = ['user'];
    protected $availableIncludes = ['subComment'];


    protected $comment;

    public function transform(CommentCourse $comment)
    {

        $this->comment = $comment;

        return [
            'id'         => $comment->id,
            'course_id'  => $comment->course_id,
            'parent_id'  => $comment->parent_id,
            'content'    => $comment->content,
            'status'     => $comment->status,
            'user_id'    => $comment->user_id,
            'created_at' => $comment->created_at
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