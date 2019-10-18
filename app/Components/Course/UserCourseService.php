<?php

namespace App\Components\Course;

use App\Exceptions\UserCourseException;
use App\Helpers\Helper;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\Wallet;
use App\Models\WalletLog;
use App\User;
use Illuminate\Support\Facades\DB;

class UserCourseService
{
    protected $userId;
    protected $course;

    public function __construct(Course $course, $userId)
    {
        $this->course= $course;
        $this->userId = $userId;
    }

    /**
     * @return string
     * @throws UserCourseException
     * @throws \Throwable
     */
    public function addingORExtentCourse(){
        $course = Course::find($this->course->id);

        $userCourse = UserCourse::where([
            'user_id' => $this->userId,
            'course_id' => $this->course->id,
        ])->first();

        if ($userCourse && ($userCourse->and_date > 0 && $userCourse->and_date > time())){
            throw new UserCourseException('Bạn đang học khóa học này.');
        }

        if($course->status == Course::TYPE_PUBLIC)
        {
            DB::transaction(function () use ($course, $userCourse){
                $this->paymentCourse($course);
                $this->createOrUpdateUserCourse(UserCourse::STATUS_ON, $userCourse);
            });
            return 'mua khóa học thành công';
        }

        if($course->status == Course::TYPE_APPROVAL)
        {
            $this->createOrUpdateUserCourse(UserCourse::STATUS_APPROVAL, $userCourse);
            return 'Xin tham gia thành công, bạn cần chờ duyệt để tham gia';
        }

        $end_date = (int)$course->study_time > 0 ? time() + (int)$course->study_time * 24 * 60 * 60 : 0;
        $status_course = UserCourse::STATUS_ON;

        if($userCourse)
        {
            $userCourse->status = $status_course;
            $userCourse->and_date = $end_date;
            $userCourse->learn_day = $course->study_time;
            $userCourse->updated_at = time();
        }else{
            $userCourse = new UserCourse();
            $userCourse->user_id = $this->userId;
            $userCourse->course_id = $this->course->id;
            $userCourse->status = $status_course;
            $userCourse->and_date = $end_date;
            $userCourse->learn_day = $course->study_time;
            $userCourse->created_at = time();
        }

        return  $userCourse->save() ? 'mua khóa học thành công' : 'Mua khóa học không thành công';
    }

    public function createOrUpdateUserCourse($status_course, $userCourse = null)
    {
        if (empty($userCourse)){
            $userCourse = new UserCourse();
            $userCourse->created_at = time();
            $userCourse->user_id = $this->userId;
            $userCourse->course_id = $this->course->id;
        }
        $userCourse->status   = $status_course;
        $userCourse->and_date = $this->endDate();
        $userCourse->learn_day = $this->course->study_time;
        $userCourse->updated_at = time();
        return $userCourse->save();
    }

    public function updateUserCourse($userCourse, $status_course)
    {

    }

    public function endDate()
    {
        return (int)$this->course->study_time > 0 ? time() + (int)$this->course->study_time * 24 * 60 * 60 : 0;
    }

    /**
     * @param Course $course
     * @return \Illuminate\Http\JsonResponse
     * @throws UserCourseException
     */
    public function paymentCourse(Course $course)
    {
        //check wallet
        $wallet = Wallet::where('user_id',$this->userId)->first();
        if(!$wallet) {
            throw new UserCourseException('Bạn chưa có xu để mua khóa học.');
        }

        $course_price = $course->price - $course->discount;
        $wallet_current = $wallet->xu;
        if($wallet_current < $course_price)
        {
            throw new UserCourseException('Bạn không đủ xu để mua khóa học.');
        }
        //tru wallet
        $wallet->xu = (int)$wallet_current - (int)$course_price;
        $wallet->save();
        //ghi log
        $dataLog = array(
            'type' => WalletLog::TYPE_MUA_KHOA_HOC,
            'xu_current' => $wallet_current,
            'xu_change' => -$course_price,
            'note' => 'Mua khóa học ' . $course->name,
        );

        $user = User::find($this->userId);

        Helper::walletLog($dataLog, $user);
    }
}