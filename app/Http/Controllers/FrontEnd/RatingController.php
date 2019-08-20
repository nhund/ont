<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Auth;
use App\Models\Slide;
use App\Models\Course;
use App\Models\About;
use App\Models\Rating;
use App\Models\CourseRating;

class RatingController extends Controller
{    
    public function add(Request $request)
    {
        $data = $request->all();
         
        if(!isset($data['course_id']) || !isset($data['rating_value']))
        {
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra'));
        }      
        if(!Auth::check())
        {
            return response()->json(array('error' => true,'type'=>'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $course = Course::find($data['course_id']);
        if(!$course)
        {
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra, nội dung không tồn tại'));
        }
        $user = Auth::user();
        $userRating = Rating::where('user_id',$user->id)->where('course_id',$data['course_id'])->first();
        $rating_old = 0;
        if($userRating)
        {
            if($userRating->rating_value == $data['rating_value'])
            {
                return response()->json(array('error' => false,'msg' => 'Gửi đánh giá thành công'));
            }
            $rating_old = $userRating->rating_value;

            $userRating->rating_value = $data['rating_value'];
        }else{
            $userRating = new Rating();
            $userRating->user_id = $user->id;
            $userRating->course_id = $data['course_id'];
            $userRating->rating_value = $data['rating_value'];
            $userRating->create_at = time();
        }
        if($userRating->save())
        {
            if((int)$data['rating_value'] > 0 && (int)$data['rating_value'] < 6)
            {                
                if((int)$data['rating_value'] == 1)
                {
                    $course->rating_1 += 1;
                }
                if((int)$data['rating_value'] == 2)
                {
                    $course->rating_2 += 1;
                }
                if((int)$data['rating_value'] == 3)
                {
                    $course->rating_3 += 1;
                }
                if((int)$data['rating_value'] == 4)
                {
                    $course->rating_4 += 1;
                }
                if((int)$data['rating_value'] == 5)
                {
                    $course->rating_5 += 1;
                }
                
                $course->save();
            }
            if((int)$rating_old > 0 && (int)$rating_old < 6)
            {
                if((int)$rating_old == 1 && $course->rating_1 > 0)
                {
                    $course->rating_1 -= 1;
                }
                if((int)$rating_old == 2 && $course->rating_2 > 0)
                {
                    $course->rating_2 -= 1;
                }
                if((int)$rating_old == 3 && $course->rating_3 > 0)
                {
                    $course->rating_3 -= 1;
                }
                if((int)$rating_old == 4 && $course->rating_4 > 0)
                {
                    $course->rating_4 -= 1;
                }
                if((int)$rating_old == 5 && $course->rating_5 > 0)
                {
                    $course->rating_5 -= 1;
                }
                $course->save();
                
            }
            return response()->json(array('error' => false,'msg' => 'Gửi đánh giá thành công'));
        }else{
            return response()->json(array('error' => true,'msg' => 'Gửi đánh giá không thành công'));
        }
    }
    
}
