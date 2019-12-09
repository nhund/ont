<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamPart;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\UserCourse;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherSupport;
use App\User;
use App\Helpers\Helper;

class LessonController extends AdminBaseController
{
    private function checkPermission($id) {
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

    public function detail($id) {
        $lesson             = $this->checkPermission($id);
        if (!$lesson) {
            return redirect()->route('dashboard');
        }
        $var['page_title']          = 'Chi tiết khóa học '.$lesson->course['name'];
        $var['course']              = $lesson->course;
        $var['lesson']              = $lesson;
        $question                   = Question::where('lesson_id', '=', $lesson->id)
        ->typeAllow()
        ->where('parent_id',0)->orderBy('order_s','ASC')
        ->orderBy('id','ASC')->paginate(30);
        foreach($question as $q) {
            $q->subs = Question::where('lesson_id', '=', $lesson->id)
                ->typeAllow()
                ->where('parent_id', '=', $q->id)->get();
        }
        //$userCourse = UserCourse::where('course_id',$lesson->course_id)->count();
        $var['questions']           = $question;
        $var['user_course']         = $lesson->user_course->count();
        $var['course_lesson']       = Lesson::getCourseLesson($lesson->course['id']);
        $var['breadcrumb']['breadcrumb'] = array(
            array(
                'url'=> route('course.detail',['id'=>$lesson->course->id]),
                'title' => $lesson->course->name,
            ),
            array(
                'url'=>'#',
                'title'=>$lesson->name
            )
        );
        return view('backend.lesson.detail', $var);
    }

    public function handle(Request $request) {
        $id             = $request->input('id', 0);
        $description    = trim($request->input('description', ''));
        $name           = trim($request->input('lname', ''));
        $status         = $request->input('status', 0);
        $video          = $request->input('video', 0);
        $audio          = $request->file('audio');
        $image          = $request->file('image');
        
        $lesson                 = Lesson::find($id);
        if ($lesson) {
            $lesson->description    = Helper::detectMathLatex($description);
            $lesson->name           = $name;
            $lesson->status         = $status;
            $lesson->video          = $video;
            if ($audio) {
                if ($lesson->audio && file_exists('public/'.$lesson->audio)) {
                    unlink('public/'.$lesson->audio);
                }

                $destinationPath    = public_path('/images/course/'.$lesson->course_id.'/lesson/audio');
                $name = time().'_'.str_slug(pathinfo($audio->getClientOriginalName(),PATHINFO_FILENAME)).'.'.$audio->getClientOriginalExtension();
                $audio->move($destinationPath, $name);
                $lesson->audio       = '/images/course/'.$lesson->course_id.'/lesson/audio/' .$name;
            }
            if ($image) {
                if ($lesson->image && file_exists('public/'.$lesson->image)) {
                    unlink('public/'.$lesson->image);
                }
                $destinationPath    = public_path('/images/course/'.$lesson->course_id.'/lesson');
                $name = time().'_'.str_slug(pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME)).'.'.$image->getClientOriginalExtension();
                $image->move($destinationPath, $name);
                $lesson->image       = '/images/course/'.$lesson->course_id.'/lesson/'.$name;
            }
            $lesson->save();
        }

        return redirect()->back();
    }

    public function handleExercise(Request $request) {
        $lesson_id      = $request->input('lesson_id', 0);
        $course_id      = $request->input('course_id', 0);
        $cur_lesson_id  = $request->input('cur_lesson_id', 0);
        $name           = trim($request->input('exName', ''));
        $status         = $request->input('status', '');
        $description    = trim($request->input('exDescription', ''));
        $sapo           = trim($request->input('sapo', ''));
        $repeat_time    = $request->input('repeat_time', '');
        $random_question= $request->input('random_question', '');
        $avatar         = $request->file('avatar');
        $type           = $request->input('type');
        $level           = $request->input('level', 1);

        $les                    = Lesson::find($lesson_id);
        if ($cur_lesson_id) {
            $lesson = Lesson::find($cur_lesson_id);
        } else {
            $lesson = new Lesson();
            $lesson->created_at     = time();
            $lesson->is_exercise    = Lesson::IS_EXERCISE;
            $lesson->parent_id      = $lesson_id ?: 0;
            $lesson->lv1            = 0;
            $lesson->level          = $level;
        }

        if ($les) {
            $lesson->lv1 = $les['lv1'] ?: $lesson_id;

            if ($les['lv1']) {
                $lesson->lv2    = $lesson_id;
                $lesson->lv3    = $lesson_id;
            }

            if ($les['lv1'] && $les['lv2'])
            {
                $lesson->lv2 = $les['lv2'];
                $lesson->lv3 = $lesson_id;
            }

        }

        // if have image
        if ($avatar) {
            if ($lesson->avatar && file_exists('public/images/lesson/'.$lesson->avatar)) {
                unlink('public/images/lesson/'.$lesson->avatar);
            }
            $destinationPath = public_path('/images/lesson');
            $imgName         = str_replace('.'.$avatar->getClientOriginalExtension(),'', $avatar->getClientOriginalName()).time().'.'.$avatar->getClientOriginalExtension();
            $avatar->move($destinationPath, $imgName);
            $lesson->avatar  = $imgName;
        }

        $lesson->name           = $name;
        $lesson->status         = $status;
        $lesson->description    = Helper::detectMathLatex($description);
        $lesson->course_id      = $course_id;
        $lesson->sapo           = $sapo;
        $lesson->repeat_time    = $repeat_time;
        $lesson->random_question= $random_question;
        $lesson->type           = $type;
        $lesson->save();

        if ($type == Lesson::EXAM){
            $params = $request->only(['minutes', 'parts', 'repeat_time', 'stop_time', 'total_score', 'start_time_at', 'end_time_at', 'min_score', 'total_question']);
            $params['lesson_id'] = $lesson->id;
            Exam::updateOrCreateExam($params);
        }

        return redirect()->back();
    }

    public function deleteLesson($id) {
        $lesson = Lesson::find($id);
        if (!$lesson) {
            return redirect()->route('dashboard');
        }
        $user = Auth::user();
        $support = TeacherSupport::where('user_id',$user->id)->where('course_id',$lesson->course_id)->first();
        if ($lesson->course['user_id'] == $user->id || Auth::user()['level'] == User::USER_ADMIN || $support) {
            $lesson->delete();
            if ($lesson->parent_id) {
                return redirect()->route('lesson.detail', ['id' => $lesson->parent_id]);
            } else {
                return redirect()->route('course.detail', ['id' => $lesson->course_id]);
            }            
        }
        return redirect()->route('dashboard');    
    }
    public function deleteLessonPost(Request $request) {
        $data = $request->all();
        $id = $data['id'];
        $lesson = Lesson::find($id);
        if (!$lesson) {
            return response()->json(array('error' => true, 'msg' => 'Cập nhật không thành công'));
        }
        $user = Auth::user();
        $support = TeacherSupport::where('user_id',$user->id)->where('course_id',$lesson->course_id)->first();
        if ($lesson->course['user_id'] == $user->id || Auth::user()['level'] == User::USER_ADMIN || $support) {
            $lesson->delete();
            return response()->json(array('error' => false, 'msg' => 'Cập nhật thành công'));         
        }else{
            return response()->json(array('error' => true, 'msg' => 'Bạn không đủ quyền thực hiện hành động này'));
        }
        //return redirect()->route('dashboard');    
    }
    public function order($id)
    {
        
        $course = Course::find($id);
        if(!$course)
        {
            alert()->error('Có lỗi','Khóa học không tồn tại');
            return redirect()->route('dashboard');  
        }
        $lessons = Lesson::where('course_id',$id)
            ->where('parent_id',0)
            ->orderBy('order_s','ASC')
            ->orderBy('id','ASC')->get();
        foreach($lessons as $lesson)
        {
            $lesson->childs = Lesson::where('course_id',$id)
            ->where('parent_id',$lesson->id)
            ->orderBy('order_s','ASC')
            ->orderBy('id','ASC')->get();
        }    
        $var['course'] = $course;
        $var['lessons'] = $lessons;    
        $var['breadcrumb'] = array(
            array(
                'url'=> route('course.detail',['id'=>$id]),
                'title' => $course->name,
            )
        ); 
        return view('backend.lesson.lesson_order', compact('var'));    

    }
    public function orderSave(Request $request)
    {
        $data = $request->all();
        if($data['order'] != '')
        {
            $lesson_order = json_decode($data['order']);
            foreach ($lesson_order as $key => $order)
            {
                $lesson = Lesson::find($order->id);
                if($lesson)
                {
                    $lesson->order_s = $key;
                    $lesson->save();
                }
                if(isset($order->children))
                {
                    $list_ids = [];
                    foreach ($order->children as $key_child => $children)
                    {
                        $menu_child = Lesson::find($children->id);
                        if($menu_child)
                        {
                            $menu_child->order_s = $key_child;
                            $menu_child->parent_id = $order->id;
                            $menu_child->save();
                        }
                    }
                   
                }
            }
        }
        return response()->json(array('error' => false, 'msg' => 'Cập nhật thành công'));
    }
}
