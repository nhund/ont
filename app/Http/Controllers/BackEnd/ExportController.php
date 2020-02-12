<?php

namespace App\Http\Controllers\BackEnd;

use App\Exports\QuestionExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Lesson;

class ExportController extends AdminBaseController
{
    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Maatwebsite\Excel\BinaryFileResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportQuestion($id, Request $request)
    {        
        if(!isset($id))
        {
            alert()->error('Thông báo','Xuất dữ liệu không thành công');
            return redirect()->route('dashboard');
        }
        $lesson = Lesson::find($id);
        if(!$lesson) {
            alert()->error('Thông báo','Xuất dữ liệu không thành công');
            return redirect()->route('dashboard');
        }
        return Excel::download(new QuestionExport($id, $request->get('part')), str_slug($lesson->name).'.xlsx');
    }
}
