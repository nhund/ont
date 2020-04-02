<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\CommentCourse;
use Auth;
use App\Models\Rating;
use App\Models\UserCourse;
use App\User;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\UserQuestionLog;
use App\Models\UserQuestionBookmark;
use App\Models\TeacherSupport;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{        
    public function courseList(Request $request)
    {
        $data = $request->all();
        $limit = 12;
        $var = [];
        $var['params'] = [];
        $var['params']['status_not'] = Course::TYPE_PRIVATE;
        $var['params']['sortBy'] = 'created-descending';
        if(isset($data['price']) && $data['price'] !== '')
        {
            $var['params']['price'] = $data['price'];
        }
        if(isset($data['sortBy']) && $data['sortBy'] !== '')
        {
            $var['params']['sortBy'] = $data['sortBy'];
        }
        if(isset($data['rating']) && $data['rating'] !== '')
        {
            $var['params']['rating'] = $data['rating'];
        }
        if(isset($data['category_id']) && $data['category_id'] !== '')
        {
            $var['params']['category_id'] = explode(',',$data['category_id']);
            $var['cate'] = Category::find($data['category_id']);
        }
        $var['courses'] = Course::Filter($var['params']);
        $var['category'] = Category::where('status',Category::STATUS_ON)->get();   
        // $var['myCourse'] = Course::
        //dd($var);        
        return view('course.index',compact('var'));
    }
    public function courseDetail($title, $id)
    {
        
        $course = Course::find($id);
        if(!$course)
        {
            alert()->error("Nội dung không tồn tại");
            return redirect()->route('home');
        }
        if($course->status == Course::TYPE_PRIVATE)
        {
            if(Auth::check())
            {
                if(Auth::user()->level == User::USER_TEACHER || Auth::user()->level == User::USER_ADMIN)
                {                    
                    if(isset($course->user_id) && Auth::user()->id != $course->user_id)
                    {
                        alert()->error("Nội dung không tồn tại");
                        return redirect()->route('home');
                    }
                }
            }else{
                alert()->error("Nội dung không tồn tại");
                return redirect()->route('home');
            }
        }
           
        
        $var = [];
        $var['course'] = $course;
        $var['course_same'] = Course::where('category_id',$course->category_id)->where('status','!=',Course::TYPE_PRIVATE)->where('id','!=',$id)->orderBy('id','DESC')->take(5)->get();
        $comments = CommentCourse::where('course_id',$id)->where('parent_id',0)->orderBy('created_at','DESC')->paginate(20);
        if(count($comments) > 0)
        {
            foreach($comments as $comment)
            {
                $comment->comment_childs = CommentCourse::where('course_id',$id)->where('parent_id',$comment->id)->get();    
            }
        }
        $var['comments'] = $comments;
        // rating
        $var['rating'] = Rating::select('rating_value',DB::raw('count(*) as total'))->where('course_id',$id)->groupBy('rating_value')->get();
        
        $ratingValue = array(
            '1'=>0,
            '2'=>0,
            '3'=>0,
            '4'=>0,
            '5'=>0,
        );
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
        
        $limit = 20;
        $var['rates'] = Rating::where('course_id',$id)->orderBy('id','DESC')->paginate($limit);
        //dd($var['rates']);
        $var['rating_value'] = $ratingValue;
        //$var['rating_total'] = $rating_value;
        if(Auth::check())
        {
            $var['user_course'] = UserCourse::where('user_id',Auth::user()->id)->where('course_id',$id)->first();
        }
        //dd($var['rating_total']);
        return view('course.detail.course',compact('var'));
    }
    public function myCourse(Request $request)
    {
        $data = $request->all();
        if(!Auth::check())
        {
            return redirect()->route('home');
        }
        $user = Auth::user();
        $var['params'] = [];
        $limit = 20;
        $courses = UserCourse::where('user_id',$user->id)->orderBy('created_at','DESC')->paginate($limit);
        foreach($courses as $key => $course)
        {
            $lesson = Course::find($course->course_id);
            if(!$lesson)
            {
                $courses->forget($key);
                continue;
            }
        }
        //$var['params']['user_id'] = Auth::user()->id;
        $var['courses'] = $courses;
        //dd($var['courses']);
        return view('course.my_course.my_course',compact('var'));
    }
    /**
     * khoa hoc da tao cua user
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function courseCreated(Request $request)
    {
        $data = $request->all();
        if(!Auth::check())
        {
            return redirect()->route('home');
        }
        $var['params'] = [];
        $limit = 20;
        if(isset($data['sortBy']) && $data['sortBy'] !== '')
        {
            $var['params']['sortBy'] = $data['sortBy'];
        }
        //lay cac khoa hoc user lam tro giang
        $course_support = TeacherSupport::where('status',TeacherSupport::STATUS_ON)->where('user_id',Auth::user()->id)->get()->pluck('course_id')->toArray();
        //dd($course_support);
        if(count($course_support) > 0)
        {
            //$var['params']['course_id_in'] = $course_support;
        }
        $var['params']['user_id'] = Auth::user()->id; //dd($var);
        $var['courses'] = Course::Filter($var['params']);

        
        return view('course.my_course.course_created',compact('var'));
    }
    /**
     * Khoa hoc tro giang cua user
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function courseSupport(Request $request)
    {
        $data = $request->all();
        if(!Auth::check())
        {
            return redirect()->route('home');
        }
        $var['params'] = [];
        $limit = 20;
        if(isset($data['sortBy']) && $data['sortBy'] !== '')
        {
            $var['params']['sortBy'] = $data['sortBy'];
        }
        //lay cac khoa hoc user lam tro giang
        $course_support = TeacherSupport::where('status',TeacherSupport::STATUS_ON)->where('user_id',Auth::user()->id)->get()->pluck('course_id')->toArray();
        
        if(count($course_support) > 0)
        {
            $var['params']['course_id_in'] = $course_support;
        }        
        if(count($course_support) == 0)
        {
            alert()->error('Bạn ko trợ giảng khóa học nào');
            return redirect()->route('home');
        }
        //$var['params']['user_id'] = Auth::user()->id; //dd($var);
        $var['courses'] = Course::Filter($var['params']);
        $var['title'] = 'Khóa học trợ giảng';
        return view('course.my_course.course_created',compact('var'));
    }
}
