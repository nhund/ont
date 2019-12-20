<?php

namespace App\Listeners;

use App\Events\BeginExamEvent;
use App\Models\Exam;
use App\Models\ExamUser;
use App\Models\ExamUserAnswer;

class BeginExamListener
{
    protected $exam;
    protected $user;
    /**
     * @param BeginExamEvent $event
     */
    public function handle(BeginExamEvent $event)
    {
        $this->exam = $event->exam;
        $this->user = $event->user;

        $this->resetUserExam();
        $this->deleteAnswerBefore();
    }

    /**
     * reset score exam
     */
    private function resetUserExam(){

        $userExam = ExamUser::where('lesson_id', $this->exam->id)
            ->where('user_id', $this->user->id)
            ->first();

        if (!$userExam) {

            $exam = Exam::where('lesson_id', $this->exam->id)->firstOrFail();

            ExamUser::create([
                 'lesson_id'      => $this->exam->id,
                 'user_id'        => $this->user->id,
                 'turn'           => 1,
                 'score'          => 0,
//                 'begin_at'       => now(),
                 'time'           => $exam->minutes,
             ]);

        }else{
            $userExam->score = 0;
            $userExam->turn += 1;
//            $userExam->begin_at = now();
            $userExam->save();
        }
    }

    /**
     * deleting answer of questions the user had before
     */
    private function deleteAnswerBefore()
    {
        ExamUserAnswer::where([
            'user_id' => $this->user->id,
            'lesson_id' => $this->exam->id
        ])->delete();
    }

}
