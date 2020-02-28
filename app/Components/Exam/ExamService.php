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

        if ($userExam->questions){
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
                if (count($arrayQuestions) < $part->number_question){
                    throw new BadRequestException("Chưa đủ câu hỏi cho {$part->name}");
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

            $userExam->questions = \json_encode($questionPart);
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
}