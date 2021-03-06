<?php

namespace App\Components\User;

use App\Components\Lesson\LessonService;
use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamPart;
use App\Models\ExamUser;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\UserLessonLog;
use App\Models\UserQuestionBookmark;
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
    public function __construct(User $user, Course $course = null)
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
			$data = [];
            $data['lesson_name'] = $lesson->name;
            $data['lesson_id'] = $lesson->id;
            $type  = $this->getType($lesson);
			$data['type'] = $type;

            if($type == Lesson::LESSON || $type == 'theory'){
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
			}

			if($type == Lesson::EXAM){
				$data['level'] =  Lesson::LEVEL_1;
				$data = array_merge($data, $this->exam($lesson));
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
            ->where('level',  '!=', 0)
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
                array_push($chapter, ['id' => $subLesson->id, 'name' => $subLesson->name, 'type' => $subLesson->type]);
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
        $subLessons = $lesson->subLesson()->active()->get();
        $report     = [];

        if ($subLessons)
        {
            foreach ($subLessons as $subLesson)
            {
				$subReport = [];
                $subReport['name'] = $subLesson->name;
                $subReport['type'] = $this->getType($subLesson);
                $subReport['sub_lesson_id'] = $subLesson->id;

                if ($subLesson->is_exercise == Lesson::IS_EXERCISE && $subLesson->type == Lesson::LESSON)
                {
                    $subReport['total'] = $this->countTotalQuestion($subLesson->id);
                    $subReport['done']  = $this->countCorrectQuestion($subLesson->id);
                    $subReport['passed']  = $this->passLesson($subLesson->id);
                }

                if ($subLesson->is_exercise == Lesson::IS_DOC && $subLesson->type == Lesson::LESSON)
                {
                    $subReport['done'] = $subReport['passed'] = $this->checkPassTheory($subLesson->id);
                }

                if ($subLesson->type == Lesson::EXAM)
                {
					$subReport = array_merge($subReport, $this->exam($subLesson));
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
	private function passLesson($lessonID)
	{
		$userLesson = UserLessonLog::where('user_id',$this->user->id)
			->where('lesson_id',$lessonID)
			->first();

		if(!$userLesson){
			return false;
		}
		return $userLesson->turn_right > 0 ? true : false;
	}

    /**
     * @param $lessonID
     * @return mixed
     */
    private function countTotalQuestion($lessonID){
        return Question::where('lesson_id',$lessonID)
            ->typeAllow()->where('parent_id', Lesson::PARENT_ID)->count();
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

    	if ($lesson->parent_id != Lesson::PARENT_ID){
			if ($lesson->is_exercise() && $lesson->type == Lesson::LESSON){
				return 'exercise';
			}
			if ($lesson->is_exercise() && $lesson->type == Lesson::EXAM){
				return Lesson::EXAM;
			}
			if (!$lesson->is_exercise() && $lesson->type == Lesson::LESSON){
				return 'theory';
			}

			if (!$lesson->is_exercise()){
				return 'theory';
			}
		}else {
			return $lesson->type;
		}

        return null;
    }

    /**
     * @param Lesson $lesson
     * @return array
     */
    private function exam(Lesson $lesson){

        $userScore = 0;
        $exam = Exam::where('lesson_id', $lesson->id)->first();

        $examUser = ExamUser::where('user_id', $this->user->id)
            ->where('lesson_id', $lesson->id)
            ->first();
        $highestScore = $examUser ? $examUser->highest_score : $userScore;

       return [
		   'standard_score' => $exam->min_score,
		   'highest_score'  => $highestScore,
		   'near_score'     => $examUser ? $examUser->score : $userScore,
		   'passed'         => $highestScore >= $exam->min_score ? true : false,
       ];

    }


    public function statusFourBottom()
    {

        $lessonId = request()->get('lesson_id');

        $bookmark = UserQuestionBookmark::query()
            ->where('user_id', $this->user->id)
            ->where('course_id', $this->course->id)
            ;

        $wrongQuestion = UserQuestionLog::query()
            ->where('user_id', $this->user->id)
            ->where('status', Question::REPLY_ERROR)
            ->where('course_id', $this->course->id)
            ;

        $didLesson = UserQuestionLog::query()
            ->where('user_id', $this->user->id)
            ->where('course_id', $this->course->id)
            ;

        $newLesson = Lesson::query()
         	->where('course_id', $this->course->id)
            ->where('parent_id', '<>', Lesson::PARENT_ID)
            ->where('type', Lesson::LESSON)
            ;

        if (request()->has('lesson_id') && $lessonId){
            $subLesson = Lesson::query()->where('parent_id', $lessonId)->where('type', Lesson::LESSON)->get()->pluck('id');
            $bookmark->whereIn('lesson_id', $subLesson);
            $wrongQuestion->whereIn('lesson_id', $subLesson);
            $didLesson->whereIn('lesson_id', $subLesson);
            $newLesson->whereIn('id', $subLesson);
        }

		$existNewLesson = false;
        foreach ($newLesson->get() as $new){

			if($new->type == Lesson::LESSON){
				if ($new->is_exercise()){
					$lessonService = new LessonService($new, $this->user);
					$totalQuestions = $lessonService->totalQuestions();
					$didQuestions = $lessonService->didQuestions();
					if ($didQuestions < $totalQuestions){
						$existNewLesson = true;
						break;
					}
				}else{
					$theory = $new->lessonLog()->where('user_id', $this->user->id)->first();
					if (!$theory){
						$existNewLesson = true;
						break;
					}
				}
			}

			if ( $new->type == Lesson::EXAM){
				$userExam  = $new->examUser()->where('user_id', $this->user->id)->first();
				if (!$userExam){
					$existNewLesson = true;
					break;
				}
			}
		}

        $status['bookmark'] = $bookmark->exists();

        $status['wrongQuestion'] = $wrongQuestion->exists();

        $status['didLesson'] = $didLesson->exists();

        $status['newLesson'] = $existNewLesson;
        return $status;
    }
}