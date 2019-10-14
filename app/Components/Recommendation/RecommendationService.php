<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 20/09/2019
 * Time: 16:12
 */

namespace App\Components\Recommendation;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionCardMuti;
use App\Models\QuestionLogCurrent;
use App\Models\UserLessonLog;
use App\Models\UserQuestionBookmark;
use App\Models\UserQuestionLog;
use App\User;

/**
 * - Tất cả các bài tập trong 1 khóa học  được đánh số thứ tự từ 1 đến N. Trong một bài tập các câu hỏi cũng được đánh thứ tự từ 1 đến M.
 *     Nếu thay đổi thứ tự, hoặc thêm bài tập, câu hỏi thì số thứ tự của các bài tập phía sau cũng cần được thay đổi.
 * - Với mỗi user cần lưu được các thông tin liên quan đến tiến độ làm bài tập như sau:
 *    + Với mỗi bài tập mặc định ban đầu số lượt làm đúng toàn bộ câu hỏi trong bt đo là: A=0. Mỗi câu hỏi trong bài tập đó cũng có số lượt làm đúng ban đầu là B= 0. Số lượt trả lời của mỗi câu hỏi cả đúng và sai là C.
 *    + Khi câu hỏi có số thứ tự i được trả lời đúng 1 lần thì B(i) tăng thêm một đơn vị. Nếu đúng hoặc sai thì C(i) tăng thêm 1 đơn vị.
 *    + Số lượt làm đúng của 1 bài tập:a bằng giá trị nhỏ nhất của B(i),  i từ 1 đến M trong bài tập đó.
 *    + Số lượt đã làm của 1 bài tập: D= giá trị nhỏ nhất của C(i), ),  i từ 1 đến M trong bài tập đó.
 *    + Lần làm gần nhất của câu hỏi thứ i là đúng hay sai.
 *
 * Class RecommendationService
 * @package App\Components\Recommendation
 */

class RecommendationService
{
    /**
     * - Tìm xem trong khóa học bài tập có lượt làm: D=0, có số thứ tự nhỏ nhất. Lấy ra để làm bài.
     * - Làm lần lượt 10 câu 1 lượt (theo đúng thứ tự câu hỏi trong bài tập).
     * - Làm hết 10 câu hỏi muốn làm tiếp không hoặc out ra màn hình chính.
     *
     * @param Course $course
     * @param User $user
     * @return  array
     */
    public function doingNewQuestions(Course $course, User $user)
    {
        $limit = request('limit', 10);
        //lay lesson da hoc

        $lesson = Lesson::select('lesson.*')
            ->leftJoin('user_lesson_log', function ($q) use ($user){
                $q->on('user_lesson_log.lesson_id', '=', 'lesson.id')
                ->where('user_lesson_log.user_id', $user->id);
            })
            ->where('lesson.parent_id', '<>', 0)
            ->where('lesson.course_id', $course->id)
            ->orderBy('turn')
            ->first()
        ;

        $questionLearnedLogs = UserQuestionLog::where('course_id',$course->id)
            ->where('user_id',$user->id)
            ->groupBy('question_parent')->get()
            ->pluck('question_parent')->toArray();

            // kiem tra xem co ly thuyet trong bai hoc ko
            $theories = Lesson::where('course_id',$course->id)
                ->where('parent_id',$lesson->id)
                ->where('is_exercise',Lesson::IS_DOC)
                ->orderBy('order_s','ASC')
                ->orderBy('created_at','ASC')
                ->get();

            if(count($theories) > 0)
            {
                foreach ($theories as $theory) {
                    //kiem tra xem bai nay da hoc ly thuyet chua
                    //$check_lesson_log = in_array($lesson->id, $lesson_log);
                    $checkTheory = UserLessonLog::where('user_id',$user->id)
                        ->where('course_id',$course->id)
                        ->where('pass_ly_thuyet',UserLessonLog::PASS_LY_THUYET)
                        ->where('lesson_id',$theory->id)
                        ->first();

                    if(!$checkTheory && !empty($lesson->description))
                    {
                        $var['course'] = $course;
                        $var['lesson'] = $theory;
                        return $var;
                    }
                }
            }

            if($lesson->is_exercise == Lesson::IS_EXERCISE)
            {
                //kiem tra xem bai tap co co cau hoi chua , va cau hoi da lam chua
                $check_has_question = Question::whereNotIn('id',$questionLearnedLogs)
                    ->where('parent_id',0)
                    ->where('lesson_id',$lesson->id)
                    ->orderBy('order_s','ASC')
                    ->orderBy('id','ASC')->count();

                if($check_has_question > 0)
                {

                    //lay cac cau hoi da lam
                    $question_log = UserQuestionLog::where('user_id',$user->id)->where('lesson_id',$lesson->id)->get()->pluck('question_parent')->toArray();

                    $questions = Question::where('lesson_id', $lesson->id)->where('parent_id',0)->whereNotIn('id',$question_log)
                        ->orderBy('order_s','ASC')
                        ->orderBy('id','ASC')->take($limit)->get();

                    $getQuestionDetail = $this->_getQuestion($user, $questions, $question_log);

                    return $getQuestionDetail;
                }
            }
            return null;

    }

    /**
     * - Chọn bài tập có số lượt làm đúng nhỏ nhất, Min A, số thứ tự nhỏ nhất.
     * - Lấy hết câu hỏi để làm, chọn ngẫu nhiễn. Mỗi lần lấy 10 câu.
     * - Làm hết tất cả các câu trong bài đó quay lại màn hình chính của khóa học

     * @param Course $course
     * @param User $user
     * @return  array
     */
    public function doingReplayQuestions(Course $course, User $user)
    {
        $limit = request('limit', 10);
        $lesson = Lesson::select('lesson.*')
            ->leftJoin('user_lesson_log', function ($q) use ($user){
                $q->on('user_lesson_log.lesson_id', '=', 'lesson.id')
                    ->where('user_lesson_log.user_id', $user->id);
            })
            ->where('lesson.parent_id', '<>', 0)
            ->where('lesson.course_id', $course->id)
            ->orderBy('turn_right')
            ->first()
        ;

        //loai bo cac cau da luu de phan trang
        $questions = Question::where('lesson_id',$lesson->id)
            ->where('parent_id',0)
            ->orderByRaw('RAND()')->take($limit)
            ->get();

        $getQuestionDetail = $this->_getQuestion($user, $questions);
        $var['userBookmark'] = $getQuestionDetail['userBookmark'];
        $var['questions'] = $getQuestionDetail['questions'];
        $var['type'] = Question::LEARN_LAM_CAU_CU;

        return $var;

    }

    /**
     * - Không lấy riêng theo từng bài tập, mà lấy ngẫu nhiễn 10 câu một lần làm, lần thứ 2 lấy ngẫu nhiên 10 câu trong số các câu chưa làm, cho đến hết)
     *
     * @param Course $course
     * @param User $user
     * @return  array
     */
    public function doingBookmarkQuestions(Course $course, User $user)
    {
        $limit = request('limit', 10);

        //lay danh sach bookmark

        $userBookmark = UserQuestionBookmark::where('user_id',$user->id)->where('course_id',$course->id)->get()->pluck('question_id')->toArray();

        $questions = Question::whereIn('id',$userBookmark)->where('parent_id',0)->orderBy('order_s','ASC')
            ->orderBy('id','ASC')->take($limit)->get();

        $getQuestionDetail = $this->_getQuestion($user, $questions);

        $var['userBookmark'] = $getQuestionDetail['userBookmark'];

        $var['questions'] = $getQuestionDetail['questions'];

        return $var;
    }

    /**
     * - Tim bài tập có chứa câu sai từ trên xuống dưới: làm câu sai trong từng bài tập mỗi lần. (Trước khi vào làm bào có một màn hình thông báo, bạn đang làm những  câu sai của bài tập x).
     * - Làm một lượt 10 câu sai, lấy ngẫu nhiên của bài tập đó. Hết 10 câu tiếp tục lấy ngẫu nhiên 10 các câu sai của bài tập đó cho đến khi người dùng trả lời đúng toàn bộ.
     *
     * @param Course $course
     * @param User $user
     *  @return  array
     */
    public function doingWrongQuestions(Course $course, User $user)
    {
        $limit = request('limit', 10);

        $lessons = Lesson::where('course_id',$course->id)
            ->where('type', Lesson::LESSON)
            ->where('is_exercise',Lesson::IS_EXERCISE)
            ->where('parent_id', '<>', 0)
            ->get();

        foreach ($lessons as $lesson){
            $question = UserQuestionLog::where('course_id',$course->id)
                ->where('user_id',$user->id)
                ->where('lesson_id',$lesson->id)
                ->where('status',Question::REPLY_ERROR)
                ->orderBy('create_at','ASC')->get();

            if ($question->count()){
                $questionErrors = $question->pluck('question_parent')->toArray();

                $questions = Question::whereIn('id',$questionErrors)->where('parent_id',0)->orderBy('order_s','ASC')
                    ->orderBy('id','ASC')->take($limit)->get();

                $getQuestionDetail = $this->_getQuestion($user, $questions);

                $var['userBookmark'] = $getQuestionDetail['userBookmark'];

                $var['questions'] = $getQuestionDetail['questions'];

                return $var;
            }
        }
        return [];
    }

    /**
     * @param $user
     * @param $questions
     * @param array $notIn
     * @param string $type
     * @return array
     */
    private function _getQuestion($user, $questions, $notIn = array() , $type = '')
    {
        $lesson_id = 0;
        foreach($questions as $question)
        {
            $lesson_id = $question->lesson_id;
            if($question->type  == Question::TYPE_DIEN_TU)
            {
                if($type == Question::LEARN_LAM_BAI_MOI)
                {
                    $question->child = Question::where('parent_id',$question->id)->whereNotIn('id',$notIn)->orderBy('order_s','ASC')
                        ->orderBy('id','ASC')->get();
                }else{
                    $question->child = Question::where('parent_id',$question->id)->orderBy('order_s','ASC')
                        ->orderBy('id','ASC')->get();
                }

            }
            if($question->type  == Question::TYPE_FLASH_MUTI)
            {
                $questionSub = QuestionCardMuti::where('parent_id',$question->id)->where('lesson_id',$question->lesson_id)->get();
                if(count($questionSub) > 0)
                {
                    foreach ($questionSub as $key => $value) {
                        $value->child = QuestionCardMuti::where('parent_id',$value->id)->where('lesson_id',$question->lesson_id)->get();
                    }
                }
                $question->child = $questionSub;
            }
            if($question->type  == Question::TYPE_TRAC_NGHIEM)
            {

                if($type == Question::LEARN_LAM_BAI_MOI)
                {
                    $questionChilds = Question::where('parent_id',$question->id)->whereNotIn('id',$notIn)->orderBy('order_s','ASC')
                        ->orderBy('id','ASC')->get();
                }else{
                    $questionChilds = Question::where('parent_id',$question->id)->orderBy('order_s','ASC')
                        ->orderBy('id','ASC')->get();
                }

                foreach($questionChilds as $questionChild)
                {
                    $lesson = $questionChild->lesson;
                    if($lesson->random_question == Lesson::TRAC_NGHIEM_ANSWER_RANDOM)
                    {
                        $questionChild->answers = QuestionAnswer::where('question_id',$questionChild->id)->orderByRaw('RAND()')->get();
                    }else{
                        $questionChild->answers = QuestionAnswer::where('question_id',$questionChild->id)->orderBy('answer','ASC')->get();
                    }

                }
                $question->child = $questionChilds;
            }
            if($question->type  == Question::TYPE_DIEN_TU_DOAN_VAN)
            {
                if($question->parent_id == 0)
                {
                    $sub_questions = Question::where('parent_id',$question->id)->orderBy('id','asc')->get();
                    foreach ($sub_questions as $key => $sub_q) {
                        $str = $sub_q->question;
                        $pattern = '/<a .*?class="(.*?cloze.*?)">(.*?)<\/a>/';
                        $content = preg_replace_callback($pattern, function($m) use ($sub_q) {
                            static $incr = 0;
                            $incr += 1;
                            //$title = '';
                            if( strpos($m[1], 'clozetip' ) !== false) {
                                $get_title = '';
                                $title = preg_replace_callback('/title="(.*?)"/', function($m_x) use(&$get_title) {
                                    $get_title = $m_x[1];
                                    return ''.$m_x[1].'';
                                },$m[1]);

                                if(empty($get_title))
                                {
                                    return '<input title="" type="text" name="txtLearnWord['.$sub_q->id.']['.$incr.']" class="input_answer" value= "">';
                                }else{
                                    return '<nobr><input title="" type="text" name="txtLearnWord['.$sub_q->id.']['.$incr.']" class="input_answer" value= ""><img class="show_suggest" data-title="'.$get_title.'" src="'.asset('/public/images/course/icon/bong_den_size.png').'" align="baseline" border="0" title="Xem gợi ý" style="margin-left:6px;cursor: pointer;"></nobr>';
                                }

                            }else{
                                return '<input title="" type="text" name="txtLearnWord['.$sub_q->id.']['.$incr.']" class="input_answer" value= "">';
                            }

                        }, $str);

                        $sub_q->question_display = $content;
                    }
                    $question->childs =  $sub_questions;
                }
                //dd($question);
            }
        }

        $userBookmark = UserQuestionBookmark::where('user_id',$user->id)->where('lesson_id',$lesson_id)->get()->keyBy('question_id')->toArray();

        return array(
            'questions'=>$questions,
            'userBookmark'=>$userBookmark
        );
    }
}