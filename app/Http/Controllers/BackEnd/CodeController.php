<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CodeController extends AdminBaseController
{
    private $prefix = [
        1   => '000000000',
        2   => '00000000',
        3   => '0000000',
        4   => '000000',
        5   => '00000',
        6   => '0000',
        7   => '000',
        8   => '00',
        9   => '0',
        10  => '',
    ];

    public function listCode() {
        $var['page_title']      = 'Quản lý mã code';
        if (Auth::user()['level'] != 6) {
            return redirect()->route('dashboard');
        }
        $search_code   = Request::capture()->input('search_code', 0);
        if ($search_code) {
            $code = Code::where('code', 'LIKE', '%'.$search_code.'%');
            $var['search_code']     = $search_code;
        } else {
            $code = new Code();
        }


        $var['code']    = $code->select('*','code.code as cCode','user_code_log.create_at as dateActive')
            ->leftJoin('user_code_log','user_code_log.code_id', '=', 'code.id')
            ->leftJoin('users','users.id', '=', 'user_code_log.user_id')
            ->orderBy('code.created_at', 'DESC')->paginate(20);
        return view('backend.code.list', $var);
    }

    public function handle(Request $request) {
        $quantity   =   $request->input('quantity', 0);
        $excel      =   $request->input('excel', 0);
        $price      =   str_replace('.','', $request->input('price', 0));
        $end_date   =  trim($request->input('end_date', ''));

        $row = [];
        $i = 0;
        while ($i < $quantity) {
            $code  = rand(100,999).rand(100,999).rand(100,999).rand(100,999).rand(100,999);
            $insert = [
                'code'          => $code,
                'price'         => $price,
                'status'        => 0, //chưa sử dụng
                'created_at'    => time(),
                'end_date'      => $end_date ? strtotime($end_date) : 0
            ];
            if (!$old = Code::where('code', '=', $code)->select('id')->first()) {
                $id = Code::insertGetId($insert);
                $insert['serial']   = $this->prefix[strlen($id)].$id;
                $row[$id]           = $insert;
                $i++;
            }
        }

        if ($excel) {
            Excel::create('ListCode', function ($excel) use ($row) {
                $excel->sheet('sheet', function ($sheet) use ($row) {
                    $sheet->setColumnFormat(array(
                        'A' => '@',
                        'B' => '@',
                        'C' => '@',
                        'D' => '@',
                    ));
                    $var['code'] = $row;
                    $sheet->loadView('backend.code.excel', $var);
                });
            })->download('xlsx');
        }
        return redirect()->back();
    }
}
