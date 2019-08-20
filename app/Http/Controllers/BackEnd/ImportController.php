<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\QuestionCardMuti;
use App\Models\QuestionAnswer;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

class ImportController extends AdminBaseController
{    
    public function importImagePost(Request $request)
    {
        $input = $request->all();
        $file = $request->file('upload'); 
        if(!$file)
        {
             return response()->json([
                'error'=>true,
                'msg'   => 'Thêm dữ liệu không thành công',
                'data'      =>  []
            ]);
        }
        if(!Auth::check())
        {
            return response()->json(array('error' => true,'type'=>'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
            //dd($file->getClientSize());
        $check_file = $file->getClientOriginalExtension();
        $size = $file->getClientSize();
        if($size > 5242880)
        {
            return response()->json([
                'error'=>true,
                'msg'   => 'File không được quá 5mb',
                'data'      =>  []
            ]);
        }
        //dd($file);
         if ($file) {
            $hasError = false;
            if (!in_array($file->clientExtension(), ['jpeg','png','jpg','gif','svg', 'webp'])) {
                $hasError   = true;
            }
            if ($file->getClientSize() > 2048000) {
                //$hasError   = true;
            }
            if (!$hasError) {
                // if ($course->avatar && file_exists('public/images/course/'.$course->avatar)) {
                //     unlink('public/images/course/'.$course->avatar);
                // }
                // $destinationPath = public_path('/images/course');
                // $imgName         = str_replace('.'.$avatar->getClientOriginalExtension(),'', $avatar->getClientOriginalName()).time().'.'.$avatar->getClientOriginalExtension();
                // $avatar->move($destinationPath, $imgName);
                // $course->avatar  = $imgName;

                $name = time().'_'.str_slug(pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();
                $path = '/images/post';
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                
                $file->move($destinationPath, $name);
                $image = '/public'.$path.'/'.$name;
                return response()->json(array('error' => false, 'msg' => 'tải file thành công','fileName'=>$name,'uploaded'=>true,'url'=>$image));
            }
        }

    }
    public function importImageCkeditor(Request $request)
    {
        $input = $request->all();
        $file = $request->file('upload'); 
        if(!$file || !$input['course_id'])
        {
             return response()->json([
                'error'=>true,
                'msg'   => 'Thêm dữ liệu không thành công',
                'data'      =>  []
            ]);
        }
        if(!Auth::check())
        {
            return response()->json(array('error' => true,'type'=>'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
            //dd($file->getClientSize());
        $check_file = $file->getClientOriginalExtension();
        $size = $file->getClientSize();
        if($size > 5242880)
        {
            return response()->json([
                'error'=>true,
                'msg'   => 'File không được quá 5mb',
                'data'      =>  []
            ]);
        }
        //dd($file);
         if ($file) {
            $hasError = false;
            if (!in_array($file->clientExtension(), ['jpeg','png','jpg','gif','svg', 'webp'])) {
                $hasError   = true;
            }
            if ($file->getClientSize() > 2048000) {
                //$hasError   = true;
            }
            if (!$hasError) {
                // if ($course->avatar && file_exists('public/images/course/'.$course->avatar)) {
                //     unlink('public/images/course/'.$course->avatar);
                // }
                // $destinationPath = public_path('/images/course');
                // $imgName         = str_replace('.'.$avatar->getClientOriginalExtension(),'', $avatar->getClientOriginalName()).time().'.'.$avatar->getClientOriginalExtension();
                // $avatar->move($destinationPath, $imgName);
                // $course->avatar  = $imgName;

                $name = time().'_'.str_slug(pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();
                $path = '/images/course/'.$input['course_id'];
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $pathDetail = '/images/course/'.$input['course_id'].'/lesson';
                $destinationPath = public_path($pathDetail);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $file->move($destinationPath, $name);
                $image = '/public'.$pathDetail.'/'.$name;
                return response()->json(array('error' => false, 'msg' => 'tải file thành công','fileName'=>$name,'uploaded'=>true,'url'=>$image));
            }
        }

    }
    public function importImage(Request $request)
    {
        $input = $request->all();
        $file = $request->file('file');
        if(!$file || !$input['course_id'])
        {
             return response()->json([
                'error'=>true,
                'msg'   => 'Thêm dữ liệu không thành công',
                'data'      =>  []
            ]);
        }
        if(!Auth::check())
        {
            return response()->json(array('error' => true,'type'=>'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
            //dd($file->getClientSize());
        $check_file = $file->getClientOriginalExtension();
        $size = $file->getClientSize();
        if($size > 5242880)
        {
            return response()->json([
                'error'=>true,
                'msg'   => 'File không được quá 5mb',
                'data'      =>  []
            ]);
        }
        //dd($file);
         if ($file) {
            $hasError = false;
            if (!in_array($file->clientExtension(), ['jpeg','png','jpg','gif','svg', 'webp'])) {
                $hasError   = true;
            }
            if ($file->getClientSize() > 2048000) {
                //$hasError   = true;
            }
            if (!$hasError) {
                // if ($course->avatar && file_exists('public/images/course/'.$course->avatar)) {
                //     unlink('public/images/course/'.$course->avatar);
                // }
                // $destinationPath = public_path('/images/course');
                // $imgName         = str_replace('.'.$avatar->getClientOriginalExtension(),'', $avatar->getClientOriginalName()).time().'.'.$avatar->getClientOriginalExtension();
                // $avatar->move($destinationPath, $imgName);
                // $course->avatar  = $imgName;

                $name = time().'_'.str_slug(pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();
                $path = '/images/course/'.$input['course_id'];
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $pathDetail = '/images/course/'.$input['course_id'].'/question';
                $destinationPath = public_path($pathDetail);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $file->move($destinationPath, $name);
                $image = '/public'.$pathDetail.'/'.$name;
                return response()->json(array('error' => false, 'msg' => 'tải file thành công','file'=>$image));
            }
        }

    }
    public function importAudio(Request $request)
    {
        $input = $request->all();
        $file = $request->file('file');
        if(!$file || !$input['course_id'])
        {
             return response()->json([
                'error'=>true,
                'msg'   => 'Thêm dữ liệu không thành công',
                'data'      =>  []
            ]);
        }
        if(!Auth::check())
        {
            return response()->json(array('error' => true,'type'=>'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
            //dd($file->getClientSize());
        $check_file = $file->getClientOriginalExtension();
        $size = $file->getClientSize();
        // if($size > 5242880)
        // {
        //     return response()->json([
        //         'error'=>true,
        //         'msg'   => 'File không được quá 5mb',
        //         'data'      =>  []
        //     ]);
        // }
        //dd($file);
         if ($file) {
            $hasError = false;
            if (!in_array($file->clientExtension(), ['mp3'])) {
                //$hasError   = true;
            }
            if ($file->getClientSize() > 2048000) {
                //$hasError   = true;
            }
            if (!$hasError) {
                // if ($course->avatar && file_exists('public/images/course/'.$course->avatar)) {
                //     unlink('public/images/course/'.$course->avatar);
                // }
                // $destinationPath = public_path('/images/course');
                // $imgName         = str_replace('.'.$avatar->getClientOriginalExtension(),'', $avatar->getClientOriginalName()).time().'.'.$avatar->getClientOriginalExtension();
                // $avatar->move($destinationPath, $imgName);
                // $course->avatar  = $imgName;

                $name = time().'_'.str_slug(pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();
                $path = '/file/audio/'.$input['course_id'];
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $file->move($destinationPath, $name);
                $audio = '/public/file/audio/'.$input['course_id'].'/'.$name;
                return response()->json(array('error' => false, 'msg' => 'tải file thành công','file'=>$audio));
            }
        }
        
    }
    public function importCourse(Request $request)
    {

        $input = $request->all();
        $file = $request->file('file'); 
        if(!$file || !isset($input['lesson_id']))
        {
             return response()->json([
                'error'=>true,
                'msg'   => 'Thêm dữ liệu không thành công',
                'data'      =>  []
            ]);
        }
        if(!Auth::check())
        {
            return response()->json(array('error' => true,'type'=>'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
            //dd($file->getClientSize());
        $check_file = $file->getClientOriginalExtension();
        $size = $file->getClientSize(); 
        if($size > 5242880)
        {
            return response()->json([
                'error'=>true,
                'msg'   => 'File không được quá 5mb',
                'data'      =>  []
            ]);
        }

        if($check_file != 'xlsx')
        {
            return response()->json([
                'error'=>true,
                'msg'   => 'File không đúng định dạng',
                'data'      =>  []
            ]);
        }
        $data_excel = Excel::load($file, function($reader) {            
        })->get(); 
        $course_id = 0;
        $data['lesson_id'] = $input['lesson_id'];
        $lesson = Lesson::find($data['lesson_id']);
        if($lesson)
        {
            $course_id = $lesson->course->id;
        }
        
        foreach ($data_excel as $key => $value) {
            $items = $value->toArray();  
            //dd($items);          
            $flash_chuoi = [];
            $dien_tu_ngan = [];
            $trac_nghiem = [];
            $dien_tu_doan_van = [];
            DB::beginTransaction();  
            try {                                    
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
                                $this->_saveTracNghiem($trac_nghiem,$data['lesson_id']);
                                $trac_nghiem = [];
                            }
                            //kiem tra xem dien tu doan van co du lieu chua. neu co roi thi luu data
                            if(count($dien_tu_doan_van) > 0)
                            {
                                $this->_saveDienTuDoanVan($dien_tu_doan_van);
                                $dien_tu_doan_van = [];
                            }
                                // cau hoi flash don                        
                            $formatData = $this->_formatFlashCard($item);
                            $item_flash                   = array(
                                'content'       => $formatData['content'],
                                'type'          => Question::TYPE_FLASH_SINGLE,
                                'parent_id'     => 0,
                                'lesson_id'     => $data['lesson_id'],
                                'course_id'     =>$course_id,
                                'user_id'       => $user->id,
                                'created_at'    => time(),
                                'explain_before'=> $formatData['explain_before'],
                                'explain_after' => $formatData['explain_after'],
                                'question'      => $formatData['question_before'],
                                'question_after'=> $formatData['question_after'],
                                'img_before'=>$formatData['img_before'],
                                'img_after'=>$formatData['img_after']
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
                                $this->_saveTracNghiem($trac_nghiem,$data['lesson_id']);
                                $trac_nghiem = [];
                            }
                            //kiem tra xem dien tu doan van co du lieu chua. neu co roi thi luu data
                            if(count($dien_tu_doan_van) > 0)
                            {
                                $this->_saveDienTuDoanVan($dien_tu_doan_van);
                                $dien_tu_doan_van = [];
                            }
                                // cau hoi flash chuoi
                            if (strpos($item[1], '#mf.') !== false) {
                                $flash_chuoi['content'] = $this->_detectMathLatex(str_replace('#mf.','',$item[1]));
                                $flash_chuoi['user_id'] = $user->id;
                                $flash_chuoi['lesson_id'] = $data['lesson_id'];
                                $flash_chuoi['course_id'] = $course_id;
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
                                'course_id' => $course_id,
                                'question'      => $formatData['question_before'],
                                'question_after'=> $formatData['question_after'],
                                'img_before'=>$formatData['img_before'],
                                'img_after'=>$formatData['img_after']
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
                                    'course_id' => $course_id,
                                    'question'      => $this->_detectMathLatex(str_replace('$sf.','',$item[1])),
                                    'question_after'=> $formatData['question_after'],
                                    'img_before'=>$formatData['img_before'],
                                    'img_after'=>$formatData['img_after']
                                );                            

                            }                        
                        }
                        // dien tu ngan
                        if(strpos($item[1], '#q.') !== false)
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
                                $this->_saveTracNghiem($trac_nghiem,$data['lesson_id']);
                                $trac_nghiem = [];
                            }
                            //kiem tra xem dien tu doan van co du lieu chua. neu co roi thi luu data
                            if(count($dien_tu_doan_van) > 0)
                            {
                                $this->_saveDienTuDoanVan($dien_tu_doan_van);
                                $dien_tu_doan_van = [];
                            }
                            // bat dau dien tu ngan
                            // doan van dien tu ngan
                            $formatData = $this->_formatDienTu($item);
                            $dien_tu_ngan['content'] = $this->_detectMathLatex(str_replace('#q.','',$item[1]));
                            $dien_tu_ngan['interpret'] = $this->_detectMathLatex($formatData['interpret']);
                            
                            $dien_tu_ngan['user_id'] = $user->id;
                            $dien_tu_ngan['lesson_id'] = $data['lesson_id'];  
                            $dien_tu_ngan['course_id'] = $course_id;      
                            $dien_tu_ngan['image'] = $formatData['image'];                      
                        }
                        if(strpos($item[1], '$d.') !== false)
                        {
                            //cau hoi dien tu ngan
                           $formatData = $this->_formatDienTu($item); 
                           $dien_tu_ngan['childs'][] = array(
                                'question'=> $this->_detectMathLatex($formatData['question']),
                                'explain_before'=> $this->_detectMathLatex($formatData['explain_before']),
                                'interpret'=>$this->_detectMathLatex($formatData['interpret']),
                                'image'=>$formatData['image'],
                                'answer'=> $formatData['answer'],
                                'course_id' => $course_id,
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
                                $this->_saveTracNghiem($trac_nghiem,$data['lesson_id']);
                                $trac_nghiem = [];
                            }
                            //kiem tra xem dien tu doan van co du lieu chua. neu co roi thi luu data
                            if(count($dien_tu_doan_van) > 0)
                            {
                                $this->_saveDienTuDoanVan($dien_tu_doan_van);
                                $dien_tu_doan_van = [];
                            }
                            // bat dau trac nghiem
                            // doan van trac nghiem
                            $formatData                    = $this->_formatTracNghiem($item);
                            $trac_nghiem['content']        = $this->_detectMathLatex(str_replace('#tn.','',$item[1]));
                            $trac_nghiem['user_id']        = $user->id;
                            $trac_nghiem['explain_before'] = $formatData['explain_before'];
                            $trac_nghiem['interpret'] = $formatData['interpret'];
                            $trac_nghiem['lesson_id']      = $data['lesson_id'];       
                            $trac_nghiem['course_id'] = $course_id;
                            $trac_nghiem['image'] = $formatData['image'];                 
                        }
                        if(strpos($item[1], '$tn.') !== false)
                        {
                            //cau hoi trac nghiem
                                $formatData = $this->_formatTracNghiem($item);
                                $trac_nghiem['childs'][] = array(
                                    'question'=> $formatData['question'],
                                    'explain_before'=> $formatData['explain_before'],
                                    'lesson_id'=> $data['lesson_id'],
                                    'answer'=> $formatData['answer'],
                                    'answer_error' => $formatData['ansewr_error'],
                                    'course_id' => $course_id,
                                    'image' => $formatData['image'],  
                                    'interpret'=>$formatData['interpret'],
                                );
                        }                    
                    }
                    //dien tu doan van
                    if(strpos($item[1], '#dt.') !== false)
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
                                $this->_saveTracNghiem($trac_nghiem,$data['lesson_id']);
                                $trac_nghiem = [];
                            }
                            //kiem tra xem dien tu doan van co du lieu chua. neu co roi thi luu data
                            if(count($dien_tu_doan_van) > 0)
                            {
                                $this->_saveDienTuDoanVan($dien_tu_doan_van);
                                $dien_tu_doan_van = [];
                            }
                        // bat dau dien tu doan van
                        // doan van dien tu
                        $formatData                    = $this->_formatDienTuDoanVan($item);
                        $dien_tu_doan_van['content']        = $this->_detectMathLatex(str_replace('#dt.','',$item[1]));
                        $dien_tu_doan_van['interpret']        = $this->_detectMathLatex($formatData['interpret']);
                        $dien_tu_doan_van['user_id']        = $user->id;
                        $dien_tu_doan_van['explain_before'] = $formatData['explain_before'];
                        $dien_tu_doan_van['image'] = $formatData['image'];
                        $dien_tu_doan_van['lesson_id']      = $data['lesson_id']; 
                        $dien_tu_doan_van['course_id'] =  $course_id;
                    }
                    if(strpos($item[1], '$dt.') !== false)
                    {
                            //cau hoi dien tu doan van
                        $formatData = $this->_formatDienTuDoanVan($item); 
                        $dien_tu_doan_van['childs'][] = array(
                            'question'=> $formatData['question'],
                            'explain_before'=> $formatData['explain_before'], 
                            'course_id' => $course_id,
                            'interpret'=> $this->_detectMathLatex($formatData['interpret']),                              
                        );
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
                            $this->_saveTracNghiem($trac_nghiem,$data['lesson_id']);
                            $trac_nghiem = [];
                        }
                        //kiem tra xem dien tu doan van co du lieu chua. neu co roi thi luu data
                        if(count($dien_tu_doan_van) > 0)
                        { 
                            
                            $this->_saveDienTuDoanVan($dien_tu_doan_van);
                            $dien_tu_doan_van = [];
                        }
                    }                

                }  
            }catch (Exception $e) {
                //die("111");
                DB::rollBack();
                return response()->json(array('error' => true,'msg' => 'Có lỗi xẩy ra','code'=>$e));                     
            } 
            DB::commit();
            return response()->json(array('error' => false,'msg' => 'Thêm dữ liệu thành công'));                     

        }
    return response()->json(array('error' => true,'msg' => 'Thêm dữ liệu không thành công'));
    return view('backend.dashboard.index');
}
protected function _formatDienTuDoanVan($items)
{       
        $question = '';
        
        $explain_before = '';
        $image  = '';
        $interpret = '';
        foreach ($items as $key => $text) {            
            if (strpos($text, '$dt.') !== false) { 
                $question = str_replace('$dt.','',$text); 
                $pattern = '/<#(.*?)#>/';
                $content = preg_replace_callback($pattern, function($m){ 
                    //return $m[1];
                    $path = explode('|',$m[1]);
                    if(isset($path[1]))
                    {
                        return '<a class="clozetip" title="'.$path[1].'" href="#">'.$path[0].'</a>';            
                    }else{
                        return '<a class="clozetip" title="" href="#">'.$path[0].'</a>';            
                    }
                },$question);
                
                $question = $content;
            }            
            if (strpos($text, '$h.') !== false) {
                $explain_before = str_replace('$h.','',$text);
                $explain_before = $this->_detectMathLatex($explain_before);
            } 
            if (strpos($text, '$i.') !== false) {
                $image = str_replace('$i.','',$text);
            }  
            if (strpos($text, '$e.') !== false) {                
                $interpret = str_replace('$e.','',$text);
                $interpret = $this->_detectMathLatex($interpret);
            }              
        }
        
        return array(
            'question'=>$this->_detectMathLatex($question,'doan_van'),
            'image'=>$image,
            'explain_before'=>$explain_before,      
            'interpret'=>$interpret            
        );
}
protected function _saveTracNghiem($items, $lesson_id = 0)
    {   
        //dd($items);
        $question                 = new Question();
        $question->type           = Question::TYPE_TRAC_NGHIEM;
        $question->parent_id      = 0;
        $question->lesson_id      = !isset($items['lesson_id']) ? $items['lesson_id'] : $lesson_id;
        $question->course_id =  $items['course_id'];
        $question->user_id        = $items['user_id'];
        $question->created_at     = time();
        $question->content        = $items['content'];
        $question->explain_before = $items['explain_before'];
        $question->interpret_all = $items['interpret'];
        $question->img_before     = $items['image'];
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
                    $question_sub->lesson_id      = !isset($items['lesson_id']) ? $items['lesson_id'] : $lesson_id;
                    $question_sub->course_id      = $value['course_id'];
                    $question_sub->user_id        = $items['user_id'];
                    $question_sub->created_at     = time();
                    $question_sub->question       = $value['question'];
                    $question_sub->explain_before = $value['explain_before'];
                    $question_sub->interpret = $value['interpret'];
                    $question_sub->img_before     = $value['image'];
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
protected function _formatDienTu($items)
    {
        $question = '';
        $ansewr = '';
        $explain_before = '';
        $image = '';
        $interpret = '';

        foreach ($items as $key => $text) {
            if (strpos($text, '$d.') !== false) {
                $question = str_replace('$d.','',$text);
                $question = $this->_detectMathLatex($question);
            }
            if (strpos($text, '$t.') !== false) {
                $ansewr = str_replace('$t.','',$text);
                $ansewr = $this->_detectMathLatex($ansewr);
            }
            if (strpos($text, '$h.') !== false) {
                $explain_before = str_replace('$h.','',$text);
                $explain_before = $this->_detectMathLatex($explain_before);
            } 
            if (strpos($text, '$i.') !== false) {
                $image = str_replace('$i.','',$text);
            }             
            if (strpos($text, '$e.') !== false) {                
                $interpret = str_replace('$e.','',$text);
                $interpret = $this->_detectMathLatex($interpret);
            }  
        }
        return array(
            'question'=>$question,
            'answer'=>$ansewr,
            'explain_before'=>$explain_before,      
            'image'=>$image,
            'interpret'=>$interpret        
        );
    }
protected function _formatTracNghiem($items){
        $question = '';
        $ansewr = '';
        $ansewr_error = [];
        $explain_before = '';
        $image = '';
        $interpret = '';

        foreach ($items as $key => $text) {
            if (strpos($text, '$tn.') !== false) {
                $question = str_replace('$tn.','',$text);
                
                $question = $this->_detectMathLatex($question);
            }
            if (strpos($text, '$t.') !== false) {
                $ansewr = str_replace('$t.','',$text);
                $ansewr = $this->_detectMathLatex($ansewr);
            }
            if (strpos($text, '$h.') !== false) {
                $explain_before = str_replace('$h.','',$text);
                $explain_before = $this->_detectMathLatex($explain_before);
            }    
            if (strpos($text, '$s.') !== false) {
                
                $text_temp = str_replace('$s.','',$text);                
                $ansewr_error[] = $this->_detectMathLatex($text_temp);
            }        
            if (strpos($text, '$i.') !== false) {
                $image = str_replace('$i.','',$text);
            }  
            if (strpos($text, '$e.') !== false) {                
                $interpret = str_replace('$e.','',$text);
                $interpret = $this->_detectMathLatex($interpret);
            }  
        }
        return array(
            'question'=>$question,
            'answer'=>$ansewr,
            'explain_before'=>$explain_before,   
            'ansewr_error'=>$ansewr_error,
            'image'=>$image,
            'interpret'=>$interpret             
        );
    }
    protected function _saveDienTuDoanVan($items)
    {
        $question = new Question();
        $question->type = Question::TYPE_DIEN_TU_DOAN_VAN;
        $question->parent_id = 0;
        $question->lesson_id = $items['lesson_id'];
        $question->course_id = $items['course_id'];
        $question->user_id = $items['user_id'];
        $question->created_at = time();
        $question->content = $items['content'];
        $question->interpret_all = $items['interpret'];
        $question->img_before = $items['image'];
        $question->save();
        if(isset($items['childs']))
        {
            foreach ($items['childs'] as $key => $q)
            {
                $que = new Question();
                $que->type = Question::TYPE_DIEN_TU_DOAN_VAN;
                $que->parent_id = $question->id;
                $que->lesson_id = $items['lesson_id'];
                $que->course_id = $items['course_id'];
                $que->user_id = $items['user_id'];
                $que->created_at = time();
                $que->question = $q['question'];
                $que->explain_before = $q['explain_before'];
                $que->interpret = $q['interpret'];
                $que->save();
            }
        }
        
    }
protected function _saveDienTu($items)
    {
        $question             = new Question();
        $question->type       = Question::TYPE_DIEN_TU;
        $question->parent_id  = 0;
        $question->lesson_id  = $items['lesson_id'];
        $question->course_id = $items['course_id'];
        $question->user_id    = $items['user_id'];
        $question->created_at = time();
        $question->content    = $items['content'];
        $question->interpret_all    = $items['interpret'];
        $question->img_before = $items['image'];
        $question->save();
        if(isset($items['childs']))
        {
            foreach ($items['childs'] as $key => $q){
                $que                 = new Question();
                $que->type           = Question::TYPE_DIEN_TU;
                $que->parent_id      = $question->id;
                $que->lesson_id      = $items['lesson_id'];
                $que->course_id = $items['course_id'];
                $que->user_id        = $items['user_id'];
                $que->created_at     = time();
                $que->question       = $q['question'];
                $que->explain_before = $q['explain_before'];
                $que->interpret = $q['interpret'];
                $que->img_before = $q['image'];
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
    $question = new Question();
    $question->type = Question::TYPE_FLASH_MUTI;
    $question->parent_id = 0;
    $question->lesson_id = $items['lesson_id'];
    $question->course_id = $items['course_id'];
    $question->user_id = $items['user_id'];
    $question->created_at = time();
    $question->content = $items['content'];
    if($question->save())
    {
        if(isset($items['childs']))
        {
            foreach ($items['childs'] as $key => $value) {
                if(!empty($value['question']))
                {
                    $question_sub = new QuestionCardMuti();
                    $question_sub->lesson_id = $items['lesson_id'];
                    $question_sub->course_id = $items['course_id'];
                    $question_sub->user_id = $items['user_id'];                    
                    $question_sub->question_id = $question->id;
                    $question_sub->parent_id = $question->id;
                    $question_sub->question = $value['question'];
                    $question_sub->question_after = $value['question_after'];
                    $question_sub->explain_before = $value['explain_before'];
                    $question_sub->explain_after = $value['explain_after'];
                    $question_sub->img_before = $value['img_before'];
                    $question_sub->img_after = $value['img_after'];
                    $question_sub->create_at = time();
                    $question_sub->save();
                    if(isset($value['childs']) && count($value['childs'])  > 0)
                    {
                        foreach($value['childs'] as $key_child => $value_child)
                        {
                            $question_sub_child = new QuestionCardMuti();
                            $question_sub_child->lesson_id = $items['lesson_id'];
                            $question_sub_child->course_id = $items['course_id'];
                            $question_sub_child->user_id = $items['user_id'];
                            $question_sub_child->question_id = $question->id;
                            $question_sub_child->parent_id = $question_sub->id;
                            $question_sub_child->question = $value_child['question'];
                            $question_sub_child->question_after = $value_child['question_after'];
                            $question_sub_child->explain_before = $value_child['explain_before'];
                            $question_sub_child->explain_after = $value_child['explain_after'];
                            $question_sub_child->img_before = $value_child['img_before'];
                            $question_sub_child->img_after = $value_child['img_after'];
                            $question_sub_child->create_at = time();
                            $question_sub_child->save();
                        }
                    }
                }
            }
        }
    }

}
protected function _formatFlashCard($items)
{
    $content = '';
    $question_after = '';
    $question_before = '';
    $explain_after = '';
    $explain_before = '';
    $img_before = '';
    $img_after = '';
    foreach ($items as $key => $text) {
        if (strpos($text, '#f.') !== false) {
            $content = str_replace('#f.','',$text);
            $content = $this->_detectMathLatex($content);
        }
        if (strpos($text, '$b.') !== false) {
            $question_after = str_replace('$b.','',$text);
            $question_after = $this->_detectMathLatex($question_after);
        }
        if (strpos($text, '$f.') !== false) {
            $question_before = str_replace('$f.','',$text);
            $question_before = $this->_detectMathLatex($question_before);
        }
        if (strpos($text, '$bh.') !== false) {
            $explain_after = str_replace('$bh.','',$text);
            $explain_after = $this->_detectMathLatex($explain_after);
        }
        if (strpos($text, '$fh.') !== false) {
            $explain_before = str_replace('$fh.','',$text);
            $explain_before = $this->_detectMathLatex($explain_before);
        }
        if (strpos($text, '$fi.') !== false) {
            $img_before = str_replace('$fi.','',$text);
        }
        if (strpos($text, '$bi.') !== false) {
            $img_after = str_replace('$bi.','',$text);
        }
    }
    return array(
        'content'=>$content,
        'question_after'=>$question_after,
        'question_before'=>$question_before,
        'explain_after'=>$explain_after,
        'explain_before'=>$explain_before,
        'img_after'=>$img_after,
        'img_before'=>$img_before,
    );
}
protected function _detectMathLatex($text,$type = '')
{
    if($type == 'doan_van')
        {
            if (strpos($text, '$') !== false)
            {
                $pattern = '/\\$(.*?)\\$/';
                        $content = preg_replace_callback($pattern, function($m){
                            return "<span class='math-tex'>\($m[1]\)</span>";
                        },$text);
                $text = $content;        
            }
        }else{
            if (strpos($text, '$') !== false)
            {
                $pattern = '/\\$(.*?)\\$/';
                        $content = preg_replace_callback($pattern, function($m){
                            return '<span class="math-tex">\('.$m[1].'\)</span>';
                        },$text);
                $text = $content;        
            }
        }    
    return $text;
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
}
