<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 11/03/2020
 * Time: 11:09
 */

namespace App\Http\Controllers\BackEnd;

use App\Models\ExamUser;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\UserCourse;
use App\Models\UserLessonLog;
use App\Models\UserQuestionLog;
use App\User;
use Illuminate\Http\Request;

class UserLessonController extends AdminBaseController
{
    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailReport(Lesson $lesson, Request $request){
        $var = [];
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.userLesson.report.detail', ['lesson' => $lesson->id]),
                'title' => 'Xem tiến độ',
            ),
        );

        $userCourses = UserCourse::query()->with('user')
                ->where('course_id', $lesson->course_id)
        ;

        if ($request->has('key_search')){
            $keySearch = trim($request->get('key_search'));
            $userCourses->whereHas('user' , function($q) use ($keySearch){
                $q->where('name', 'LIKE', "%{$keySearch}%");
                $q->orWhere('email', 'LIKE', "%{$keySearch}%");
                $q->orWhere('full_name', 'LIKE', "%{$keySearch}%");
                $q->orWhere('phone', 'LIKE', "%{$keySearch}%");
            });
        }
        $var['totalUser'] = $userCourses->get()->count();;

        $userCourses = $userCourses->orderBy('id', 'DESC')
                            ->paginate(20);

        foreach ($userCourses as $userCourse){
            $userLesson = UserLessonLog::where([
                'course_id' => $userCourse->course_id,
                'user_id'   => $userCourse->user_id,
                'lesson_id' => $lesson->id
            ])->first();

            $userCourse->lesson = $userLesson;
            $userQuestion = UserQuestionLog::query()->where([
                 'course_id' => $userCourse->course_id,
                 'user_id'   => $userCourse->user_id,
                 'lesson_id' => $lesson->id
             ]);

            $userCourse->didQuestion = $userQuestion->count();
            $userCourse->correctQuestion = $userQuestion->where('status', Question::REPLY_OK)->count();

        }

        $var['users'] = $userCourses;

        if ($lesson->is_exercise()){
            return view('backend.userLesson.index', ['var' => $var]);
        }else {
            return view('backend.userLesson.theory', ['var' => $var]);
        }
    }

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailReportExam(Lesson $lesson, Request $request)
    {
        $var = [];
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.userLesson.report.detail', ['lesson' => $lesson->id]),
                'title' => 'Xem tiến độ',
            ),
        );

        $examUsers = ExamUser::query()->where('lesson_id', $lesson->id)->with(['user', 'exam']);
        $totalUser = $examUsers->get()->count();

        if ($request->has('key_search')){
            $keySearch = trim($request->get('key_search'));
            $examUsers->whereHas('user' , function($q) use ($keySearch){
                $q->where('name', 'LIKE', "%{$keySearch}%");
                $q->orWhere('email', 'LIKE', "%{$keySearch}%");
                $q->orWhere('full_name', 'LIKE', "%{$keySearch}%");
                $q->orWhere('phone', 'LIKE', "%{$keySearch}%");
            });
        }
        $examUsers = $examUsers->paginate(15);

        $var['totalUser'] = $totalUser;
        $var['examUsers'] = $examUsers;

        return view('backend.userLesson.exam', ['var' => $var]);
    }
}