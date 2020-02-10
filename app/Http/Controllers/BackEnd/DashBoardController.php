<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Question;
use App\Models\QuestionCardMuti;
use App\Models\QuestionAnswer;
use App\Helpers\Helper;
use Auth;

class DashBoardController extends AdminBaseController
{    
    public function index()
    {
        $var['breadcrumb']['breadcrumb'] = array(
            array(
                'url'=> route('home'),
                'title' => 'Trang chủ',
            )
        );
        return view('backend.dashboard.index',$var);
    }
    public function test()
    {
        $file = public_path('file/test.xlsx');
        $data = Excel::load($file, function($reader) {
            // $results = $reader->get();
            // // ->all() is a wrapper for ->get() and will work the same
            // $results = $reader->all();

        })->get();
        foreach ($data as $key => $value) {
            dd($value->getHeading());
        }
        
        return view('backend.dashboard.test');	
    }
    public function testSave(Request $request)
    {
    	$data = $request->all();
        $file = $request->file('file');
        $array = [];
        $data_excel = Excel::load($file, function($reader) {            
        })->get();
        $data['lesson_id'] = 1;
        $user = Auth::user();
        foreach ($data_excel as $key => $value) {
            $items = $value->toArray();
            //dd($items);
            $flash_chuoi = [];
            $dien_tu_ngan = [];
            $trac_nghiem = [];
            foreach($items as $key => $item)
            {
                if(isset($items[0]))
                {
                    if (strpos($item[1], '#f.') !== false) {
                        //kiem tra xem flash chuoi da co chua . neu co roi thi luu data
                        if(count($flash_chuoi) > 0)
                        {
                            $this->_saveFlashChuoi($flash_chuoi);
                            $flash_chuoi = [];
                        }
                        //kiem tra xem dien tu ngan da co chua . neu co roi thi luu data
                        if(count($dien_tu_ngan) > 0)
                        {
                            $this->_saveDienTu($dien_tu_ngan);
                            $dien_tu_ngan = [];
                        }
                        //kiem tra xem trac nghiem da co chua . neu co roi thi luu data
                        if(count($trac_nghiem) > 0)
                        {
                            $this->_saveTracNghiem($trac_nghiem);
                            $trac_nghiem = [];
                        }
                        // cau hoi flash don                        
                        $formatData = $this->_formatFlashCard($item);
                        $item_flash                   = array(
                            'content'       => $formatData['content'],
                            'type'          => Question::TYPE_FLASH_SINGLE,
                            'parent_id'     => 0,
                            'lesson_id'     => $data['lesson_id'],
                            'user_id'       => $user->id,
                            'created_at'    => time(),
                            'explain_before'=> $formatData['explain_before'],
                            'explain_after' => $formatData['explain_after'],
                            'question'      => $formatData['question_before'],
                            'question_after'=> $formatData['question_after'],
                        );
                        Question::insert($item_flash);                        
                    }
                    if(strpos($item[1], '#mf.') !== false)
                    {
                        //kiem tra xem flash chuoi da co chua . neu co roi thi luu data
                        if(count($flash_chuoi) > 0)
                        {
                            $this->_saveFlashChuoi($flash_chuoi);
                            $flash_chuoi = [];
                        }
                        //kiem tra xem dien tu ngan da co chua . neu co roi thi luu data
                        if(count($dien_tu_ngan) > 0)
                        {
                            $this->_saveDienTu($dien_tu_ngan);
                            $dien_tu_ngan = [];
                        }
                        //kiem tra xem trac nghiem da co chua . neu co roi thi luu data
                        if(count($trac_nghiem) > 0)
                        {
                            $this->_saveTracNghiem($trac_nghiem);
                            $trac_nghiem = [];
                        }
                        // cau hoi flash chuoi
                        if (strpos($item[1], '#mf.') !== false) {
                            $flash_chuoi['content'] = str_replace('#mf.','',$item[1]);
                            $flash_chuoi['user_id'] = $user->id;
                            $flash_chuoi['lesson_id'] = $data['lesson_id'];
                            $flash_chuoi['created_at'] = time();
                        }                        
                    }
                    if(strpos($item[1], '$f.') !== false)
                    {
                        $formatData = $this->_formatFlashCard($item);
                        // cau hoi flash chuoi cha
                        $flash_chuoi['childs'][] = array(

                            'explain_before'=> $formatData['explain_before'],
                            'explain_after' => $formatData['explain_after'],
                            'question'      => $formatData['question_before'],
                            'question_after'=> $formatData['question_after'],
                        );
                        
                    }
                    if(strpos($item[1], '$sf.') !== false)
                    {
                        // cau hoi flash chuoi con
                        //get flash card cha cuoi cung
                        $last_parent = count($flash_chuoi['childs']);
                        if($last_parent > 0)
                        {
                            $formatData = $this->_formatFlashCard($item);                              
                            $flash_chuoi['childs'][$last_parent - 1]['childs'][] = array(
                                'explain_before'=> $formatData['explain_before'],
                                'explain_after' => $formatData['explain_after'],
                                'question'      => str_replace('$sf.','',$item[1]),
                                'question_after'=> $formatData['question_after'],
                            );                            
                            
                        }                        
                    }
                    // dien tu ngan
                    if(strpos($item[1], '#d.') !== false)
                    {
                        //kiem tra xem flash chuoi da co chua . neu co roi thi luu data
                        if(count($flash_chuoi) > 0)
                        {
                            $this->_saveFlashChuoi($flash_chuoi);
                            $flash_chuoi = [];
                        }
                        //kiem tra xem dien tu ngan da co chua . neu co roi thi luu data
                        if(count($dien_tu_ngan) > 0)
                        {
                            $this->_saveDienTu($dien_tu_ngan);
                            $dien_tu_ngan = [];
                        }
                        //kiem tra xem trac nghiem da co chua . neu co roi thi luu data
                        if(count($trac_nghiem) > 0)
                        {
                            $this->_saveTracNghiem($trac_nghiem);
                            $trac_nghiem = [];
                        }
                        // bat dau dien tu ngan
                        // doan van dien tu ngan
                        $dien_tu_ngan['content'] = str_replace('#d.','',$item[1]);
                        $dien_tu_ngan['user_id'] = $user->id;
                        $dien_tu_ngan['lesson_id'] = $data['lesson_id'];                        
                    }
                    if(strpos($item[1], '$d.') !== false)
                    {
                        //cau hoi dien tu ngan
                     $formatData = $this->_formatDienTu($item);
                     $dien_tu_ngan['childs'][] = array(
                        'question'=> $formatData['question'],
                        'explain_before'=> $formatData['explain_before'],
                        'answer'=> $formatData['answer'],
                    );
                 }
                    // trac nghiem
                 if(strpos($item[1], '#tn.') !== false)
                 {
                        //kiem tra xem flash chuoi da co chua . neu co roi thi luu data
                    if(count($flash_chuoi) > 0)
                    {
                        $this->_saveFlashChuoi($flash_chuoi);
                        $flash_chuoi = [];
                    }
                        //kiem tra xem dien tu ngan da co chua . neu co roi thi luu data
                    if(count($dien_tu_ngan) > 0)
                    {
                        $this->_saveDienTu($dien_tu_ngan);
                        $dien_tu_ngan = [];
                    }
                        //kiem tra xem trac nghiem da co chua . neu co roi thi luu data
                    if(count($trac_nghiem) > 0)
                    {
                        $this->_saveTracNghiem($trac_nghiem);
                        $trac_nghiem = [];
                    }
                        // bat dau trac nghiem
                        // doan van trac nghiem
                    $formatData                    = $this->_formatTracNghiem($item);
                    $trac_nghiem['content']        = str_replace('#tn.','',$item[1]);
                    $trac_nghiem['user_id']        = $user->id;
                    $trac_nghiem['explain_before'] = $formatData['explain_before'];
                    $trac_nghiem['lesson_id']      = $data['lesson_id'];                        
                }
                if(strpos($item[1], '$tn.') !== false)
                {
                        //cau hoi trac nghiem
                    $formatData = $this->_formatTracNghiem($item);
                    $trac_nghiem['childs'][] = array(
                        'question'=> $formatData['question'],
                        'explain_before'=> $formatData['explain_before'],
                        'answer'=> $formatData['answer'],
                        'answer_error' => $formatData['ansewr_error']
                    );
                }

            }
            if($key == count($items) - 1)
            {
                    // duyet het dong cuoi cung.
                    // kiem tra xem flashcard chuoi da insert chua
                    //kiem tra xem flash chuoi da co chua . neu co roi thi luu data
                if(count($flash_chuoi) > 0)
                {
                    $this->_saveFlashChuoi($flash_chuoi);
                    $flash_chuoi = [];
                }
                    //kiem tra xem dien tu ngan da co chua . neu co roi thi luu data
                if(count($dien_tu_ngan) > 0)
                {
                    $this->_saveDienTu($dien_tu_ngan);
                    $dien_tu_ngan = [];
                }
                    //kiem tra xem trac nghiem da co chua . neu co roi thi luu data
                if(count($trac_nghiem) > 0)
                {
                    $this->_saveTracNghiem($trac_nghiem);
                    $trac_nghiem = [];
                }
            }

        }                        

    }
    dd("11"); 
    return view('backend.dashboard.test');	
}
protected function _saveTracNghiem($items)
{
    $question                 = new Question();
    $question->type           = Question::TYPE_TRAC_NGHIEM;
    $question->parent_id      = 0;
    $question->lesson_id      = $items['lesson_id'];
    $question->user_id        = $items['user_id'];
    $question->created_at     = time();
    $question->content        = $items['content'];
    $question->explain_before = $items['explain_before'];
    $question->img_before     = '';
    $question->save();
    if(isset($items['childs']) && count($items['childs']) > 0)
    {
        foreach ($items['childs'] as $key => $value) 
        {
            if(!empty($value['question']))
            {
                $question_sub                 = new Question();
                $question_sub->type           = Question::TYPE_TRAC_NGHIEM;
                $question_sub->parent_id      = $question->id;
                $question_sub->lesson_id      = $items['lesson_id'];
                $question_sub->user_id        = $items['user_id'];
                $question_sub->created_at     = time();
                $question_sub->question       = $value['question'];
                $question_sub->explain_before = $value['explain_before'];
                $question_sub->img_before     = '';
                $question_sub->save();
                if(isset($value['answer_error']) && count($value['answer_error']) > 0)
                {
                    foreach($value['answer_error'] as $key_as_error => $ans_er_value)
                    {
                        $as_err              = new QuestionAnswer();
                        $as_err->user_id     = $items['user_id'];
                        $as_err->question_id = $question_sub->id;
                        $as_err->answer      =  $ans_er_value;
                        $as_err->status      = QuestionAnswer::REPLY_ERROR;
                        $as_err->image       = '';
                        $as_err->create_at   = time();
                        $as_err->save();       
                    }
                                // cau tra lơi dung
                    $as_right              = new QuestionAnswer();
                    $as_right->user_id     = $items['user_id'];
                    $as_right->question_id = $question_sub->id;
                    $as_right->answer      = $value['answer'];
                    $as_right->status      = QuestionAnswer::REPLY_OK;
                    $as_right->image       = '';
                    $as_right->create_at   = time();
                    $as_right->save();

                }
            }

        }        
    }
}
protected function _saveDienTu($items)
{
    $question             = new Question();
    $question->type       = Question::TYPE_DIEN_TU;
    $question->parent_id  = 0;
    $question->lesson_id  = $items['lesson_id'];
    $question->user_id    = $items['user_id'];
    $question->created_at = time();
    $question->content    = $items['content'];
    $question->img_before = '';
    $question->save();
    if(isset($items['childs']))
    {
        foreach ($items['childs'] as $key => $q){
            $que                 = new Question();
            $que->type           = Question::TYPE_DIEN_TU;
            $que->parent_id      = $question->id;
            $que->lesson_id      = $items['lesson_id'];
            $que->user_id        = $items['user_id'];
            $que->created_at     = time();
            $que->question       = $q['question'];
            $que->explain_before = $q['explain_before'];
                        //$que->explain_after = '';
            if($que->save())
            {
                $an              = new QuestionAnswer();
                $an->user_id     = $items['user_id'];
                $an->question_id = $que->id;
                $an->answer      = $q['answer'];
                $an->status      = QuestionAnswer::REPLY_OK;
                $an->image       = '';
                $an->create_at   = time();
                $an->save();
            }
        }
    }

}
protected function _saveFlashChuoi($items){
    $question             = new Question();
    $question->type       = Question::TYPE_FLASH_MUTI;
    $question->parent_id  = 0;
    $question->lesson_id  = $items['lesson_id'];
    $question->user_id    = $items['user_id'];
    $question->created_at = time();
    $question->content    = $items['content'];
    if($question->save())
    {
        if(isset($items['childs']))
        {
            foreach ($items['childs'] as $key => $value) {
                if(!empty($value['question']))
                {
                    $question_sub                 = new QuestionCardMuti();
                    $question_sub->lesson_id      = $items['lesson_id'];
                    $question_sub->user_id        = $items['user_id'];                    
                    $question_sub->question_id    = $question->id;
                    $question_sub->parent_id      = $question->id;
                    $question_sub->question       = $value['question'];
                    $question_sub->question_after = $value['question_after'];
                    $question_sub->explain_before = $value['explain_before'];
                    $question_sub->explain_after  = $value['explain_after'];
                    $question_sub->img_before     = '';
                    $question_sub->img_after      = '';
                    $question_sub->create_at      = time();
                    $question_sub->save();
                    if(isset($value['childs']) && count($value['childs'])  > 0)
                    {
                        foreach($value['childs'] as $key_child => $value_child)
                        {
                            $question_sub_child                 = new QuestionCardMuti();
                            $question_sub_child->lesson_id      = $items['lesson_id'];
                            $question_sub_child->user_id        = $items['user_id'];
                            $question_sub_child->question_id    = $question->id;
                            $question_sub_child->parent_id      = $question_sub->id;
                            $question_sub_child->question       = $value_child['question'];
                            $question_sub_child->question_after = $value_child['question_after'];
                            $question_sub_child->explain_before = $value_child['explain_before'];
                            $question_sub_child->explain_after  = $value_child['explain_after'];
                            $question_sub_child->img_before     = '';
                            $question_sub_child->img_after      = '';
                            $question_sub_child->create_at      = time();
                            $question_sub_child->save();
                        }
                    }
                }
            }
        }
    }

}
protected function _formatTracNghiem($items){
    $question = '';
    $ansewr = '';
    $ansewr_error = [];
    $explain_before = '';

    foreach ($items as $key => $text) {
        if (strpos($text, '$tn.') !== false) {
            $question = str_replace('$tn.','',$text);
        }
        if (strpos($text, '$t.') !== false) {
            $ansewr = str_replace('$t.','',$text);
        }
        if (strpos($text, '$h.') !== false) {
            $explain_before = str_replace('$h.','',$text);
        }    
        if (strpos($text, '$s.') !== false) {
            $ansewr_error[] = str_replace('$s.','',$text);
        }        
    }
    return array(
        'question'=>$question,
        'answer'=>$ansewr,
        'explain_before'=>$explain_before,   
        'ansewr_error'=>$ansewr_error         
    );
}
protected function _formatDienTu($items)
{
    $question = '';
    $ansewr = '';
    $explain_before = '';
    foreach ($items as $key => $text) {
        if (strpos($text, '$d.') !== false) {
            $question = str_replace('$d.','',$text);
        }
        if (strpos($text, '$t.') !== false) {
            $ansewr = str_replace('$t.','',$text);
        }
        if (strpos($text, '$h.') !== false) {
            $explain_before = str_replace('$h.','',$text);
        }            
    }
    return array(
        'question'=>$question,
        'answer'=>$ansewr,
        'explain_before'=>$explain_before,            
    );
}
protected function _formatFlashCard($items)
{
    $content = '';
    $question_after = '';
    $question_before = '';
    $explain_after = '';
    $explain_before = '';
    foreach ($items as $key => $text) {
        if (strpos($text, '#f.') !== false) {
            $content = str_replace('#f.','',$text);
        }
        if (strpos($text, '$b.') !== false) {
            $question_after = str_replace('$b.','',$text);
        }
        if (strpos($text, '$f.') !== false) {
            $question_before = str_replace('$f.','',$text);
        }
        if (strpos($text, '$bh.') !== false) {
            $explain_after = str_replace('$bh.','',$text);
        }
        if (strpos($text, '$fh.') !== false) {
            $explain_before = str_replace('$fh.','',$text);
        }
    }
    return array(
        'content'=>$content,
        'question_after'=>$question_after,
        'question_before'=>$question_before,
        'explain_after'=>$explain_after,
        'explain_before'=>$explain_before,
    );
}
public function indexContact()
{
    $limit = 20;
    $var['contacts'] = Contact::orderBy('id','DESC')->paginate($limit);  
    $var['breadcrumb'] = array(
        array(
            'url'=> route('admin.contact.index'),
            'title' => 'Danh sách tin nhắn',
        ),
    );
    return view('backend.contact.index',compact('var'));
}
public function deleteContact(Request $request)
{
    $data = $request->all();
    if(!isset($data['id']))
    {
        return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
    }
    $contact = Contact::find($data['id']);
    if(!$contact)
    {
        return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
    }

    if($contact->delete())
    {        
        return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
    }
    return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
}

public function toolUpload()
{
    $var = [];
    return view('backend.upload.upload_images',compact('var'));
}
public function toolUploadSave(Request $request)
{
    $var = [];
    $image         = $request->file('files');
        //dd($image);
    if ($image) {
        $hasError = false;
        if (!in_array($image->clientExtension(), ['jpeg','png','jpg','gif','svg', 'webp'])) {
            $hasError   = true;
        }
        $imagesize = $image->getClientSize();
        if ($imagesize > 2048000) {
            $hasError   = true;
        }

        if (!$hasError) {               

            $name = time().'_'.str_slug($image->getClientOriginalName()).'.'.$image->getClientOriginalExtension();
            $path = '/images/exercise/upload';
            $destinationPath = public_path($path);
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777);
            }
            $image->move($destinationPath, $name);
            $avatar = '/images/exercise/upload/'.$name;
                // // $user->avatar_path = $path;
                // // $user->avatar_name = $name;
                // //dd($destinationPath);
                // $course->avatar  = $name;
                // $course->avatar_path  = $path;
                // if($course->save())
                // {

                //     Helper::thumbImages($name,$avatar,480,320,'fit',$destinationPath.'/480_320');                    
                // }
                $file = [];
                $file[] = array(
                        'deleteType'=>"GET",
                        'deleteUrl'=>route('admin.toolUploadDelete',['url'=>$avatar]),
                        'name'=> $avatar,
                        'size'=> $imagesize,
                        'thumbnailUrl'=> web_asset('public'.$avatar),
                        'type'=> "image/jpeg",
                        'url'=> web_asset('public'.$avatar)
                    );
                $files = array(
                    'files'=>$file
                );
                return response()->json($files);
        }

    }
    return view('backend.upload.upload_images',compact('var'));
}
    public function toolUploadDelete(Request $request)
    {
       $data = $request->all();
       if(isset($data['url']))
       {
            Helper::removeFolder(public_path($data['url']));
            return response()->json(array(
                'error'=>false
            ));
       }          
    }
}
