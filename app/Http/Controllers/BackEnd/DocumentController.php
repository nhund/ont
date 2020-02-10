<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class DocumentController extends AdminBaseController
{
    private function checkPermission($id) {
        if (!$id || !$course = Course::find($id)) {
            return false;
        }
        if ($course['user_id'] != Auth::user()['id']) {
            return false;
        }
        return $course;
    }

    public function listDocument($id) {
        $course             = $this->checkPermission($id);
        if (!$course) {
            return redirect()->route('dashboard');
        }
        $var['page_title']  = 'Tài liệu khóa học '.$course['name'];
        $var['course']      = $course;
        $var['documents']   = Document::where('course_id', $id)->paginate(20);
        return view('backend.document.list', $var);
    }

    public function handle(Request $request) {
        $id             = $request->input('id', 0);
        $description    = trim($request->input('description', ''));
        $content        = trim($request->input('content', ''));
        $title          = trim($request->input('title', ''));
        $avatar         = $request->file('avatar', 0);
        $document       = $request->file('document');
        $course_id      = $request->input('course_id', 0);

        if ($id) {
            $doc = Document::find($id);
        } else {
            $doc = new Document();
            $doc->user_id       = Auth::user()['id'];
            $doc->created_at    = time();
        }

        $doc->description   = $description;
        $doc->title         = $title;
        $doc->content       = $content;
        $doc->course_id     = $course_id;
        $doc->updated_at    = time();
        if ($avatar) {
            if ($doc->avatar && file_exists('public/document/avatar/'.$doc->avatar)) {
                unlink('public/images/course/'.$doc->avatar);
            }
            $destinationPath = public_path('/document/avatar');
            $imgName         = str_replace('.'.$avatar->getClientOriginalExtension(),'', $avatar->getClientOriginalName()).time().'.'.$avatar->getClientOriginalExtension();
            $avatar->move($destinationPath, $imgName);
            $doc->avatar  = $imgName;
        }
        if ($document) {
            if ($doc->document && file_exists('public/document/file/'.$doc->document)) {
                unlink('public/images/course/'.$doc->document);
            }
            $destinationPath = public_path('/document/file');
            $documentName    = str_replace('.'.$document->getClientOriginalExtension(),'', $document->getClientOriginalName()).time().'.'.$document->getClientOriginalExtension();
            $document->move($destinationPath, $documentName);
            $doc->document  = $documentName;
        }
        $doc->save();

        return redirect()->back();
    }

    public function getDownload($id)
    {
        $doc = Document::find($id);
        $doc->download = ($doc->download ? $doc->download : 0) + 1;
        $file= public_path(). "/document/file/".$doc->document;
        $doc->save();
        return Response::download($file, $doc->document);
    }

    public function infor(Request $request) {
        $id = $request->input('id', 0);
        $doc = Document::find($id);
        if (!$doc || $doc->user_id != Auth::user()['id'] && Auth::user()['level'] != 6) {
            return response()->json(['status' => 0, 'msg' => 'Bạn không có quyền thực hiện chức năng này']);
        }
        $var['document'] = $doc;
        $tpl = view('backend.document.form', $var)->render();
        return response()->json(['status' => 1, 'tpl' => $tpl]);
    }

    public function delete($id) {
        $doc = Document::find($id);
        if (!$doc) {
            return redirect()->route('dashboard');
        }
        if ($doc->user_id != Auth::user()['id'] && Auth::user()['level'] != 6) {
            return redirect()->route('dashboard');
        }
        unlink($file= public_path(). "/document/file/".$doc->document);
        $doc->delete();
        return redirect()->back();
    }
}
