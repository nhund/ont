<?php

use Illuminate\Database\Seeder;
use App\Models\UserQuestionLog;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\UserLessonLog;

class UpdateQuestionLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$questionLogs = UserQuestionLog::where('id','<',10354)->get();
    	foreach($questionLogs as $log)
    	{
    		$up_question_true = false;
    		$question = Question::find($log->question_parent);
    		if($question->type == Question::TYPE_FLASH_SINGLE || $question->type == Question::TYPE_FLASH_MUTI)
    		{
    			$count_question_child = 1;
    		}else{
    			$count_question_child = Question::where('parent_id',$log->question_parent)->count();	
    		}
    		
            //kiem tra xem da lam dung bn cau
    		 $count_question_true = UserQuestionLog::where('question_parent',$log->question_parent)->where('lesson_id',$log->lesson_id)->where('user_id',$log->user_id)->where('status',QuestionAnswer::REPLY_OK)->where('id','<=',$log->id)->count();
    		if($count_question_child == $count_question_true)
    		{
    			$up_question_true = true;
    		}
    		$lesson_log = UserLessonLog::where('user_id',$log->user_id)->where('lesson_id',$log->lesson_id)->first();
    		if($lesson_log)
    		{
    			if($up_question_true)
		        {
		            // tang so cau tra loi dung
		            $lesson_log->count_question_true += 1;
		            $lesson_log->save();
		            // if((int)$lesson_log->count_question_true == $lesson_questions)
		            // {
		            //     // lam dung het tat ca cau hoi. reset tong so cau tra loi dung
		            //     // tang luot lam len
		            //     $lesson_log->count_question_true = 0;
		            //     $lesson_log->count += 1;
		            //     $lesson_log->save();
		            // }
		        }
    		}else{
    			$lesson_log = new UserLessonLog();
    			$lesson_log->user_id = $log->user_id;
    			$lesson_log->course_id = $log->course_id;
    			$lesson_log->lesson_id = $log->lesson_id;
    			$lesson_log->count = 1;
    			$lesson_log->create_at = $log->create_at;
    			$lesson_log->count_question_true = $up_question_true == true ? 1 : 0;
    			$lesson_log->save();
    		}
    		$this->command->info("inserted!".$log->id);
    	}
    	$this->command->info("inserted end");
    }
}
