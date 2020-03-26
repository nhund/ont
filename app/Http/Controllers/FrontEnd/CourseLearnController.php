<?php

namespace App\Http\Controllers\FrontEnd;

use App\Components\Question\QuestionAnswerService;
use App\Components\Recommendation\RecommendationService;
use App\Components\User\UserCourseReportService;
use App\Events\SubmitQuestionEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\CommentCourse;
use App\User;
use Auth;
use App\Models\Rating;
use App\Models\Lesson;
use App\Models\UserCourse;
use App\Models\Question;
use App\Models\UserQuestionLog;
use App\Models\UserLessonLog;
use App\Models\QuestionAnswer;
use App\Models\QuestionCardMuti;
use App\Models\UserQuestionBookmark;
use App\Models\QuestionLogCurrent;
use App\Models\TeacherSupport;
use Illuminate\Support\Facades\DB;

class CourseLearnController extends Controller
{        
    public function checkPermission($user_id,$course_id)
    {
        $course = Course::find($course_id); 
        if(!$course)
        {
            return array(
                'error'=>true,
                'msg'=>'Khóa học không tồn tại',
            );      
        }

        $checkExist = UserCourse::where('user_id',$user_id)->where('course_id',$course_id)->first();
        if(!$checkExist)
        {
            return array(
                'error'=>true,
                'msg'=>'Bạn chưa mua khóa học này',
            );            
        }
            //kiem tra xem trạng thai khoa hoc
        if($checkExist->status == UserCourse::STATUS_APPROVAL)
        {
            return array(
                'error'=>true,
                'msg'=>'Bạn chưa được duyệt để tham gia khóa học này',
            );

        }
            //kiem tra xem trạng thai khoa hoc
        if($checkExist->status == UserCourse::STATUS_OFF)
        {
            return array(
                'error'=>true,
                'msg'=>'Bạn đã bị block khỏi khóa học',
            );           
        }
        if($checkExist->and_date > 0 && $checkExist->and_date < time())
        {
            return array(
                'error'=>true,
                'msg'=>'Khóa học của bạn đã hết hạn. Vui lòng gia hạn để học tiếp',
            );       
        }
        return array(
            'error'=>false,
            'msg'=>'',
        );       
    }

    public function course($title, $id, Request $request)
    {
        $course = Course::find($id);
        if(!$course)
        {
            return redirect()->route('home');
        }
        if(!Auth::check())
        {
            alert()->error('Bạn cần đăng nhập để thực hiện hành động này');
            return redirect()->route('home');
        }
        $user = Auth::user();
        $check_permision = $this->checkPermission($user->id,$id);
        if($check_permision['error'] == true)
        {
            alert()->error($check_permision['msg']);
            return redirect()->route('courseDetail',['title'=>str_slug($title),'id'=>$id]);
        }

        $var['support'] = isset($check_permision['support']) ? $check_permision['support'] : false;
        $var['course'] = $course;
        $lessons = Lesson::where('course_id',$id)->where('parent_id',0)
        ->active()
        ->where('level', '<>', 0)
        ->orderBy('order_s','ASC')
        ->orderBy('created_at','ASC')->get();
        $passLesson = $totalLesson = 0;

        foreach($lessons as $lesson)
        {
            $lesson_childs = Lesson::where('course_id',$id)->where('parent_id',$lesson->id)
            ->orderBy('order_s','ASC')
            ->orderBy('created_at','ASC')->get();
            foreach ($lesson_childs as $key => $lesson_child) {
                $lesson_child->countQuestion = Question::where('lesson_id',$lesson_child->id)->typeAllow()->where('parent_id',0)->count();

                $userLearn =  $lesson_child->userLearn =  UserLessonLog::where('user_id',$user->id)->where('lesson_id',$lesson_child->id)->first();
                $lesson_child->userLearn = $userLearn;

                if($lesson_child->is_exercise == Lesson::IS_EXERCISE){
                    $passQuestions = UserQuestionLog::where('user_id',$user->id)
                        ->active()
                        ->where('lesson_id',$lesson_child->id)
                        ->groupBy('question_parent')
                        ->where('status',Question::REPLY_OK)->get()->count();
                    if($userLearn && $userLearn->turn_right > 0){
                        $passLesson++;
                    }
                    $lesson_child->userLearnPass = $passQuestions;
                }else {
                    //kiem tra xem da hoc ly thuyet chua
                    $lesson_child->lesson_ly_thuyet_pass = empty($userLearn) ? false : true;
                    if(!empty($userLearn)){
                        $passLesson++;
                    }
                }

                if ($lesson_child->type == Lesson::LESSON){
                    $totalLesson++;
                }
            }
            $lesson->childs = $lesson_childs;
            
            if ($lesson->type == Lesson::EXAM){
                $lesson->userExam = $lesson->examUser()->where('user_id', $user->id)->first();
            }
        }
        $var['lessons'] = $lessons;        
        $var['course_same'] = Course::where('status','!=',Course::TYPE_PRIVATE)->orderBy('id','DESC')->take(5)->get();
        $var['passLesson']  = $passLesson;
        $var['totalLesson'] = $totalLesson;

        $var['rating'] = Rating::select('rating_value',DB::raw('count(*) as total'))
            ->where('course_id',$id)
            ->groupBy('rating_value')->get();

        $rating_avg = 0;
        $rating_value = 0;
        $user_rating = 0;
        foreach($var['rating'] as $rating)
        {            
            $rating_value += (int)$rating->total * (int)$rating->rating_value;
            $user_rating += $rating->total;

            $ratingValue[$rating->rating_value] = array(
                'users'=>$rating->total,
                'total'=>(int)$rating->total
            );
        }
        if($rating_value > 0)
        {
            $rating_avg = $rating_value / $user_rating;
        }
        $var['user_rating'] = $user_rating;

        $myRating = Rating::where('user_id', $user->id)
            ->where('course_id',$id)
            ->first();
        $var['my_rating'] = $myRating->rating_value ?? 0;

        $var['rating_avg'] = number_format((float)$rating_avg, 1, '.', '');

        return view('learn.course',compact('var'));
    }

    public function lyThuyet($id,Request $request)
    {
        $var = [];
        if(!Auth::check())
        {
            alert()->error('Bạn cần đăng nhập để thực hiện hành động này');
            return redirect()->route('home');
        }
        $user = Auth::user();
        $lesson = Lesson::find($id);
        $check_permision = $this->checkPermission($user->id,$lesson->course_id);
        if($check_permision['error'] == true)
        {
            alert()->error($check_permision['msg']);
            $course = Course::find($lesson->course_id);
            return redirect()->route('courseDetail',['id'=>$course->id,'title'=>str_slug($course->name)]);
        }

        $var['course'] = Course::find($lesson->course_id);   
        $var['lesson'] = $lesson;


        if ($request->has('lesson_id')){
            $parentLesson =  Lesson::findOrFail($request->get('lesson_id'));
            $var['child'] = route('user.lambaitap.detailLesson',['title'=>str_slug($parentLesson->name),'id'=> $parentLesson->id]);
        }else{
            $var['child'] = route('course.learn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id]);
        }

        return view('learn.lambaitap.lythuyet',compact('var'));
        
    }

    public function lyThuyetSubmit(Request $request)
    {
        $data = $request->all();
        if(!Auth::check())
        {
            return response()->json(array('error' => true, 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này')); 
            //return redirect()->route('home');
        }
        $user = Auth::user();
        if(!isset($data['lesson_id']))
        {
           return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra'));     
        }
        $lesson = Lesson::find($data['lesson_id']);

        $logLesson = UserLessonLog::where('user_id',$user->id)
            ->where('lesson_id',$data['lesson_id'])->first();
        if(!$logLesson)
        {
            $logLesson = new UserLessonLog();
            $logLesson->lesson_id = $data['lesson_id'];
            $logLesson->user_id = $user->id;
            $logLesson->course_id = $lesson->course_id;
            $logLesson->count_question_true = 0;
            $logLesson->create_at = time();
        }

        $logLesson->turn += 1;
        $logLesson->count += 1;
        $logLesson->pass_ly_thuyet = UserLessonLog::PASS_LY_THUYET;
        $logLesson->save();

        return response()->json(array('error' => false, 'msg' => 'success'));
    }

    /**
     * @param $title
     * @param $id
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \App\Exceptions\BadRequestException
     */
    public function question($title, $id ,$type, Request $request)
    {
        if(!Auth::check())
        {
            alert()->error('Bạn cần đăng nhập để thực hiện hành động này');
            return redirect()->route('home');
        }
        $user = Auth::user();
        $var = [];
        $limit = 10;
        $lesson = Lesson::find($id);
        $var['lesson'] = $lesson;
        if(!$lesson)
        {
            alert()->error('Bài học không tồn tại');
            return redirect()->route('home');
        }
        $course = Course::find($lesson->course_id);
        $check_permision = $this->checkPermission($user->id,$lesson->course_id);
        if($check_permision['error'] == true)
        {
            alert()->error($check_permision['msg']);            
            return redirect()->route('courseDetail',['id'=>$course->id,'title'=>str_slug($course->name)]);
        }

        if ($request->has('lesson_id')){
            $var['parentLesson'] =  Lesson::findOrFail($request->get('lesson_id'));
        }

        if($type == Question::LEARN_LAM_BAI_MOI)
        {

            $recommendation = new RecommendationService();

            $getQuestionDetail = $recommendation->doingNewQuestions($course, $user);
            $var['lesson'] = $recommendation->lesson;

        }else{
            if($type == Question::LEARN_LAM_BAI_TAP)
            {
                $listQuestionLearned = [];
                //kiem tra xem dang hoc den dau 
                $questionLearned = QuestionLogCurrent::where('user_id',$user->id)->where('type',$type)->where('course_id',$lesson->course_id)->first();
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
                $questions = Question::where('lesson_id',$id)->typeAllow()->whereNotIn('id',$listQuestionLearned)->where('parent_id',0)
                ->orderBy('order_s','ASC')
                ->orderBy('id','ASC')->take($limit)->get();

            }else{
                $questions = Question::where('lesson_id',$id)->typeAllow()->where('parent_id',0)->take($limit)->get();
            }
            
            $getQuestionDetail = $this->_getQuestion($user, $questions);
        }

        $var['userBookmark'] = $getQuestionDetail['userBookmark'];

        $var['questions'] = $getQuestionDetail['questions'];
        $var['course'] = Course::find($lesson->course_id);   
        $var['type'] = $type;
        if(count($var['questions']) == 0)
        {
            //alert()->error('Bài tập chưa có câu hỏi.');
            return redirect()->route('course.learn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id]);
        } 
        
        return view('learn.lambaitap.layoutQuestion',compact('var'));
        
    }
    
    public function _getQuestion($user, $questions, $notIn = array() , $type = '')
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

    /**
     * @param $title
     * @param $id
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \App\Exceptions\BadRequestException
     */
    public function courseTypeLearn($title, $id , $type, Request $request)
    {
        $recommendation = new RecommendationService();

        if(!Auth::check())
        {
            alert()->error('Bạn cần đăng nhập để thực hiện hành động này');
            return redirect()->route('home');
        }
        $user = Auth::user();
        $course = Course::find($id);
        if(!$course)
        {
            alert()->error('Khóa học không tồn tại');
            return redirect()->route('home');
        }
        $check_permision = $this->checkPermission($user->id,$id);
        if($check_permision['error'] == true)
        {
            alert()->error($check_permision['msg']);
            return redirect()->route('courseDetail',['id'=>$course->id,'title'=>str_slug($course->name)]);
        }

        $var = [];
        $var['course'] = $course;
        $var['type'] = $type;

        if($type == Question::LEARN_LAM_BOOKMARK)
        {
            $bookmarkQuestions = $recommendation->doingBookmarkQuestions($course, $user);
            $var = array_merge($var, $bookmarkQuestions);
            $var['lesson'] = $recommendation->lesson;
        }

        if($type == Question::LEARN_LAM_CAU_SAI)
        {
            $wrongQuestions = $recommendation->doingWrongQuestions($course, $user);

            $var = array_merge($var, $wrongQuestions);
            $countQuestion = count($var['questions']);
            $var['lesson'] = $recommendation->lesson;
            if($countQuestion == 0)
            {
                return redirect()->route('course.learn',['id'=>$course->id,'title'=>str_slug($course->name)]);
            }

        }

        if($type == Question::LEARN_LAM_BAI_MOI)
        {
            $recommendation = new RecommendationService();

            $getQuestionDetail = $recommendation->doingNewQuestions($course, $user);

            if ($getQuestionDetail['type'] == 'theory'){
                return redirect()->route('user.lambaitap.lythuyet',['id'=>$getQuestionDetail['lesson']->id]);
            }
            if ($getQuestionDetail['type'] == Lesson::EXAM){
                return redirect()->route('exam.start',['title' => $getQuestionDetail['lesson']->name, 'id'=>$getQuestionDetail['lesson']->id]);
            }
            $var = array_merge($var, $getQuestionDetail);
            $var['lesson'] = $recommendation->lesson;

        }

        if($type == Question::LEARN_LAM_CAU_CU)
        {
            $replyQuestions = $recommendation->doingReplayQuestions($course, $user);
            $var = array_merge($var, $replyQuestions);
            $var['lesson'] = $recommendation->lesson;

        }

        $countQuestion = count($var['questions']);

        if($countQuestion == 0)
        {
            alert()->error('Hiện tại đã hết bài tập mới.');
            return redirect()->route('course.learn',['id'=>$course->id,'title'=>str_slug($course->name)]);
        }

        $var['lastRound']  = $countQuestion < 10 && $type != Question::LEARN_LAM_CAU_SAI ? true : false;
        $var['count_question'] = $countQuestion;

        return view('learn.lambaitap.layoutQuestion',compact('var'));
    }

    public function questionSubmit(Request $request)
    {
        $question = Question::findOrFail($request->get('id'));

        $this->authorize('submit', $question);

        $submitService = new QuestionAnswerService();
        $result = $submitService->submit($request, $question);

        return $this->message('gửi câu hỏi thành công')->respondOk($result);
    }

    protected function _saveLogQuestion($user, $data)
    {
        if($data['type'] == Question::LEARN_LAM_BOOKMARK)
        {
            $questionlearnedIds = [];
            $questionLearned = QuestionLogCurrent::where('user_id',$user->id)->where('course_id',$data['course_id'])->where('type',$data['type'])->first();
            if($questionLearned)
            {
                $questionlearnedIds = json_decode($questionLearned->content,true);
                if(!in_array($data['question_parent'],$questionlearnedIds))
                {
                    array_push($questionlearnedIds, $data['question_parent']);
                    //lay tat ca cac cau bookmark
                    $questionLogs = UserQuestionBookmark::where('user_id',$user->id)->where('course_id',$data['course_id'])->count();
                    if($questionLogs == count($questionlearnedIds))
                    {
                        $questionlearnedIds = [];
                    }    
                    $questionLearned->content = json_encode($questionlearnedIds);
                    $questionLearned->save();
                }

            }else{

                array_push($questionlearnedIds, $data['question_parent']);                
                $questionLearned = new QuestionLogCurrent();
                $questionLearned->user_id = $user->id;
                $questionLearned->course_id = $data['course_id'];
                $questionLearned->content = json_encode($questionlearnedIds);
                $questionLearned->type = $data['type'];
                $questionLearned->create_date = time();
                $questionLearned->update_date = time();
                $questionLearned->save();
            }
            return true;
        }
        if($data['type'] == Question::LEARN_LAM_BAI_TAP)
        {
            $questionlearnedIds = [];
            $questionLearned = QuestionLogCurrent::where('user_id',$user->id)->where('course_id',$data['course_id'])->where('type',$data['type'])->first();
            if($questionLearned)
            {
                $questionlearnedIds = json_decode($questionLearned->content,true);
                if(isset($questionlearnedIds[$data['lesson_id']]))
                {
                    if(!in_array($data['question_parent'],$questionlearnedIds[$data['lesson_id']]))
                    {
                        array_push($questionlearnedIds[$data['lesson_id']], $data['question_parent']);
                    }
                }else{

                    $questionlearnedIds[$data['lesson_id']] = [$data['question_parent']];                    
                }
                //lay tat ca cau hoi cua lesson
                $lesson_questions = Question::where('lesson_id',$data['lesson_id'])->where('course_id',$data['course_id'])->where('parent_id',0)->count();

                if($lesson_questions == count($questionlearnedIds[$data['lesson_id']]))
                {
                    // neu so cau da lam xong thi reset log
                    $questionlearnedIds[$data['lesson_id']] = [];
                }
                $questionLearned->content = json_encode($questionlearnedIds);
                $questionLearned->save();

            }else{
                //$lesson_current = 
                $lesson_questions = Question::where('lesson_id',$data['lesson_id'])->where('course_id',$data['course_id'])->where('parent_id',0)->count();
                if($lesson_questions > 1 )
                {
                    $questionlearnedIds[$data['lesson_id']] = [$data['question_parent']];
                    //array_push($questionlearnedIds, $data['question_parent']);                
                    $questionLearned = new QuestionLogCurrent();
                    $questionLearned->user_id = $user->id;
                    $questionLearned->course_id = $data['course_id'];
                    $questionLearned->content = json_encode($questionlearnedIds);
                    $questionLearned->type = $data['type'];
                    $questionLearned->create_date = time();
                    $questionLearned->update_date = time();
                    $questionLearned->save();    
                }
                
            }

        }

        $questionLog = UserQuestionLog::where('user_id',$user->id)->active()->where('question_id',$data['question_id'])->first();
        if($questionLog)
        {
            $questionLog->status = $data['status'];
            $questionLog->update_time = time();
            $questionLog->is_ontap = $data['type'] == Question::LEARN_LAM_CAU_CU ? UserQuestionLog::TYPE_ON_TAP : 0;

            $questionLog->total_turn += 1;
            if ($data['status'] == Question::REPLY_OK){
                $questionLog->correct_number += 1;
            }

            $questionLog->save();

        }else{
            $questionLog = new UserQuestionLog();
            $questionLog->user_id = $user->id;
            $questionLog->course_id = $data['course_id'];
            $questionLog->lesson_id = $data['lesson_id'];
            $questionLog->question_id = $data['question_id'];
            $questionLog->question_parent = $data['question_parent'];
            $questionLog->note = $data['note'];
            $questionLog->status = (int)$data['status'];
            $questionLog->create_at = time();
            $questionLog->is_ontap = $data['type'] == Question::LEARN_LAM_CAU_CU ? UserQuestionLog::TYPE_ON_TAP : 0;
            $questionLog->update_time = time();

            $questionLog->total_turn += 1;
            if ($data['status'] == Question::REPLY_OK){
                $questionLog->correct_number += 1;
            }

            $questionLog->save();
        }
        //ghi log neu dang lam on tap
        if($data['type'] == Question::LEARN_LAM_CAU_CU)
        {
            $questionlearnedIds = [];
            $questionLearned = QuestionLogCurrent::where('user_id',$user->id)->where('course_id',$data['course_id'])->where('type',$data['type'])->first();
            if($questionLearned)
            {
                $questionlearnedIds = json_decode($questionLearned->content,true);
                if(!in_array($data['question_parent'],$questionlearnedIds))
                {
                    array_push($questionlearnedIds, $data['question_parent']);
                    //lay tat ca cac cau hoi da lam 
                    $questionLogs = UserQuestionLog::where('course_id',$data['course_id'])
                        ->active()
                        ->where('user_id',$user->id)                        
                        ->groupBy('question_parent')->get()->count();
                    if($questionLogs == count($questionlearnedIds))
                    {
                        // neu so cau da lam xong thi reset log
                        $questionlearnedIds = [];
                    }    
                    $questionLearned->content = json_encode($questionlearnedIds);
                    $questionLearned->save();
                }

            }else{

                array_push($questionlearnedIds, $data['question_parent']);                
                $questionLearned = new QuestionLogCurrent();
                $questionLearned->user_id = $user->id;
                $questionLearned->course_id = $data['course_id'];
                $questionLearned->content = json_encode($questionlearnedIds);
                $questionLearned->type = $data['type'];
                $questionLearned->create_date = time();
                $questionLearned->update_date = time();
                $questionLearned->save();
            }
        }

        $up_question_true = false;
        //tong so cau hoi cua lesson
        $lesson_questions = Question::where('lesson_id',$data['lesson_id'])->where('parent_id',0)->count();
        if($data['question_type'] == Question::TYPE_FLASH_SINGLE || $data['question_type'] == Question::TYPE_FLASH_MUTI)
        {
          if((int)$data['status'] == QuestionAnswer::REPLY_OK)
          {
            $up_question_true = true;
          }  
        }
        // if($data['question_type'] == Question::TYPE_DIEN_TU || $data['question_type'] == Question::TYPE_TRAC_NGHIEM)
        else
        {
            $count_question_child = Question::where('parent_id',$data['question_parent'])->count();
            //kiem tra xem da lam dung bn cau
            $count_question_true = UserQuestionLog::where('question_parent',$data['question_parent'])->where('lesson_id',$data['lesson_id'])->where('user_id',$user->id)->where('status',QuestionAnswer::REPLY_OK)->count();
            if($count_question_child == $count_question_true && $count_question_true > 0)
            {

                $up_question_true = true;
            }
        }
    $lesson_log = UserLessonLog::where('user_id',$user->id)->where('lesson_id',$data['lesson_id'])->first();
    if($lesson_log)
    {
        if($up_question_true)
        {
            // tang so cau tra loi dung
            $lesson_log->count_question_true += 1;
            $lesson_log->save();
            //dem so cau tra loi dung cua user trong lesson
            $countUserLearnPass = UserQuestionLog::where('user_id',$user->id)->active()->where('lesson_id',$data['lesson_id'])->where('status',QuestionAnswer::REPLY_OK)->count();
            if($countUserLearnPass >= $lesson_questions)
            {
                // lam dung het tat ca cau hoi. reset tong so cau tra loi dung
                // tang luot lam len
                //$lesson_log->count_question_true = 0;
                $lesson_log->count += 1;
                $lesson_log->save();
            }
        }
        // xem user lam het luot chua
        $userQuestionLog = UserQuestionLog::where('lesson_id',$data['lesson_id'])->active()->where('user_id',$user->id)->count();
        if($userQuestionLog >= $lesson_questions)
        {
            //$lesson_log->count_all += 1;
            //$lesson_log->save();    
        }        
    }else{
        $lesson_log = new UserLessonLog();
        $lesson_log->user_id = $user->id;
        $lesson_log->course_id = $data['course_id'];
        $lesson_log->lesson_id = $data['lesson_id'];
        $lesson_log->count = 1;
        $lesson_log->count_all = 1;
        $lesson_log->create_at = time();
        $lesson_log->count_question_true = $up_question_true == true ? 1 : 0;
        $lesson_log->save();
    }

    event(new SubmitQuestionEvent($data['question_parent'], $user));
}

    public function getExplain(Request $request)
{
    $data = $request->all();
    if(!Auth::check())
    {
        return response()->json(array('error' => true, 'action'=>'login','msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
    }
    $user = Auth::user();
    $explain = Question::find($data['id']);
    if($explain)
    {
        return response()->json(array('error' => false, 'msg' => 'succsess','data'=>$explain->explain_before));
    }
    return response()->json(array('error' => true, 'msg' => 'error'));
}

    public function lessonLevel2($title,$courseId,Request $request)
    {
        $data = $request->all();
        $course = Course::find($courseId);
        if(!$course)
        {
            return redirect()->route('home');
        }
        if(!Auth::check())
        {
            alert()->error('Bạn cần đăng nhập để thực hiện hành động này');
            return redirect()->route('home');
        }
        $user = Auth::user();
        $check_permision = $this->checkPermission($user->id,$courseId);
        if($check_permision['error'] == true)
        {
            alert()->error($check_permision['msg']);
            return redirect()->route('courseDetail',['title'=>str_slug($title),'id'=>$courseId]);
        }

        $var['support'] = isset($check_permision['support']) ? $check_permision['support'] : false;
        $var['course'] = $course;
        $lessons = Lesson::where('course_id',$courseId)
            ->where('parent_id',$request->get('lesson_id'))
            ->orderBy('order_s','ASC')
            ->orderBy('created_at','ASC')->get();

        $total_question = 0;
        $total_user_learn = 0;
        $show_on_tap = false;

        foreach($lessons as $lesson)
        {
            $lesson_childs = Lesson::where('course_id',$courseId)->where('parent_id',$lesson->id)
                ->orderBy('order_s','ASC')
                ->orderBy('created_at','ASC')->get();
            foreach ($lesson_childs as $key => $lesson_child) {
                $question_child = Question::where('lesson_id',$lesson_child->id)->where('parent_id',0)->get();
                $countQuestion = $question_child->count();
                //dd($question_child->pluck('id')->toArray());
                $userLearn = UserQuestionLog::where('user_id',$user->id)->active()->where('lesson_id',$lesson_child->id)->groupBy('question_parent')->get();
                //lay log lesson
                $userLessonLog = UserLessonLog::where('user_id',$user->id)->where('lesson_id',$lesson_child->id)->first();
                if($userLessonLog)
                {
                    if($userLessonLog->count > 1)
                    {
                        $show_on_tap = true;
                    }
                }
                $countLearnError = $userLearn->where('status',Question::REPLY_ERROR)->count();
                $countLearnTrue = count($userLearn) - $countLearnError;
                $lesson_child->countQuestion = $countQuestion;
                $lesson_child->userLearn = $userLessonLog;
                $lesson_child->userLearnPass = UserQuestionLog::where('user_id',$user->id)->active()->where('lesson_id',$lesson_child->id)->where('status',QuestionAnswer::REPLY_OK)->count();
                $total_question += $countQuestion;
                $total_user_learn += $countLearnTrue;
                //kiem tra xem da hoc ly thuyet chua
                $lesson_child->lesson_ly_thuyet_pass = UserLessonLog::where('user_id',$user->id)->where('course_id',$courseId)->where('lesson_id',$lesson_child->id)->first();
            }
            $lesson->childs = $lesson_childs;
        }

        $var['lessons'] = $lessons;
        $var['course_same'] = Course::where('status','!=',Course::TYPE_PRIVATE)->orderBy('id','DESC')->take(5)->get();
        $var['total_question'] = $total_question;
        $var['total_user_learn'] = $total_user_learn;
        //count so cau bookmark
        $var['user_learn_bookmark'] = UserQuestionBookmark::where('user_id',$user->id)
            ->where('course_id',$courseId)->count();

        //lay tat ca cau sau cua user
        $questionErrors = UserQuestionLog::where('course_id',$courseId)
            ->active()
            ->where('user_id',$user->id)
            ->where('status',Question::REPLY_ERROR)
            ->groupBy('question_parent')->get()
            ->pluck('question_parent')->toArray();

        $var['user_learn_error'] = Question::whereIn('id',$questionErrors)->count();

        $var['show_on_tap'] = $show_on_tap;

        $var['rating'] = Rating::select('rating_value',DB::raw('count(*) as total'))->where('course_id',$courseId)->groupBy('rating_value')->get();

        $rating_avg = 0;
        $rating_value = 0;
        $user_rating = 0;
        foreach($var['rating'] as $rating)
        {
            $rating_value += (int)$rating->total * (int)$rating->rating_value;
            $user_rating += $rating->total;

            $ratingValue[$rating->rating_value] = array(
                'users'=>$rating->total,
                'total'=>(int)$rating->total
            );
        }
        if($rating_value > 0)
        {
            $rating_avg = $rating_value / $user_rating;
        }
        $var['user_rating'] = $user_rating;
        $var['rating_avg'] = number_format((float)$rating_avg, 1, '.', '');
        $myRating = Rating::where('user_id', $user->id)->first();
        $var['my_rating'] = $myRating->rating_value ?? 0;
        return view('learn.course_l2',compact('var'));
    }

    /**
     * @param $title
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailLesson($title, $id, Request $request)
    {
        $lessons            = Lesson::findOrFail($id);
        $var['lessons']     = $lessons;
        $course             = Course::findOrFail($lessons->course_id);
        $var['course']      = $course;
        $var['course_same'] = Course::where('status', '!=', Course::TYPE_PRIVATE)->orderBy('id', 'DESC')->take(5)->get();

        if (!Auth::check()) {
            alert()->error('Bạn cần đăng nhập để thực hiện hành động này');
            return redirect()->route('home');
        }
        $user = Auth::user();

        $check_permision = $this->checkPermission($user->id, $course->id);
        if ($check_permision['error'] == true) {
            alert()->error($check_permision['msg']);
            return redirect()->route('courseDetail', ['title' => str_slug($title), 'id' => $course->id]);
        }

        $var['support'] = isset($check_permision['support']) ? $check_permision['support'] : false;
        $var['rating']  = Rating::select('rating_value', DB::raw('count(*) as total'))
            ->where('course_id', $course->id)->groupBy('rating_value')->get();

        $rating_avg   = 0;
        $rating_value = 0;
        $user_rating  = 0;
        foreach ($var['rating'] as $rating) {
            $rating_value += (int)$rating->total * (int)$rating->rating_value;
            $user_rating  += $rating->total;

            $ratingValue[$rating->rating_value] = array(
                'users' => $rating->total,
                'total' => (int)$rating->total
            );
        }
        if($rating_value > 0)
        {
            $rating_avg = $rating_value / $user_rating;
        }
        $var['subLessons'] = $var['lessons']->subLesson ?: [];

        $totalLesson   = 0;
        $passLesson = 0;

        foreach ($var['subLessons'] as $key => $lesson_child) {
            $question_child = Question::where('lesson_id', $lesson_child->id)->where('parent_id', 0)->get();
            $countQuestion  = $question_child->count();

            //lay log lesson
            $userLessonLog = UserLessonLog::where('user_id', $user->id)->where('lesson_id', $lesson_child->id)->first();
            $lesson_child->userLearn     = $userLessonLog;

            if ($lesson_child->is_exercise == Lesson::IS_EXERCISE){
                $lesson_child->countQuestion = $countQuestion;
                $lesson_child->userLearnPass = UserQuestionLog::where('user_id', $user->id)
                    ->active()
                    ->where('lesson_id', $lesson_child->id)
                    ->where('status', QuestionAnswer::REPLY_OK)->count();

                if($userLessonLog && $userLessonLog->turn_right > 0){
                    $passLesson++;
                }
            } else{
                //kiem tra xem da hoc ly thuyet chua
                $lesson_child->lesson_ly_thuyet_pass = empty($userLessonLog) ? false : true;
                if(!empty($userLessonLog)){
                    $passLesson++;
                }
            }

            if ($lesson_child->type == Lesson::LESSON){
                $totalLesson++;
            }
        }

        $var['totalLesson']= $totalLesson;
        $var['passLesson'] = $passLesson;

        $var['user_rating'] = $user_rating;
        $var['rating_avg']  = number_format((float)$rating_avg, 1, '.', '');
        $myRating = Rating::where('user_id', $user->id)->first();
        $var['my_rating'] = $myRating->rating_value ?? 0;

        return view('learn.detailLesson',compact('var'));
    }
}
