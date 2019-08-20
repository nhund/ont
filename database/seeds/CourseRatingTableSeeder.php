<?php

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\CourseRating;

class CourseRatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$courses = Course::get();
    	foreach($courses as $course)
    	{
    		$check = CourseRating::where('course_id',$course->id)->first();
    		if(!$check)
    		{
    			$course_rating = new CourseRating();
    			$course_rating->course_id = $course->id;
    			$course_rating->rating_1 = 0;
    			$course_rating->rating_2 = 0;
    			$course_rating->rating_3 = 0;
    			$course_rating->rating_4 = 0;
    			$course_rating->rating_5 = 0;
    			$course_rating->create_date = time();                                    
    			$course_rating->save();
    		}
    	}
    	$this->command->info("inserted!");
    }
}
