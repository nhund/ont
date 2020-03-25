<?php

namespace App\Http\Controllers\BackEnd;

use App\Components\Course\CourseService;
use App\Events\RefundCourseEvent;
use App\Exceptions\UserCourseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddExamRequest;
use App\Models\Category;
use App\Models\CommentCourse;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\UserCourse;
use App\Models\Wallet;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Models\Feedback;
use App\Models\UserQuestionLog;
use App\Models\UserLessonLog;
use App\Models\Question;
use App\Models\Rating;
use App\Models\TeacherSupport;
use Illuminate\Support\Facades\DB;

class CourseController extends AdminBaseController
{
    private function checkPermission($id) {
        if (!$id || !$course = Course::find($id)) {
            return false;
        }
        //check support
        $course_support = TeacherSupport::where('course_id',$id)->where('user_id',Auth::user()['id'])->first();

        if ($course['user_id'] != Auth::user()['id'] && Auth::user()['level'] != User::USER_ADMIN && !$course_support) {
            return false;
        }
        return $course;
    }

    public function addCourse()
    {
        $var['page_title'] = 'Tạo khóa học';
        $var['category']   = Category::all()->keyBy('id');
        return view('backend.course.handle', $var);
    }

    public function editCourse($id)
    {
        

        $course = $this->checkPermission($id);
        $check_support = TeacherSupport::where('course_id',$id)->where('user_id',Auth::user()->id)->first();
        if($check_support)
        {
            return redirect()->route('course.detail',['id'=>$id]);
            //neu la tro giang thì chay den trang chi tiet khoa hoc
            
        }
        $var['page_title'] = 'Chỉnh sửa khóa học';
        $var['category']   = Category::all()->keyBy('id');
        $var['course']     = $course;
        return view('backend.course.handle', $var);
    }

    public function handle(Request $request)
    {
        $id             = trim($request->input('id', 0));
        $name           = trim($request->input('name', ''));
        $price          = str_replace('.', '', $request->input('price', 0));
        $discount       = str_replace('.', '', $request->input('discount', 0));
        $is_free        = $request->input('is_free', 0);
        $category_id    = $request->input('category_id', 0);
        $description    = trim($request->input('description', ''));
        $study_time     = $request->input('study_time', '');
        $status         = $request->input('status', 1);
        $image         = $request->file('avatar');

        $hasError       = false;
        if($status == Course::TYPE_PUBLIC || $status == Course::TYPE_APPROVAL || $status == Course::TYPE_FREE_TIME)
        {
            if((int)$study_time == 0 || (int)$study_time < 1)
            {
                alert()->error('Có lỗi','Bạn cần nhập số ngày học');
                return redirect()->route('addcourse');
            }
        }
        if (!$id) {
            $course = new Course();
            $course->updated_at = time();
            $course->created_at = time();
            $course->user_id    = Auth::user()['id'];
        } else {
            $course = Course::find($id);
            $course->updated_at = time();
        }

        $course->name           = $name;
        $course->description    = $description;
        $course->is_free        = $is_free;
        $course->price      = empty($price) ? 0 : $price;
        $course->discount   = empty($discount) ? 0 : $discount;
        // if ($price) {
        //     $course->price      = $is_free ? 0 : $price;
        // }
        // if ($discount) {
        //     $course->discount   = $is_free ? 0 : $discount;
        // }
        $course->category_id    = $category_id;
        $course->study_time     = $study_time;
        $course->status         = $status;
    
        $course->save();
        //tao fordel anh
        $path = '/images/course/'.$course->id;
        $destinationPath = public_path($path);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777);
        }
        $path = '/images/course/'.$course->id.'/lesson';
        $destinationPath = public_path($path);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777);
        } 
        $path = '/images/course/'.$course->id.'/lesson/audio';
        $destinationPath = public_path($path);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777);
        }
        
        // if have image
        if ($image) {
            if (!in_array($image->clientExtension(), ['jpeg','png','jpg','gif','svg', 'webp'])) {
                $hasError   = true;
            }
            if ($image->getClientSize() > 2048000) {
                $hasError   = true;
            }
            if (!$hasError) {
                // if ($course->avatar && file_exists('public/images/course/'.$course->avatar)) {
                //     unlink('public/images/course/'.$course->avatar);
                // }
                // $destinationPath = public_path('/images/course');
                // $imgName         = str_replace('.'.$avatar->getClientOriginalExtension(),'', $avatar->getClientOriginalName()).time().'.'.$avatar->getClientOriginalExtension();
                // $avatar->move($destinationPath, $imgName);
                // $course->avatar  = $imgName;

                $name = time().'_'.str_slug($image->getClientOriginalName()).'.'.$image->getClientOriginalExtension();
                $path = '/images/course/'.$course->id;
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $image->move($destinationPath, $name);
                $avatar = 'public/images/course/'.$course->id.'/'.$name;
                // $user->avatar_path = $path;
                // $user->avatar_name = $name;
                //dd($destinationPath);
                $course->avatar  = $name;
                $course->avatar_path  = $path;
                if($course->save())
                {

                    Helper::thumbImages($name,$avatar,480,320,'fit',$destinationPath.'/480_320');                    
                }
            }
        }
        return redirect()->route('course.detail', ['id'=> $course->id]);
    }

    public function detail($id) {
        $course = $this->checkPermission($id);
        if (!$course) {
            return redirect()->route('dashboard');
        }
        $limit = 50;
        $var['breadcrumb']['breadcrumb'] = array(
            array(
                'url'=> route('course.detail',['id'=>$course['id']]),
                'title' => $course['name'],
            )
        ); 
        $var['page_title']      = 'Chi tiết khóa học '.$course->name;
        $var['course']          = $course;
        $var['course_lesson']   = Lesson::getCourseLesson($id);
        $comments = CommentCourse::where('course_id',$id)->where('parent_id',0)->orderBy('created_at','DESC')->paginate($limit);
        if(count($comments) > 0)
        {
            foreach($comments as $comment)
            {
                $comment->comment_childs = CommentCourse::where('course_id',$id)->where('parent_id',$comment->id)->get();    
            }
        }
        $var['comments'] = $comments;
        $var['feedbacks'] = Feedback::where('course_id',$id)
            ->with(['bookmark' => function ($q){
                $q->where('user_id', Auth::user()->id);
            }])->groupBy('question_id')
            ->orderBy('id','DESC')
            ->paginate(15);

        $var['rating'] = Rating::select('rating_value',DB::raw('count(*) as total'))->where('course_id',$id)->groupBy('rating_value')->get();
        $ratingValue = array('1'=>0, '2'=>0, '3'=>0, '4'=>0, '5'=>0,);
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
        $var['rating_value'] = $ratingValue;
        
        $var['rates'] = Rating::where('course_id',$id)->orderBy('id','DESC')->get();
        //dd($var);
        return view('backend.course.detail', compact('var'));
    }

    public function feedback($id) {
        $course = $this->checkPermission($id);
        if (!$course) {
            return redirect()->route('dashboard');
        }
        $var['page_title']      = 'Chi tiết phản hồi khóa học '.$course->name;
        $var['course']          = $course;
        $comments = CommentCourse::where('course_id',$id)->where('parent_id',0)->orderBy('created_at','DESC')->paginate(20);
        if(count($comments) > 0)
        {
            foreach($comments as $comment)
            {
                $comment->comment_childs = CommentCourse::where('course_id',$id)->where('parent_id',$comment->id)->get();
            }
        }
        $var['comments'] = $comments;
        return view('backend.course.feedback', $var);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addLesson(Request $request) {
        $course_id      = $request->input('course_id');
        $name           = $request->input('name');
        $status         = $request->input('status');
        $lesson_id      = $request->input('lesson_id');
        $level      = $request->input('level', 1);
        $lesson         = Lesson::find($lesson_id);
        $firstId        = 0;
        if (is_array($name) && $name) {
            foreach ($name as $k=>$val) {
                $insertData = [
                    'name'          => $val,
                    'status'        => $status[$k],
                    'course_id'     => $course_id,
                    'parent_id'     => $lesson_id ? $lesson_id : 0,
                    'lv1'           => 0,
                    'created_at'    => time(),
                    'type'          => Course::LESSON,
                    'level'         => $level,
                ];

                if ($lesson) {
                    $insertData['lv1'] = $lesson['lv1'] ?: $lesson_id;

                    if ($lesson['lv1'] && $lesson['lv2'])
                    {
                        $insertData['lv2'] = $lesson['lv2'];
                        $insertData['lv3'] = $lesson_id;
                    }
                }
                if (!$firstId) {
                    $firstId = Lesson::insertGetId($insertData);
                } else {
                    Lesson::insert($insertData);
                }

                (new CourseService())->createFolderGalaryForLesson($course_id);

            }
        }

        return response()->json(['msg' => 'Thêm bài giảng thành công', 'status' => 1, 'id' => $firstId]);
    }

    public function addExam(AddExamRequest $request)
    {
        $params    = $request->only('course_id', 'name', 'status', 'lesson_id');
        $lesson_id = Arr::get($params, 'lesson_id');

        $lesson     = Lesson::find($lesson_id);

        $insertData = [
            'name' => $params['name'],
            'status' => $params['status'],
            'course_id' => $params['course_id'],
            'parent_id' => $lesson_id ? $lesson_id : 0,
            'lv1' => 0,
            'created_at' => time(),
            'type' => Course::EXAM,
        ];

        if ($lesson)
        {
            $insertData['lv1'] = $lesson['lv1'] ? $lesson['lv1'] : $lesson_id;
            if ($lesson['lv1']) {
                $insertData['lv2'] = $lesson_id;
            }
        }

        $firstId = Lesson::insertGetId($insertData);

        (new CourseService())->createFolderGalaryForLesson($params['course_id']);

        return response()->json(['msg' => 'Thêm bài kiểm tra thành công', 'status' => 1, 'id' => $firstId]);
    }

    public function addLevel2(AddExamRequest $request)
    {
        $insertData = [
            'name'          => $request->get('name'),
            'status'        => $request->get('status'),
            'course_id'     => $request->get('course_id'),
            'parent_id'     => Lesson::PARENT_ID,
            'lv1'           => Lesson::PARENT_ID,
            'level'         => 2,
            'is_exercise'   => null,
            'created_at'    => time(),
            'type'          => Course::LESSON,
        ];

        $id = Lesson::insertGetId($insertData);

        return response()->json(['msg' => 'Thêm bài giảng cấp 2 thành công', 'status' => 1, 'id' => $id]);
    }

    public function listUser($id) {

        
        $course             = $this->checkPermission($id);
        if (!$course) {
            return redirect()->route('dashboard');
        }

        $var['page_title']  = 'Thành viên khóa học '.$course['name'];
        $var['breadcrumb']['breadcrumb'] = array(
            array(
                'url'=> route('course.detail',['id'=>$course['id']]),
                'title' => $course['name'],
            ),
            array(
                'url'=> '',
                'title' => 'Thành viên khóa học',
            )
        );
        $from_time  = Request::capture()->input('from_time', 0);
        $to_time    = Request::capture()->input('to_time',0);
        $user_search       = trim(Request::capture()->input('user_search'));
        $status = Request::capture()->input('status');
        //dd($status);

        $query = UserCourse::where('course_id', '=', $id);
        $query->join('users', function($join) {
            $join->on('users.id', '=', 'user_course.user_id');
        });
        if ($from_time) {
            $var['from_time']   = $from_time;
            $query->where('user_course.created_at', '>=', strtotime($from_time));
        }
        if ($to_time) {
            $var['to_time']     = $to_time;
            $query->where('user_course.created_at', '<=', strtotime($to_time));
        }
        if(!empty($status))
        {
            $query->where('user_course.status',(int)$status);
            $var['status'] = $status;
        }
        if ($user_search) {
            $query->where(function($q) use ($user_search) {
                $q->where('users.name', 'LIKE',  '%'.$user_search.'%')
                    ->orWhere('users.email', 'LIKE', '%'.$user_search.'%');
            });
            $var['user_search'] = $user_search;
        }
        $course_lesson = Lesson::where('course_id',$id)
        ->where('is_exercise',Lesson::IS_EXERCISE)
        ->pluck('id')->toArray();        
        $course_questions = Question::whereIn('lesson_id',$course_lesson)->where('parent_id',0)->count();
        $var['course_lessons'] = $course_lesson;
        $var['course_questions'] = $course_questions;

        $users   = $query->select('users.*', 'user_course.created_at','user_course.status AS user_course_status')
            ->orderBy('created_at', 'DESC')->paginate(20);
        foreach($users as $user)
        {
            //kiem tra ngay hoc gan nhat\
            $user->learn_last_time = UserQuestionLog::where('user_id',$user->id)->active()->where('course_id',$id)->orderBy('update_time','DESC')->first();
            //kiem tra xem user lam tat ca bao nhieu cau
            $user->userLearn = UserQuestionLog::where('user_id',$user->id)->active()->where('course_id',$id)->groupBy('question_parent')->get()->count();
            //kiem tra xem user lam dung bao nhieu cau
            $user->userLearn_true = UserQuestionLog::where('user_id',$user->id)->active()->where('course_id',$id)->where('status',Question::REPLY_OK)->groupBy('question_parent')->get()->count();
            //kiem tra luot lam cua user
            $user_lesson = UserLessonLog::where('user_id',$user->id)->where('course_id',$id)->get();
            //kiem tra luot lam cao nhat
            $user->learn_lesson_max = $user_lesson->max('count');
            $user->learn_lesson_min = $user_lesson->min('count');
            $user->learn_lesson_avg = $user_lesson->avg('count');
            //lay tat ca luot lam cua user theo lesson
            $user->user_lesson_all = UserLessonLog::where('user_id',$user->id)->where('course_id',$id)->whereIn('lesson_id',$course_lesson)->get()->keyBy('lesson_id');
            //dd($user->user_lesson_all);
        }
        //dd($users);    
        
        $var['users'] = $users;  
        $var['course']      = $course;
        return view('backend.course.user.listUser', $var);
    }

    public function changeUserStatus(Request $request) {
        $course_id  = $request->input('course_id', 0);
        $val        = $request->input('val', 0);
        $id         = $request->input('id', 0);

        $course = Course::find($course_id);
        if (!$course) {
            return response()->json(['status' => 0, 'msg' => 'Khóa học không tồn tại']);
        }
        if (Auth::user()['level'] != 6 && Auth::user()['id'] != $course->user_id) {
            return response()->json(['status' => 0, 'msg' => 'Bạn không có quyền thực hiện chức năng này']);
        }
        UserCourse::where('user_id', '=', $id)->where('course_id', '=', $course_id)->update(['status' => $val]);
        return response()->json(['status' => 1, 'msg' => 'Chuyển trạng thái thành công']);
    }

    public function addUser(Request $request) {
        $email      = $request->input('email', 0);
        $course_id  = $request->input('course_id', 0);

        $user = User::where('email', '=', $email)->first();
        if (!$user) {
            return response()->json(['status' => 0, 'msg' => 'Thành viên không tồn tại']);
        }
        $check = UserCourse::where('user_id', '=', $user->id)->where('course_id', '=', $course_id)->first();
        if ($check) {
            return response()->json(['status' => 0, 'msg' => 'Thành viên đã tham gia khóa học']);
        } else {
            UserCourse::insert([
                'user_id'       => $user->id,
                'course_id'     => $course_id,
                'created_at'    => time(),
                'status'        => 1
            ]);
            return response()->json(['status' => 1, 'msg' => 'Thêm thành viên thành công']);
        }
    }
    public function listCourse(Request $request)
    {
        $data = $request->all();
        $params  = [];
        if(!empty($data['created_at']) || !empty($data['name']) || !empty($data['user_id']) || !empty($data['category_id']))
        {
            $params = $data;
            //dd($params);
        }
        $params['sortBy'] = 'created-descending';

        $courses = Course::Filter($params);
        $var['courses'] = $courses;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.course.index'),
                'title' => 'Danh sách khóa học',
            ),
        );
        $var['params'] = $params;
        return view('backend.course.index',compact('var'));
    }
    public function delete(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $course = Course::find($data['id']);
        if(!$course)
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        //$avatar = $partner->img;        
        if($course->delete())
        {
            //Helper::removeFolder(public_path($avatar));
            //Helper::removeFolder(public_path($avatar_thumb));
            return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
        }
        return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
    }
    /**
     * duyet user vao khoa hoc can xet duyet
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function userApproval(Request $request)
    {
        $data = $request->all();
        if(!isset($data['course_id']) || !isset($data['ids']))
        {
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra, vui lòng thử lại sau'));
        }
        $course = Course::find($data['course_id']);
        if (!$course) {
            return response()->json(['status' => 0, 'msg' => 'Khóa học không tồn tại']);
        }
        //kiem tra xem khoa hoc co phai can duyet ko
        if($course->status != Course::TYPE_APPROVAL)
        {
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra, khóa học này không cần xét duyệt'));
        }
        UserCourse::whereIn('id',$data['ids'])->update(['status'=>UserCourse::STATUS_ON]);        
        return response()->json(array('error' => false, 'msg' => 'Cập nhật thành công'));
    }
    /**
     * update khoa hoc noi bat
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function changeSticky(Request $request)
    {
        $data = $request->all();
        if(!isset($data['course_id']) || !isset($data['sticky']))
        {
            return response()->json(array('error' => true, 'msg' => 'Có lỗi xẩy ra, vui lòng thử lại sau'));
        }
        $course = Course::find($data['course_id']);
        if (!$course) {
            return response()->json(['error' => true,'status' => 0, 'msg' => 'Khóa học không tồn tại']);
        }
        if((int)$data['sticky'] == 1)
        {
            $course->sticky = Course::STICKY;
        }else{
            $course->sticky = Course::NOT_STICKY;
        }
        if($course->save())
        {
            return response()->json(array('error' => false, 'msg' => 'Cập nhật thành công'));
        }else{
            return response()->json(array('error' => true, 'msg' => 'Cập nhật không thành công'));
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws UserCourseException
     * @throws \Throwable
     */
    public function refund(Request $request)
    {
        $data = $request->only(['user_id', 'course_id']);

        $userCourse = UserCourse::where([
            'user_id' => $data['user_id'],
            'course_id' => $data['course_id']
        ])->firstOrFail();

        //check wallet
        $wallet = Wallet::where('user_id',$data['user_id'])->first();
        if(!$wallet) {
            throw new UserCourseException('Bạn chưa có xu để mua khóa học.');
        }

        $course = Course::findOrFail($data['course_id']);

        DB::transaction(function () use ($wallet, $userCourse, $course, $data){

            $wallet->xu += $course->price - $course->discount;
            $wallet->save();
            $userCourse->delete();

            event(new RefundCourseEvent($userCourse));
        });

        return response()->json(array('error' => false, 'msg' => 'Cập nhật thành công'));

    }
}
