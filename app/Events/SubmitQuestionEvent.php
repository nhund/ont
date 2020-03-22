<?php

namespace App\Events;

use App\Models\Lesson;
use App\Models\Question;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SubmitQuestionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels, Queueable;

    public $questionId;
    public $user;

    /**
     * SubmitQuestionEvent constructor.
     * @param $questionId
     * @param User $user
     */
    public function __construct($questionId, User $user)
    {
        $this->questionId = $questionId;
        $this->user = $user;
    }
}
