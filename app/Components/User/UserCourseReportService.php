<?php


namespace App\Components\User;


use App\Models\Course;
use App\Models\Lesson;

class UserCourseReportService
{
    protected $course;
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function get(){
        $lessons = $this->lessons();

        foreach ($lessons as $lesson){
//            if (){
//
//            }
        }
    }

    private function exercise(){

    }

    private function theory(){
        
    }

    private function exam(){

    }

    private function lessons(){
        return Lesson::where('parent_id', Lesson::PARENT_ID)->where('course_id', $this->course->id)->get();
    }
}