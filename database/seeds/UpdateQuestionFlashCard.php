<?php

use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\QuestionCardMuti;

class UpdateQuestionFlashCard extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = QuestionCardMuti::get();
        foreach($questions as $question)
        {
        	$lesson = Lesson::find($question->lesson_id);
        	if($lesson)
        	{
        		$question->course_id = $lesson->course_id;
        		$question->save();
        		$this->command->info("update!".$question->id);
        	}
        }
        $this->command->info("end");
    }
}
