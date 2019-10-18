<?php


namespace App\Http\Controllers\BackEnd;


use App\Models\CategoryNews;
use Illuminate\Http\Request;

class CategoryNewsController extends AdminBaseController
{

    /**
     * @method index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @since 2019/10/16
     */
    public function index(){

        $limit = 20;
        $categories = CategoryNews::orderBy('id','DESC')->paginate($limit);
        $var['categories'] = $categories;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.news.index'),
                'title' => 'Danh sách danh mục tin',
            ),
        );
        return view('backend.categorynews.index',compact('var'));
    }


    /**
     * @method add
     * add category news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @since 2019/10/16
     */
    public function add()
    {
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.news.index'),
                'title' => 'Danh sách danh mục tin',
            ),
            array(
                'url'=> route('admin.news.add'),
                'title' => 'Thêm danh mục tin ',
            )
        );
        return view('backend.categorynews.add',compact('var'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $data = $request->all();
        $category = new CategoryNews();
        $category->name = $data['name'];
        $category->status = $data['status'];
        $category->create_at = time();
        if($category->save())
        {
            alert()->success('Thông báo','Thêm dữ liệu thành công');
            return redirect()->route('admin.news.index');
        }else{
            alert()->error('Có lỗi','Thêm dữ liệu không thành công');
            return redirect()->route('admin.news.add');
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id,Request $request)
    {
        $category = CategoryNews::find($id);
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.news.index'),
                'title' => 'Danh sách danh mục',
            ),
            array(
                'url'=> route('admin.news.edit',['id'=>$id]),
                'title' => 'Sửa : '.$category->id,
            )
        );
        $var['category'] = $category;
        return view('backend.categorynews.edit',compact('var'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            alert()->error('Có lỗi','Dữ liệu không tồn tại');
            return redirect()->route('admin.news.index');
        }
        $category = CategoryNews::find($data['id']);
        if(!$category)
        {
            alert()->error('Có lỗi','Dữ liệu không tồn tại');
            return redirect()->route('admin.news.index');
        }
        $category->name = $data['name'];
        $category->status = $data['status'];
        $category->update_at = time();
        $category->save();
        alert()->success('Thông báo','Cập nhật thành công');
        return redirect()->route('admin.news.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $category = CategoryNews::find($data['id']);
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