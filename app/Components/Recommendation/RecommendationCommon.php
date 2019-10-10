<?php

namespace App\Components\Recommendation;

use App\Models\Course;
use App\User;

abstract class RecommendationCommon
{
    public function doingNewQuestions($lessonId, $userId)
    {
        
    }

    public function doingOldQuestions()
    {
        
    }

    public function doingBookmarkQuestions()
    {
        
    }

    public function doingWrongQuestions()
    {
        
    }

    // bằng số lượt làm đúng nhỏ nhất của các câu trong bài đấy
    protected function numberCorrectLesson(){
        //  select
        //	log.id,
        //	log.lesson_id,
        //	que.status,
        //	que.user_id,
        //	que.question_id as q_id
        //  from onthiez1.question as log
        //  left join onthiez1.user_question_log as que
        //	on log.id = que.question_id  and que.user_id = 881
        //  where log.lesson_id = 698
    }

    // bằng tổng số lượt đúng và sai nhỏ nhất của bài tập đấy
    protected function numberDidLesson(){

    }
}