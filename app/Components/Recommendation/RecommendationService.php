<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 20/09/2019
 * Time: 16:12
 */

namespace App\Components\Recommendation;

use App\Components\Lesson\LessonService;
use App\Events\BeginExamEvent;
use App\Events\BeginLessonEvent;
use App\Exceptions\BadRequestException;
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

    public $lesson;

    protected $lessonIds = [];

    /**
     * RecommendationService constructor.
     * @throws BadRequestException
     */
    public function __construct()
    {
        if (request()->has('lesson_id')){
            $this->getLesson();

        }
    }

    const TURN = 0;
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

        if (!$this->lesson || count($this->lessonIds)){
            $this->lesson = $this->_getNewLessonLogUser($course, $user);
        }
        if (!$this->lesson){
            return ['questions' => [], 'type' => Question::LEARN_LAM_BAI_MOI, 'message' => 'Tất cả các bài tập đã được làm'];
        }

        if($this->lesson->is_exercise == Lesson::IS_DOC && $this->lesson->type == Lesson::LESSON){
            $var['lesson'] = $this->lesson;
            $var['type'] = 'theory';
            return $var;
        }

        if($this->lesson->type == Lesson::EXAM){
            $var['lesson'] = $this->lesson;
            $var['type'] = Lesson::EXAM;
            return $var;
        }

        if($this->lesson->is_exercise == Lesson::IS_EXERCISE)
        {
            $questionLearnedLogs = UserQuestionLog::where('course_id',$course->id)
                ->where('user_id',$user->id)
                ->where('lesson_id', $this->lesson->id)
                ->groupBy('question_parent')->get()
                ->pluck('question_parent')->toArray();

            //kiem tra xem bai tap co co cau hoi chua , va cau hoi da lam chua
            $questions = Question::whereNotIn('id',$questionLearnedLogs)
                ->typeAllow()
                ->where('parent_id', Question::PARENT_ID)
                ->where('lesson_id',$this->lesson->id)
                ->orderBy('order_s','ASC')
                ->orderBy('id','ASC')
                ->take($limit)
                ->get();

            if(!empty($questions))
            {
                $getQuestionDetail = $this->_getQuestion($user, $questions, $questionLearnedLogs);
                $getQuestionDetail['type'] = Question::LEARN_LAM_BAI_MOI;
                return $getQuestionDetail;
            }
        }
        return ['questions' => [], 'type' => Question::LEARN_LAM_BAI_MOI, 'message' => 'Tất cả các bài tập đã được làm'];

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

        if (!$this->lesson || count($this->lessonIds)){

            $this->lesson = $this->_getDidLessonLogUser($course, $user);
        }

        if (!$this->lesson){
            return ['questions' => [], 'type' => Question::LEARN_LAM_CAU_CU, 'message' => 'Hiện tại ko có bài tập nào hoạt động'];
        }

        if (request()->has('continue')){
            $questionLog = UserQuestionLog::where('user_id',$user->id)
                ->where('status_delete', UserQuestionLog::INACTIVE)
                ->where('lesson_id', $this->lesson->id)
                ->groupBy('question_parent')->get()
                ->pluck('question_parent')->toArray();
        }else{
            $questionLog = UserQuestionLog::where('user_id',$user->id)
                ->where('lesson_id', $this->lesson->id)
                ->groupBy('question_parent')->get()
                ->pluck('question_parent')->toArray();
            event(new BeginLessonEvent($this->lesson, $user));
        }

        $questions = Question::where('lesson_id',$this->lesson->id)
            ->whereIn('id',$questionLog)
            ->typeAllow()
            ->where('parent_id',Question::PARENT_ID)
            ->orderByRaw('RAND()')->take($limit)
            ->get();

        $getQuestionDetail = $this->_getQuestion($user, $questions);
        $getQuestionDetail['type'] = Question::LEARN_LAM_CAU_CU;
        return $getQuestionDetail;
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
        $userBookmark = UserQuestionBookmark::query()->where('user_id',$user->id)
            ->where('course_id',$course->id);

        if (count($this->lessonIds)){
            $userBookmark->whereIn('lesson_id', $this->lessonIds);
        }
        $userBookmark = $userBookmark->orderBy('turn', 'ASC')->get()
            ->pluck('question_id')->toArray();

        $questions = Question::query()
            ->typeAllow()
            ->whereIn('id',$userBookmark)
            ->where('parent_id',Question::PARENT_ID)
        ;

        if ($this->lesson && count($this->lessonIds)==0){
            $questions->where('lesson_id', $this->lesson->id);
        }

        $questions = $questions->orderBy('order_s','ASC')
            ->orderBy('id','ASC')
            ->take($limit)->get()
        ;

        $getQuestionDetail = $this->_getQuestion($user, $questions);

        $getQuestionDetail['type'] = Question::LEARN_LAM_BOOKMARK;
        return $getQuestionDetail;
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

        if ($this->lesson && count($this->lessonIds) == 0){
            $questions = $this->__getWrongQuestions($course, $this->lesson, $user, $limit);
            $questions['type'] = Question::LEARN_LAM_CAU_SAI;
            return $questions;
        }

        $lessons = Lesson::query()->where('course_id',$course->id)
            ->where('type', Lesson::LESSON)
            ->where('is_exercise', Lesson::IS_EXERCISE)
            ->where('parent_id', '<>', Lesson::PARENT_ID);

        if (count($this->lessonIds)){
            $lessons->whereIn('id', $this->lessonIds);
        }

        foreach ($lessons->get() as $lesson){
            $questions = $this->__getWrongQuestions($course, $lesson, $user, $limit);
            if (count($questions['questions'])){
                return  $questions;
            }
        }
        return ['questions' => []];
    }

    public function suggest(Course $course, User $user)
    {
        $lessons =  Lesson::select('lesson.*')
            ->leftJoin('user_lesson_log', function ($q) use ($user){
                $q->on('user_lesson_log.lesson_id', '=', 'lesson.id')
                    ->where('user_lesson_log.user_id', $user->id);
            })
            ->where('lesson.parent_id', '<>', Lesson::PARENT_ID)
            ->where('lesson.course_id', $course->id)
            ->orderBy('turn')
            ->get();

        $countCorrectLesson = Lesson::select('lesson.*')
            ->leftJoin('user_lesson_log', function ($q) use ($user){
                $q->on('user_lesson_log.lesson_id', '=', 'lesson.id')
                    ->where('user_lesson_log.user_id', $user->id);
            })
            ->where('lesson.parent_id', '<>', Lesson::PARENT_ID)
            ->where('lesson.course_id', $course->id)
            ->where('user_lesson_log.turn_right', '>=', 1 )
            ->count();

        if ($lessons->count() == $countCorrectLesson){
            return $this->doingReplayQuestions($course, $user);
        }

        foreach ($lessons as $lesson){

            if ($lesson->turn == self::TURN)
            {
                return $this->doingNewQuestions($course, $user);
            }

            if ($lesson->turn >= self::TURN)
            {
                $question = $this->doingWrongQuestions($course, $user);
                if (count($question)){
                    return $question;
                }else {
                    continue;
                }
            }
        }
        return ['questions' => []];
    }

    public function clickLesson(Lesson $lesson, User $user)
    {
        $this->lesson = $lesson;
        $limit = request('limit', 10);

        $listQuestionLearned = [];
        //kiem tra xem dang hoc den dau
        $questionLearned = QuestionLogCurrent::where('user_id',$user->id)
            ->where('type',Question::LEARN_LAM_BAI_TAP)
            ->where('course_id',$lesson->course_id)
            ->first();

        if($questionLearned)
        {
            $listId = [];
            if(!empty($questionLearned->content))
            {
                $listId = json_decode($questionLearned->content,true);
            }
            //dd($listId);
            if(isset($listId[$lesson->id]))
            {
                $listQuestionLearned = $listId[$lesson->id];
            }
        }
        $questions = Question::where('lesson_id',$lesson->id)
            ->typeAllow()
            ->whereNotIn('id',$listQuestionLearned)->where('parent_id',0)
            ->orderBy('order_s','ASC')
            ->orderBy('id','ASC')->take($limit)->get();

        $QuestionDetail = $this->_getQuestion($user, $questions);
        $QuestionDetail['type'] = Question::LEARN_LAM_BAI_TAP;

        return $QuestionDetail;
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
                    $question->child = Question::where('parent_id',$question->id)
                        ->typeAllow()->whereNotIn('id',$notIn)
                        ->orderBy('order_s','ASC')
                        ->orderBy('id','ASC')->get();
                }else{
                    $question->child = Question::where('parent_id',$question->id)
                        ->typeAllow()->orderBy('order_s','ASC')
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
                    $questionChilds = Question::where('parent_id',$question->id)
                        ->typeAllow()->whereNotIn('id',$notIn)->orderBy('order_s','ASC')
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
            if($question->type  == Question::TYPE_TRAC_NGHIEM_DON)
            {
                $lesson = $question->lesson;
                if($lesson->random_question == Lesson::TRAC_NGHIEM_ANSWER_RANDOM)
                {
                    $question->answers = QuestionAnswer::where('question_id',$question->id)->orderByRaw('RAND()')->get();
                }else{
                    $question->answers = QuestionAnswer::where('question_id',$question->id)->orderBy('answer','ASC')->get();
                }
            }
            if($question->type  == Question::TYPE_DIEN_TU_DOAN_VAN)
            {
                if($question->parent_id == Question::PARENT_ID)
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

        if ($this->lesson){
            UserLessonLog::where([
                 'course_id' => $this->lesson->course_id,
                 'user_id'   => $user->id,
                 'lesson_id' => $this->lesson->id
             ])->update(['updated_at' => now()]);
        }
        return array(
            'questions'=>$questions,
            'userBookmark'=>$userBookmark
        );
    }

    public function _getNewLessonLogUser($course, $user){

        $parentLessons = Lesson::query()->where('course_id',$course->id)
            ->where('parent_id', Lesson::PARENT_ID)
            ->active()
            ->where('level', '<>', 0);

        if (count($this->lessonIds)){
            $parentLessons->where('id', request('lesson_id'));
        }

        $parentLessons->orderBy('order_s','ASC')
            ->orderBy('created_at','ASC');

        foreach ($parentLessons->get() as $parentLesson) {
            $lessons = Lesson::select('lesson.*')
                ->where('lesson.parent_id', $parentLesson->id)
                ->where('lesson.course_id', $course->id)
                ->orderBy('order_s')
                ->orderBy('lesson.created_at', 'ASC')
                ->get();

            foreach ($lessons as $lesson){
            	if($lesson->type == Lesson::LESSON){
					if ($lesson->is_exercise()){
						$lessonService = new LessonService($lesson, $user);
						$totalQuestions = $lessonService->totalQuestions();
						$didQuestions = $lessonService->didQuestions();
						if ($didQuestions < $totalQuestions){
							return $lesson;
						}
					}else{
						$theory = $lesson->lessonLog()->where('user_id', $user->id)->first();
						if (!$theory){
							return $lesson;
						}
					}
				}

            	if ($lesson->type == Lesson::EXAM){
					$userExam  = $lesson->examUser()->where('user_id', $user->id)->first();
					if (!$userExam){
						return $lesson;
					}
				}

			}
        }
        return false;
    }

    public function _getDidLessonLogUser($course, $user){

        $parentLessons = Lesson::query()->where('course_id',$course->id)
            ->where('parent_id', Lesson::PARENT_ID)
            ->active()
            ->where('level', '<>', 0);

        if (count($this->lessonIds)){
            $parentLessons->where('id', request('lesson_id'));
        }

         $parentLessons->orderBy('order_s','ASC')
            ->orderBy('created_at','ASC');

        $lesson = null;
        foreach ($parentLessons->get() as $parentLesson) {
            $subLessons = Lesson::select('lesson.*')
                ->whereHas('lessonLog', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->with(['lessonLog' => function($q) use ($user){
                    $q->where('user_id', $user->id);
                }])
                ->where('type', Lesson::LESSON)
                ->where('is_exercise', Lesson::IS_EXERCISE)
                ->where('lesson.parent_id', $parentLesson->id)
                ->orderBy('order_s')
                ->orderBy('lesson.created_at', 'ASC')
                ->get();

            foreach ($subLessons as $subLesson){
                if ($subLesson->lessonLog && ($subLesson->lessonLog[0]->count_all == 1 || !$subLesson->lessonLog[0]->count_all)){
                    return $subLesson;
                }

                if (empty($lesson)){
                    $lesson = $subLesson;
                }else{
                    if ($subLesson->lessonLog[0]->count_all < $lesson->lessonLog[0]->count_all){
                        $lesson = $subLesson;
                    }
                }
            }
        }
        return $lesson;
    }

    public function __getWrongQuestions($course, $lesson, $user, $limit = 10)
    {
        $question = UserQuestionLog::where('course_id',$course->id)
            ->where('user_id',$user->id)
            ->where('lesson_id',$lesson->id)
            ->where('status',Question::REPLY_ERROR)
            ->orderBy('create_at','ASC')->get();

        if ($question->count()){
            $questionErrors = $question->pluck('question_parent')->toArray();

            $questions = Question::whereIn('id',$questionErrors)
                ->typeAllow()
                ->where('parent_id', Question::PARENT_ID)->orderBy('order_s','ASC')
                ->orderBy('id','ASC')->take($limit)->get();
            $this->lesson = $lesson;
            $getQuestionDetail = $this->_getQuestion($user, $questions);
            $getQuestionDetail['type'] = Question::LEARN_LAM_CAU_SAI;
            return $getQuestionDetail;
        }

        $getQuestionDetail['type'] = Question::LEARN_LAM_CAU_SAI;
        $getQuestionDetail['questions'] = [];

        return $getQuestionDetail;
    }

    private function getLesson(){
        $lesson = Lesson::findOrFail(request('lesson_id'));
        $this->lesson = $lesson;

        if($lesson->parent_id == Lesson::PARENT_ID){
            $this->lessonIds = Lesson::query()->active()->where('parent_id', request('lesson_id'))->get()->pluck('id')->toArray();
        }

        if (request()->route()->parameter('course') != $this->lesson->course_id){
            throw new BadRequestException('mã bài học không hợp lệ');
        }
    }
}