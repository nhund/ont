<?php

namespace App\Components\User;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\UserLessonLog;
use App\Models\UserQuestionLog;
use App\User;

/**
 * Class UserCourseReportService
 * @package App\Components\User
 */
class UserCourseReportService
{
    /**
     * @var Course
     */
    protected $course;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var array
     */
    protected $report = [];

    /**
     * UserCourseReportService constructor.
     * @param Course $course
     * @param User $user
     */
    public function __construct(Course $course, User $user)
    {
        $this->course = $course;
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function get()
    {
        $lessons = $this->lessons();

        foreach ($lessons as $lesson)
        {
            $data['lesson_name'] = $lesson->name;
            $data['lesson_id'] = $lesson->id;

            if ($lesson->level == Lesson::LEVEL_1)
            {
                $data['level'] =  Lesson::LEVEL_1;
                $data['report'] = $this->subLessons($lesson);
            }

            if ($lesson->level == Lesson::LEVEL_2)
            {
                $data['level'] =  Lesson::LEVEL_2;
                $data['report'] = $this->level2($lesson);
            }

            array_push($this->report, $data);
        }

        return $this->report;
    }

    /**
     * @return mixed
     */
    private function lessons()
    {
        return Lesson::where('parent_id', Lesson::PARENT_ID)
            ->where('course_id', $this->course->id)
            ->orderBy('order_s','ASC')
            ->orderBy('created_at','ASC')
            ->get();
    }

    /**
     * @param Lesson $lesson
     * @return array
     */
    public function level2(Lesson $lesson)
    {
        $subLessons = $lesson->subLesson;
        $chapter    = [];

        if ($subLessons)
        {
            foreach ($subLessons as $subLesson)
            {
                array_push($chapter, ['id' => $subLesson->id, 'name' => $subLesson->name]);
            }
        }

        return $chapter;
    }

    /**
     * @param Lesson $lesson
     * @return array
     */
    public function level1(Lesson $lesson)
    {
        $subLessons = $lesson->subLesson;
        $report     = [];

        if ($subLessons)
        {
            foreach ($subLessons as $subLesson)
            {
                $subReport['name'] = $subLesson->name;
                $subReport['type'] = $this->getType($subLesson);
                $subReport['sub_lesson_id'] = $subLesson->id;

                if ($subLesson->is_exercise == Lesson::IS_EXERCISE)
                {
                    $subReport['total'] = $this->countTotalQuestion($subLesson->id);
                    $subReport['done']  = $this->countCorrectQuestion($subLesson->id);
                }

                if ($subLesson->is_exercise == Lesson::IS_DOC)
                {
                    $subReport['done'] = $this->checkPassTheory($subLesson->id);
                }
                array_push($report, $subReport);
            }
        }

        return $report;

    }

    /**
     * @param Lesson $lesson
     * @return array
     */
    public function subLessons(Lesson $lesson)
    {
        if ($lesson->level == Lesson::LEVEL_1)
        {
            return $this->level1($lesson);
        }

        if ($lesson->level == Lesson::LEVEL_2)
        {
            return [];
        }
    }

    /**
     * @param $lessonID
     * @return mixed
     */
    private function countCorrectQuestion($lessonID)
    {
        return UserQuestionLog::where('user_id',$this->user->id)
            ->where('lesson_id',$lessonID)
            ->where('status',QuestionAnswer::REPLY_OK)
            ->count();
    }

    /**
     * @param $lessonID
     * @return mixed
     */
    private function countTotalQuestion($lessonID){
        return Question::where('lesson_id',$lessonID)->where('parent_id', Lesson::PARENT_ID)->count();
    }

    /**
     * @param $lessonID
     * @return mixed
     */
    private function checkPassTheory($lessonID){
        return UserLessonLog::where('user_id',$this->user->id)->where('lesson_id',$lessonID)->exists();
    }

    /**
     * @param Lesson $lesson
     * @return null|string
     */
    private function getType(Lesson $lesson){

        if ($lesson->is_exercise() && $lesson->type == Lesson::LESSON){
            return 'exercise';
        }
        if ($lesson->is_exercise() && $lesson->type == Lesson::EXAM){
            return Lesson::EXAM;
        }
        if (!$lesson->is_exercise()){
            return 'theory';
        }
        return null;
    }

    /**
     * @param Lesson $lesson
     */
    private function exam(Lesson $lesson){

    }
}