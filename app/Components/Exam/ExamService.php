<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 20/09/2019
 * Time: 16:06
 */

namespace App\Components\Exam;


use App\Components\Question\QuestionService;
use App\Events\BeginExamEvent;
use App\Exceptions\BadRequestException;
use App\Models\ExamPart;
use App\Models\ExamQuestion;
use App\Models\ExamUser;
use App\Models\ExamUserAnswer;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\TeacherSupport;
use App\User;
use Auth;

class ExamService
{
    public function checkPermission($id) {
        if (!$id || !$lesson = Lesson::find($id)) {
            return false;
        }
        //check support
        $course_support = TeacherSupport::where('course_id',$lesson->course_id)->where('user_id',Auth::user()['id'])->first();

        if ($lesson->course['user_id'] != Auth::user()['id'] && !$course_support && Auth::user()['level'] != User::USER_ADMIN) {
            return false;
        }
        return $lesson;
    }

    public function insertExamQuestion( $question_id, $lesson_id, $part = null){
        return ExamQuestion::create([
             'lesson_id' => $lesson_id,
             'question_id' => $question_id,
             'part' => $part,
        ]);
    }

    /**
     * @param Lesson $lesson
     * @param $userExam
     * @return mixed
     * @throws BadRequestException
     */
    public function getQuestionExam(Lesson $lesson, $userExam)
    {
        $questions = collect();

        if ($userExam && $userExam->questions){
            $userExamQuestions = \json_decode($userExam->questions);
            foreach ($userExamQuestions as $partId => $partQuestion){
                $questionsArray = Question::whereIn('id', $partQuestion)
                    ->typeAllow()
                    ->where('parent_id',0)->orderBy('order_s','ASC')
                    ->orderBy('id','ASC')->get();
                $questions = $questions->merge($questionsArray);
            }

        }else{
            $examParts = ExamPart::where(['lesson_id' => $lesson->id])->get();

            $questionPart = [];
            foreach ($examParts as $part){

                $arrayQuestions = ExamQuestion::where([
                  'lesson_id'=> $lesson->id,
                  'part' => $part->id,
                  'status'=> ExamQuestion::ACTIVE])
                    ->orderBy('part')
                    ->pluck('question_id')->toArray();
                $questionsArray = collect();
                if (count($arrayQuestions) < $part->number_question ||  $part->number_question == 0){
                    if (request()->ajax()){
                        throw new BadRequestException("Phần thi {$part->name} chưa hoàn thiện");
                    }
                    return false;
                }

                if (count($arrayQuestions) > $part->number_question){
                    $arrayQuestions = array_values(array_intersect_key( $arrayQuestions, array_flip( array_rand( $arrayQuestions, $part->number_question ) ) ));
                    $questionsArray = Question::whereIn('id', $arrayQuestions)
                        ->typeAllow()
                        ->where('parent_id',0)->orderBy('order_s','ASC')
                        ->orderBy('id','ASC')->get();
                }
                if (count($arrayQuestions) == $part->number_question){
                    $questionsArray = Question::whereIn('id', $arrayQuestions)
                        ->typeAllow()
                        ->where('parent_id',0)->orderBy('order_s','ASC')
                        ->orderBy('id','ASC')->get();
                }

                $questions = $questions->merge($questionsArray);
                $questionPart[$part->id] = $arrayQuestions;
            }

            $userExam->questions = count($questionPart) ?  \json_encode($questionPart) : NULL;
            $userExam->save();
        }

        return (new QuestionService())->getQuestions($questions, $lesson);
    }

    public function resultQuestion($lessonId, $userId)
    {
        return ExamPart::where('lesson_id', $lessonId)
            ->whereHas('userExamAnswer', function ($q) use ($userId){
                $q->where('exam_user_answer.user_id',$userId);
            })
            ->with(['userExamAnswer' => function ($q) use ($userId){
                $q->where('exam_user_answer.user_id',$userId);
            }])->get()->toArray();
    }

	public function submitExam($lesson, $user)
	{
		$userExam = ExamUser::where('lesson_id', $lesson->id)
			->where('user_id', $user->id)->first();

		$now = now();
		$doingTime = date('Y-m-d H:i:s', strtotime($userExam->begin_at) + ($userExam->time*60));

		$time = $now > $doingTime ? $doingTime : $now;

		$userExam->last_at = $time;
		$userExam->status = ExamUser::STOPPED;

		if ($userExam->turn == 1){
			$userExam->last_submit_at = $time;
			return $userExam->save();
		}
		$secondHighest = strtotime($userExam->last_submit_at) - strtotime($userExam->begin_highest_at) - $userExam->second_stop_highest;
		$second 	   = strtotime($userExam->last_at) - strtotime($userExam->begin_at) - $userExam->second_stop;
		if($secondHighest > $second && $userExam->score >= $userExam->highest_score){
			$userExam->begin_highest_at = $userExam->begin_at;
			$userExam->last_submit_at   = $time;
			return $userExam->save();
		}

		return $userExam->save();
    }
}