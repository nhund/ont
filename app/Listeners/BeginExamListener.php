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
                 'until_number'   => 1,
                 'status_stop'    => ExamUser::ACTIVE,
                 'begin_at'       => now(),
                 'time'           => $exam->minutes,
                 'second_stop'    => 0,
                 'stopped_at'     => null,
                 'turn_stop'      => 0,
                 'status'         => ExamUser::ACTIVE,
             ]);

        }else{
            $userExam->score = 0;
            $userExam->turn += 1;
            $userExam->until_number = 1;
            $userExam->begin_at = now();
            $userExam->status_stop = ExamUser::ACTIVE;
            $userExam->second_stop = 0;
            $userExam->stopped_at  = null;
            $userExam->turn_stop   = 0;
            $userExam->status      = ExamUser::ACTIVE;
            $userExam->questions   = null;
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
