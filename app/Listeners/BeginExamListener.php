<?php

namespace App\Listeners;

use App\Events\BeginExamEvent;
use App\Exceptions\BadRequestException;
use App\Models\Exam;
use App\Models\ExamUser;
use App\Models\ExamUserAnswer;

class BeginExamListener
{
    protected $exam;
    protected $lesson;
    protected $user;
    protected $userExam;

    /**
     * @param BeginExamEvent $event
     * @throws BadRequestException
     */
    public function handle(BeginExamEvent $event)
    {
        $this->lesson = $event->exam;
        $this->user = $event->user;
        $this->exam = Exam::where('lesson_id', $this->lesson->id)->firstOrFail();
        $this->userExam = ExamUser::where('lesson_id', $this->lesson->id)
            ->where('user_id', $this->user->id)
            ->first();

        $this->resetUserExam();
    }

    /**
     * @throws BadRequestException
     */
    private function resetUserExam(){


        if (!$this->userExam) {

            ExamUser::create([
                 'lesson_id'      => $this->lesson->id,
                 'user_id'        => $this->user->id,
                 'turn'           => 1,
                 'score'          => 0,
                 'until_number'   => 1,
                 'status_stop'    => ExamUser::ACTIVE,
                 'begin_at'       => now(),
                 'time'           => $this->exam->minutes,
                 'second_stop'    => 0,
                 'stopped_at'     => null,
                 'turn_stop'      => 0,
                 'status'         => ExamUser::ACTIVE,
             ]);

        }else{

            if (($this->userExam->turn > $this->exam->repeat_time)
                || ($this->userExam->status == ExamUser::STOPPED)
                || ($this->userExam->status == ExamUser::INACTIVE)
                || (date('Y-m-d H:i:s') < $this->exam->start_time_at)
                || (date('Y-m-d H:i:s') > $this->exam->end_time_at ))
            {
                return false;
            }

            $this->userExam->score = 0;
            $this->userExam->turn += 1;
            $this->userExam->until_number = 1;
            $this->userExam->begin_at = now();
            $this->userExam->status_stop = ExamUser::ACTIVE;
            $this->userExam->second_stop = 0;
            $this->userExam->stopped_at  = null;
            $this->userExam->turn_stop   = 0;
            $this->userExam->status      = ExamUser::ACTIVE;
            $this->userExam->questions   = null;
            $this->userExam->save();

            $this->deleteAnswerBefore();
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
