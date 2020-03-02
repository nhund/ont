<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Auth;
use App\Models\Slide;
use App\Models\Course;
use App\Models\About;
use App\Models\Founder;
use App\Models\Question;
use App\Models\Feedback;
use App\Models\Lesson;
use App\Models\QuestionCardMuti;
use App\Models\UserFeel;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{    
    function js_str($s) {
        if (!is_numeric($s)) {
            return '"' . addcslashes($s, "\0..\37\"\\") . '"';
        } else {
            return addcslashes($s, "\0..\37\"\\");
        }
    }

    function js_array($array) {
        $temp = array_map('js_str', $array);
        return '[' . implode(', ', $temp) . ']';
    }
    public function test()
    {
        $text = 'Trong Công văn số, mới đây về công tác quản lý thuế đối với hộ kinh doanh nộp thuế khoán năm 2019, $\frac{8}{9} = {x^2} + {y^7} - {9^{10}}$ cho biết hoạt động này nhằm đưa vào quản lý thuế nề nếp, chống thất thu thuế. $\frac{8}{9} = {x^2} + {y^7} - {9^{10}}$'; 

                $question = $text; 
                $pattern = '/\\$(.*?)\\$/';
                $content = preg_replace_callback($pattern, function($m){                     
                    return '<p><img alt="'.$m[1].'" src="http://latex.codecogs.com/gif.latex?'.$m[1].'" /></p>';
                },$question);

        dd($content);
        // $data = array(
        //     'project'=>'63b9e4f9-3c5d-48a7-8f98-1ed462f8ef'
        // );
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        // curl_setopt($ch, CURLOPT_URL, 'https://chat-skio.todo.vn:3300/user/get_all_support_of_project');
        // $result = curl_exec($ch);
        // curl_close($ch);
        // $obj = json_decode($result);
        // dd($obj);
        // $time = [];
        // $price = [];
        // foreach ($obj as $key => $value) {
            
        //     $time[] = [(float)$value['0'],(float)$value[4]];
        //     //$price[] = (float)$value[4];
        // }
        // $var['time'] = json_encode($time);
        // //$var['price'] = $price;
        // //dd($var['time']);
        $var = [];
        return view('home.test3',compact('var'));
        dd($time,$btc_marketcap);
        die;
    }
    public function chinhsachriengtu()
    {
        $about = About::first();
        $var['about'] = $about;
        return view('home.chinhsachriengtu',compact('var'));
    }
    public function dieukhoansudung()
    {
        $about = About::first();
        $var['about'] = $about;
        return view('home.dieukhoansudung',compact('var'));
    }
    public function index()
    {
        $var = [];
        $var['sliders'] = Slide::where('status',Slide::STATUS_ON)->get();      
        $var['courses'] = Course::where('status','!=',Course::TYPE_PRIVATE)->where('sticky',Course::STICKY)->take(8)->get();        
        $var['about'] = About::first();  
        $var['user_feels'] = UserFeel::where('status',UserFeel::STATUS_ON)->get();
        $var['founders'] = Founder::where('status',Founder::STATUS_ON)->get();

        $newsFeature =  Post::where('type', Post::NEWS)
            ->where('status', Post::STATUS_ON)->take(4)
            ->orderBy('feature', 'DESC')
            ->orderByRaw('RAND()')->get();

        $var['news'] = $newsFeature;


        return view('home.index',compact('var'));
    }
    public function contact()
    {
        $about = About::first();
        $var = [];
        if(Auth::check())
        {
            $var['user'] = Auth::user();
        }
        return view('home.contact',compact('about','var'));
    }
    public function contactPost(Request $request)
    {
        $data = $request->all();
        if(empty($data['name']) || empty($data['content']))
        {
            alert()->error("Nội dung không được để trống");
            return redirect()->route('contact');
        }
        $contact = new Contact();
        $contact->name = $data['name'];
        $contact->phone = $data['phone'];
        $contact->email = $data['email'];
        $contact->user_id = Auth::check() ? Auth::user()->id : 0;
        $contact->content = $data['content'];
        $contact->create_at = time();        
        if($contact->save())
        { 
            alert()->success('Gửi tin nhắn thành công');            
            return redirect()->route('contact');
        }
        alert()->error('Gửi tin nhắn không thành công');
        return redirect()->route('contact');
    }

    public function addFeedback(Request $request)
    {
        $data = $request->all();
        if(!Auth::check())
        {
            return response()->json(array('error' => true,'type'=>'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        if(!isset($data['question_id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Gửi phản hồi không thành công, vui lòng thử lại sau'));
        }
        if(isset($data['type']) && $data['type'] == Question::TYPE_FLASH_MUTI)
        {
            $question = QuestionCardMuti::find($data['question_id']);
        }else{
            $question = Question::find($data['question_id']);
        }
        
        if(!$question)
        {
            return response()->json(array('error' => true, 'msg' => 'Câu hỏi không tồn tại'));
        }
        $lesson = Lesson::find($question->lesson_id);
        $feedback = new Feedback();
        $feedback->user_id = $user->id;
        $feedback->title = $data['title'];
        $feedback->name = '';
        $feedback->email = $data['email'];
        $feedback->content = $data['content'];
        $feedback->course_id = $lesson->course_id;
        $feedback->lesson_id = $lesson->id;
        $feedback->teacher_id = $question->user_id;
        $feedback->question_id = $data['question_id'];
        $feedback->question_type = isset($data['type']) ? $data['type'] : 0;
        $feedback->status = Feedback::STATUS_NOT_EDIT;
        $feedback->create_date = time();
        if($feedback->save())
        {
            return response()->json(array('error' => false, 'msg' => 'Gửi phản hồi thành công'));
        }
        return response()->json(array('error' => true, 'msg' => 'Gửi phản hồi không thành công'));

    }
    public function logoutAcount(Request $request)
    {        
        if(!Auth::check())
        {
            return redirect()->route('home');
        }
        Auth::logout();
        alert()->error('<span>Tài khoản của bạn đã được đăng nhập ở một nơi khác.</br> Bạn vui lòng không dùng chung tài khoản để chức năng tối ưu ghi nhớ có hiệu quả.</span>')->html()->autoclose(6000)->persistent("Đóng lại");
        return redirect()->route('home');
    }
}
