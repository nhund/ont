<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\UserCourse;
use App\Models\Course;
use App\Models\CommentCourse;
use App\Helpers\Helper;

class CommentController extends Controller
{        
    public function addComment(Request $request)
    {
        $data = $request->all();
        if(!isset($data['course_id']) || !isset($data['parent_id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra'));
        }
        if(empty($data['content']))
        {
            return response()->json(array('error' => true, 'msg' => 'Nội dung không được để trống'));
        }
        if(!Auth::check())
        {
            return response()->json(array('error' => true,'type'=>'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        $comment = new CommentCourse();
        $comment->user_id = $user->id;
        $comment->course_id = $data['course_id'];
        $comment->parent_id = $data['parent_id'];
        $comment->content = $data['content'];
        $comment->status = CommentCourse::STATUS_ON;
        $comment->created_at = time();
        if($comment->save())
        {
            if($data['parent_id'] == 0)
            {
                return response()->json([
                    'error'=>false,
                    'template'    => view('course.detail.comment.comment',compact(['comment']))->render(),
                    'message'   => 'Gủi bình luận thành công',
                    'data'      =>  []
                ]);   
            }else{
                $comment_child = $comment;
                return response()->json([
                    'error'=>false,
                    'template'    => view('course.detail.comment.comment_child',compact(['comment_child']))->render(),
                    'message'   => 'Gủi bình luận thành công',
                    'data'      =>  []
                ]);   
            }
                     
        }else{

            return response()->json(array('error' => true, 'msg' => 'Bình luận không thành công'));
        }      
    }   
    
    public function deleteComment(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra'));
        }
        if(!Auth::check())
        {
            return response()->json(array('error' => true,'type'=>'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        $comment = CommentCourse::find($data['id']);
        if(!$comment)
        {
            return response()->json(array('error' => true, 'msg' => 'Xóa dữ liệu không thành công'));
        }        
        if($comment->user_id != $user->id)
        {            
            if($user->level != User::USER_ADMIN)
            {
                return response()->json(array('error' => true, 'msg' => 'Bạn không thể xóa bình luận'));
            }
        }
        if($comment->delete())
        {
            return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
        }
        return response()->json(array('error' => true, 'msg' => 'Xóa dữ liệu không thành công'));
    }
}
