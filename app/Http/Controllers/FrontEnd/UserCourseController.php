<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\UserCourse;
use App\Models\Course;
use App\Models\Wallet;
use App\Models\WalletLog;
use App\Helpers\Helper;

class UserCourseController extends Controller
{        
    public function add(Request $request)
    {
        $data = $request->all();
        if(!isset($data['course_id']) || $data['course_id'] === '')
        {
            //alert()->error('Có lỗi xẩy ra');
            
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra'));
        }
        if(!Auth::check())
        {
            //alert()->error('Bạn cần đăng nhập để thực hiện hành động này');
            return response()->json(array('error' => true, 'action'=>'login','msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $course = Course::find($data['course_id']);
        if(!$course)
        {
            //alert()->error('Khóa học không tồn tại');
            return response()->json(array('error' => true, 'msg' => 'Khóa học không tồn tại'));
        }
        $user = Auth::user();
        $checkExist = UserCourse::where('user_id',$user->id)->where('course_id',$data['course_id'])->first();
        if($checkExist)
        {
            if($checkExist->and_date > 0 && $checkExist->and_date > time())
            {
                return response()->json(array('error' => true, 'msg' => 'Bạn đang học khóa học này'));
            }            
        }
        // neu khoa hoc free thi ko check wallet
        
        if($course->status == Course::TYPE_PUBLIC)
        {
            //check wallet
            $wallet = Wallet::where('user_id',$user->id)->first();
            if(!$wallet)
            {
                //alert()->error('Có lỗi xẩy ra');
                return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra'));
            }
            $course_price = $course->price - $course->discount;

			$course_price = $course_price < 0 ? 0 : $course_price;

            $wallet_current = $wallet->xu;
            if($wallet_current < $course_price)
            {
                //alert()->error('Bạn không đủ tài khoản để mua');
                return response()->json(array('error' => true, 'msg' => 'Tài khoản của bạn không đủ tiền'));
            }           
            //tru wallet
            $wallet->xu = (int)$wallet_current - (int)$course_price;
            $wallet->save();
            //ghi log
            $dataLog = array(
                'type'=> WalletLog::TYPE_MUA_KHOA_HOC,
                'xu_current'=> $wallet_current,
                'xu_change' => - $course_price,
                'note' => 'Mua khóa học '.$course->name,
            );
            Helper::walletLog($dataLog, $user);             
        }      
        $status_course = UserCourse::STATUS_ON;     
        $msg_success = 'Mua khóa học thành công'; 
        if($course->status == Course::TYPE_APPROVAL)
        {
            $status_course = UserCourse::STATUS_APPROVAL;
            $msg_success = 'Xin tham gia thành công, bạn cần chờ duyệt để tham gia';
        }
        $end_date = (int)$course->study_time > 0 ? time() + (int)$course->study_time * 24 * 60 * 60 : 0;
        if($checkExist)
        {
            $userCourse = $checkExist;
            $userCourse->status = $status_course;
            $userCourse->and_date = $end_date;
            $userCourse->learn_day = $course->study_time;
            $userCourse->updated_at = time();
        }else{
            $userCourse = new UserCourse();
            $userCourse->user_id = $user->id;
            $userCourse->course_id = $data['course_id'];
            $userCourse->status = $status_course;
            $userCourse->and_date = $end_date;
            $userCourse->learn_day = $course->study_time;
            $userCourse->created_at = time();
            
        }
        if($userCourse->save())
        {
            return response()->json(array(
                'error' => false, 
                'msg' => $msg_success,
                'url' => route('myCourse')
            ));
        }else{
            return response()->json(array('error' => true, 'msg' => 'Mua khóa học không thành công'));
        }
                
    }    
}
