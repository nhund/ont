<?php

use Illuminate\Database\Seeder;
use App\Models\Lesson;

class update_lesson_add_lesson_lythuyet extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lessons = Lesson::where('parent_id',0)->get();
        if(count($lessons) > 0)
        {
        	foreach ($lessons as $lesson) {
        		if(!empty($lesson->description))
        		{
        			$lesson_lythuyet = new Lesson();
        			$lesson_lythuyet->name = 'Lý thuyết';
        			$lesson_lythuyet->description = $lesson->description;
        			$lesson_lythuyet->created_at = $lesson->created_at;
        			$lesson_lythuyet->updated_at = time();
        			$lesson_lythuyet->parent_id = $lesson->id;
        			$lesson_lythuyet->course_id = $lesson->course_id;
        			$lesson_lythuyet->status = Lesson::STATUS_ON;
        			$lesson_lythuyet->is_exercise = Lesson::IS_DOC;
        			$lesson_lythuyet->order_s = 0;
        			$lesson_lythuyet->lv1 = $lesson->id;
        			$lesson_lythuyet->save();

        			$this->command->info("inserted!".$lesson->id);
        		}
        	}
        	$this->command->info("end!");
        }else{
        	$this->command->info("lesson count 0");
        }
    }
}
