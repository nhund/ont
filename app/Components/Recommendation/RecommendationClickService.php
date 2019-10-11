<?php

namespace App\Components\Recommendation;

use App\Models\Course;
use App\Models\Question;
use App\User;

class RecommendationClickService extends RecommendationCommon
{
    protected $course;
    protected $user;

    public function __construct(Course $course, User $user){
        parent::__construct();

        $this->course = $course;
        $this->user   = $user;
    }

    public function doingNewQuestions($lessonId, $userId)
    {
        return Question::where('lesson_id', $lessonId)
            ->leftJoin('user_question_log',function ($q) use ($userId){
                $q->on('question.id','=','user_question_log.question_id')
                ->on('user_question_log.user_id', $userId);
            })
            ->orderBy('wrong_number')
            ->limit(10)->get()
            ->pluck('question.id')->toArray();
    }
}