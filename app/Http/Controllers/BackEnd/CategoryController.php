<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use App\User;
use App\Models\Category;
class CategoryController extends AdminBaseController
{
    public function index(){

        $limit = 20;
        $categories = Category::orderBy('id','DESC')->paginate($limit);
        $var['categories'] = $categories;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.category.index'),
                'title' => 'Danh sách chuyên mục',
            ),
        );
        return view('backend.category.index',compact('var'));
    }
    public function add()
    {
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.category.index'),
                'title' => 'Danh sách Chuyên mục',
            ),
            array(
                'url'=> route('admin.category.add'),
                'title' => 'Thêm chuyên mục ',
            )
        );
        return view('backend.category.add',compact('var'));
    }
    public function save(Request $request)
    {
        $data = $request->all();
        $category = new Category();
        $category->name = $data['name'];
        $category->status = $data['status'];
        $category->type = $data['type'];
        $category->create_at = time();    
        if($category->save())
        {            
            alert()->success('Thông báo','Thêm dữ liệu thành công');
            return redirect()->route('admin.category.index');
        }else{
            alert()->error('Có lỗi','Thêm dữ liệu không thành công');
            return redirect()->route('admin.category.add');
        }
    }
    public function edit($id,Request $request)
    {
        $category = Category::find($id);
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.category.index'),
                'title' => 'Danh sách chuyên mục',
            ),
            array(
                'url'=> route('admin.category.edit',['id'=>$id]),
                'title' => 'Sửa : '.$category->id,
            )
        );
        $var['category'] = $category;
        return view('backend.category.edit',compact('var'));
    }
    public function update(Request $request)
    {
       $data = $request->all();
       if(!isset($data['id']))
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.category.index');
       }
       $category = Category::find($data['id']);
       if(!$category)
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.category.index');
       }
        $category->name = $data['name'];        
        $category->status = $data['status'];
        $category->save();
       alert()->success('Thông báo','Cập nhật thành công');
       return redirect()->route('admin.category.index');
    }
    public function delete(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $category = Category::find($data['id']);
        if(!$category)
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        //$avatar = $slider->img;        
        if($category->delete())
        {        
            return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
        }
        return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
    }
}
