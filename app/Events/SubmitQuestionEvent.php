<?php

namespace App\Events;

use App\Models\Lesson;
use App\Models\Question;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SubmitQuestionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $question;
    public $user;

    /**
     * SubmitQuestionEvent constructor.
     * @param Question $question
     * @param User $user
     */
    public function __construct(Question $question, User $user)
    {
        $this->question = $question;
        $this->user = $user;
    }
}
