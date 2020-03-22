<?php

namespace App\Providers;

use App\Events;
use App\Listeners;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Events\BeginExamEvent::class => [
            Listeners\BeginExamListener::class
        ],
        Events\RemoveUserCourse::class => [
            Listeners\RemoveUserCourseListen::class
        ],
        Events\SubmitQuestionEvent::class => [
            Listeners\CountTurnLessonListen::class
        ]
        ,
        Events\RefundCourseEvent::class => [
            Listeners\RefundCourseListener::class
        ],
        Events\DeleteQuestionEvent::class => [
            Listeners\DeleteQuestionListener::class
        ],
        Events\BeginLessonEvent::class => [
            Listeners\BeginDidQuestionListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
