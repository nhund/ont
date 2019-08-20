<?php

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Question;

class UsersLessonLogUpdateCount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lessons = Lesson::where('parent_id','>',0)->orderBy('id','ASC')->get();
        foreach($lessons as $lesson)
        { 
        	if($lesson->parent_id > 0)
        	{
        		$lesson_parent = Lesson::find($lesson->parent_id);
	        	if(!$lesson_parent)
	        	{
	        		$lesson->delete();	        		
	        	}
        	}        	
        }
        $this->command->info("end");
    }
}
