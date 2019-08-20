<?php

use Illuminate\Database\Seeder;

use App\Models\Lesson;
use App\Models\Question;

class removeQuestionError extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = Question::get();
        foreach($questions as $question)
        { //echo $question->id;
        	$lesson = Lesson::find($question->lesson_id);
        	if(!$lesson)
        	{
        		Question::where('id',$question->id)->delete();
        		$this->command->info("update!".$question->id);
        	}
        }
        $this->command->info("end");
    }
}
