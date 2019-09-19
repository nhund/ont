<?php

namespace App\Components\Course;

use App\Exceptions\UserCourseException;
use App\Helpers\Helper;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\Wallet;
use App\Models\WalletLog;
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

        $UserCourse = UserCourse::where([
            'user_id' => $this->userId,
            'course_id' => $this->course->id,
        ])->first();

        if ($UserCourse && ($UserCourse->and_date > 0 && $UserCourse->and_date > time())){
            throw new UserCourseException('Bạn đang học khóa học này.');
        }

        if($course->status == Course::TYPE_PUBLIC)
        {
            try{
                DB::transaction(function () use ($course, $UserCourse){
                    $this->paymentCourse($course);
                    $this->createOrUpdateUserCourse(UserCourse::STATUS_ON, $UserCourse);
                    return 'mua hóa học thành công';
                });
                dd($course->status,555);
            }catch (UserCourseException $courseException){
                throw new UserCourseException('Mua khóa học không thàn ddh công.');
            }
        }

        if($course->status == Course::TYPE_APPROVAL)
        {
            $this->createOrUpdateUserCourse(UserCourse::STATUS_APPROVAL, $UserCourse);
            return 'Xin tham gia thành công, bạn cần chờ duyệt để tham gia';
        }

        return  'Mua khóa học không thành công';
    }

    public function createOrUpdateUserCourse($status_course, $userCourse = null)
    {
        if (empty($userCourse)){
            $userCourse = new UserCourse();
            $userCourse->created_at = time();
            $userCourse->user_id = $this->userId;
            $userCourse->course_id = $this->course->id;
        }
        $this->course->status = $status_course;
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
        Helper::walletLog($dataLog, $this->userId);
    }
}