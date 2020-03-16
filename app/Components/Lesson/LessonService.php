<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 20/09/2019
 * Time: 16:08
 */

namespace App\Components\Lesson;

use App\Models\Lesson;
use App\Models\Question;
use App\Models\UserQuestionBookmark;
use App\Models\UserQuestionLog;
use App\User;

/**
 * Class LessonService
 * @package App\Components\Lesson
 */
class LessonService
{
    /**
     * @var Lesson
     */
    protected $lesson;
    /**
     * @var User
     */
    protected $user;

    /**
     * @var
     */
    protected $totalQuestions;
    /**
     * @var
     */
    protected $didQuestions;
    /**
     * @var
     */
    protected $totalWrongQuestions;
    /**
     * @var
     */
    protected $totalCorrectQuestions;
    /**
     * @var
     */
    protected $newQuestions;


    /**
     * LessonService constructor.
     * @param Lesson $lesson
     * @param User $user
     */
    public function __construct(Lesson $lesson, User $user)
    {
        $this->lesson = $lesson;
        $this->user   = $user;
    }

    /**
     * @return array
     */
    public function get()
    {
        $this->totalQuestions = $this->totalQuestions();
        list($this->totalCorrectQuestions, $this->totalWrongQuestions) = $this->totalCorrectWrongQuestion();
        $this->didQuestions = $this->didQuestions();
        return [
            'totalNewQuestions'     => $this->totalNewQuestions(),
            'totalQuestions'        => $this->totalQuestions,
            'totalBookmarkQuestions'=> $this->totalBookmarkQuestions(),
            'totalWrongQuestions'   => $this->totalWrongQuestions,
            'totalCorrectQuestions' => $this->totalCorrectQuestions,
            'totalDid'              => $this->didQuestions,
        ];
    }

    /**
     * @return mixed
     */
    public function totalQuestions()
    {
        return Question::where('lesson_id', $this->lesson->id)
            ->typeAllow()
            ->where('parent_id', Question::PARENT_ID)->count();
    }

    /**
     * @return mixed
     */
    public function totalNewQuestions()
    {
        return $this->totalQuestions - $this->didQuestions;
    }

    /**
     * @return mixed
     */
    public function didQuestions()
    {
        return UserQuestionLog::where('lesson_id', $this->lesson->id)
            ->where('user_id', $this->user->id)
            ->count();
    }

    /**
     * @return array
     */
    public function totalCorrectWrongQuestion()
    {
        $correct = $wrong = 0;
        $userQuestions =  UserQuestionLog::select('status', \DB::raw('count(status) as total'))
            ->active()
            ->where('lesson_id', $this->lesson->id)
            ->where('user_id', $this->user->id)
            ->groupBy('status')
            ->get()
            ;
        foreach ($userQuestions as $question)
        {
            if ($question->status == Question::REPLY_OK){
                $correct = $question->total;
            }
            if ($question->status == Question::REPLY_ERROR){
                $wrong = $question->total;
            }
        }
        return [$correct, $wrong];
    }

    /**
     * @return mixed
     */
    public function totalBookmarkQuestions()
    {
        return UserQuestionBookmark::where('lesson_id', $this->lesson->id)
            ->where('user_id', $this->user->id)
            ->whereNotNull('question_id')
            ->groupBy('question_id')
            ->count();
    }

}