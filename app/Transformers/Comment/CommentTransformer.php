<?php

namespace App\Transformers\Comment;

use App\Models\CommentCourse;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract {
    
    public function transform(CommentCourse $comment){

        return [
            'id' => $comment->id,
            'course_id' => $comment->course_id,
            'content' => $comment->content,
            'status' => $comment->status,
            'user_id' => $comment->user_id,
            'created_at' => $comment->created_at
        ];
    }
}