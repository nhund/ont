<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Imports\QuestionImport;
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
        $file  = $request->file('upload');
        if (!$file) {
            return response()->json([
                                        'error' => true,
                                        'msg'   => 'Thêm dữ liệu không thành công',
                                        'data'  => []
                                    ]);
        }
        if (!Auth::check()) {
            return response()->json(array('error' => true, 'type' => 'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        //dd($file->getClientSize());
        $check_file = $file->getClientOriginalExtension();
        $size       = $file->getClientSize();
        if ($size > 5242880) {
            return response()->json([
                                        'error' => true,
                                        'msg'   => 'File không được quá 5mb',
                                        'data'  => []
                                    ]);
        }
        //dd($file);
        if ($file) {
            $hasError = false;
            if (!in_array($file->clientExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp'])) {
                $hasError = true;
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

                $name            = time() . '_' . str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path            = '/images/post';
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }

                $file->move($destinationPath, $name);
                $image = '/public' . $path . '/' . $name;
                return response()->json(array('error' => false, 'msg' => 'tải file thành công', 'fileName' => $name, 'uploaded' => true, 'url' => $image));
            }
        }

    }

    public function importImageCkeditor(Request $request)
    {
        $input = $request->all();
        $file  = $request->file('upload');
        if (!$file || !$input['course_id']) {
            return response()->json([
                                        'error' => true,
                                        'msg'   => 'Thêm dữ liệu không thành công',
                                        'data'  => []
                                    ]);
        }
        if (!Auth::check()) {
            return response()->json(array('error' => true, 'type' => 'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        //dd($file->getClientSize());
        $check_file = $file->getClientOriginalExtension();
        $size       = $file->getClientSize();
        if ($size > 5242880) {
            return response()->json([
                                        'error' => true,
                                        'msg'   => 'File không được quá 5mb',
                                        'data'  => []
                                    ]);
        }
        //dd($file);
        if ($file) {
            $hasError = false;
            if (!in_array($file->clientExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp'])) {
                $hasError = true;
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

                $name            = time() . '_' . str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path            = '/images/course/' . $input['course_id'];
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $pathDetail      = '/images/course/' . $input['course_id'] . '/lesson';
                $destinationPath = public_path($pathDetail);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $file->move($destinationPath, $name);
                $image = '/public' . $pathDetail . '/' . $name;
                return response()->json(array('error' => false, 'msg' => 'tải file thành công', 'fileName' => $name, 'uploaded' => true, 'url' => $image));
            }
        }

    }

    public function importImage(Request $request)
    {
        $input = $request->all();
        $file  = $request->file('file');
        if (!$file || !$input['course_id']) {
            return response()->json([
                                        'error' => true,
                                        'msg'   => 'Thêm dữ liệu không thành công',
                                        'data'  => []
                                    ]);
        }
        if (!Auth::check()) {
            return response()->json(array('error' => true, 'type' => 'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        //dd($file->getClientSize());
        $check_file = $file->getClientOriginalExtension();
        $size       = $file->getClientSize();
        if ($size > 5242880) {
            return response()->json([
                                        'error' => true,
                                        'msg'   => 'File không được quá 5mb',
                                        'data'  => []
                                    ]);
        }
        //dd($file);
        if ($file) {
            $hasError = false;
            if (!in_array($file->clientExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp'])) {
                $hasError = true;
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

                $name            = time() . '_' . str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path            = '/images/course/' . $input['course_id'];
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $pathDetail      = '/images/course/' . $input['course_id'] . '/question';
                $destinationPath = public_path($pathDetail);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $file->move($destinationPath, $name);
                $image = '/public' . $pathDetail . '/' . $name;
                return response()->json(array('error' => false, 'msg' => 'tải file thành công', 'file' => $image));
            }
        }

    }

    public function importAudio(Request $request)
    {
        $input = $request->all();
        $file  = $request->file('file');
        if (!$file || !$input['course_id']) {
            return response()->json([
                                        'error' => true,
                                        'msg'   => 'Thêm dữ liệu không thành công',
                                        'data'  => []
                                    ]);
        }
        if (!Auth::check()) {
            return response()->json(array('error' => true, 'type' => 'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        //dd($file->getClientSize());
        $check_file = $file->getClientOriginalExtension();
        $size       = $file->getClientSize();
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

                $name            = time() . '_' . str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path            = '/file/audio/' . $input['course_id'];
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $file->move($destinationPath, $name);
                $audio = '/public/file/audio/' . $input['course_id'] . '/' . $name;
                return response()->json(array('error' => false, 'msg' => 'tải file thành công', 'file' => $audio));
            }
        }

    }

    public function importCourse(Request $request)
    {

        $input = $request->all();
        $file  = $request->file('file');
        if (!$file || !isset($input['lesson_id'])) {
            return response()->json([
                'error' => true,
                'msg'   => 'Thêm dữ liệu không thành công',
                'data'  => []
            ]);
        }
        if (!Auth::check()) {
            return response()->json(array('error' => true, 'type' => 'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        //dd($file->getClientSize());
        $check_file = $file->getClientOriginalExtension();
        $size       = $file->getClientSize();
        if ($size > 5242880) {
            return response()->json([
                'error' =>true,
                'msg'   => 'File không được quá 5mb',
                'data'  =>  []
            ]);
        }

        if ($check_file != 'xlsx') {
            return response()->json([
                'error' => true,
                'msg'   => 'File không đúng định dạng',
                'data'  => []
            ]);
        }
        $data['lesson_id'] = $input['lesson_id'];
        $data['course_id'] = 0;
        $data['user_id']   = $user->id;
        $lesson            = Lesson::find($data['lesson_id']);
        if ($lesson) {
            $data['course_id'] = $lesson->course->id;
        }

        $data_excel = Excel::import(new QuestionImport($data), $file);

        return response()->json(array('error' => true, 'msg' => 'Thêm dữ liệu không thành công'));
    }



    public function test()
    {
        $file = public_path('file/test.xlsx');
        $data = Excel::load($file, function ($reader) {
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
        $data = Excel::load($file, function ($reader) {
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
