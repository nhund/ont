<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\CategoryNews;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends AdminBaseController
{
    protected $_category;

    public function index(){

        $limit = 20;
        $posts = Post::orderBy('id','DESC')->paginate($limit);
        $var['posts'] = $posts;
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.post.index'),
                'title' => 'Danh sách bài viết',
            ),
        );
        //dd($schools);
        return view('backend.post.index',compact('var'));
    }
    public function add()
    {
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.post.index'),
                'title' => 'Danh sách bài viết',
            ),
            array(
                'url'=> route('admin.post.add'),
                'title' => 'Thêm bài viết',
            )
        );
        $_category = CategoryNews::where('status', CategoryNews::STATUS_ON)->orderby('id', 'DESC')->get();
        return view('backend.post.add',compact(['var', '_category']));
    }
    public function save(Request $request)
    {
        $data = $request->all();
        // if (empty($data['avatar'])) {
        //     alert()->error('Có lỗi','Cần tải lên ảnh đại diện');
        //     return redirect()->route('admin.user_feel.add');
        // }
        $post = new Post();      
        $post->name = $data['name'];
        $post->category_id = $data['category_id'];
        $post->content = $data['content'];       
        $post->status = $data['status'];
        if (!empty($data['category_id'])){
            $post->type = 'news';
        }
        $post->create_date = time();
        if($post->save())
        {
            //Helper::thumbImages($name,$avatar,600,600,'fit',$destinationPath.'/600_600');
            alert()->success('Thông báo','Thêm dữ liệu thành công');
            return redirect()->route('admin.post.index');
        }else{
            alert()->error('Có lỗi','Thêm dữ liệu không thành công');
            return redirect()->route('admin.post.add');
        }
    }
    public function edit($id,Request $request)
    {
        $post = Post::find($id);
        $var['breadcrumb'] = array(
            array(
                'url'=> route('admin.post.index'),
                'title' => 'Danh sách bài viết',
            ),
            array(
                'url'=> route('admin.post.edit',['id'=>$id]),
                'title' => 'Sửa : '.$post->name,
            )
        );
        $var['post'] = $post;

        $_category = CategoryNews::where('status', CategoryNews::STATUS_ON)->orderby('id', 'DESC')->get();
        return view('backend.post.edit',compact('var', '_category'));
    }
    public function update(Request $request)
    {
       $data = $request->all();
       if(!isset($data['id']))
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.school.index');
       }
       $post = Post::find($data['id']);
       if(!$post)
       {
           alert()->error('Có lỗi','Dữ liệu không tồn tại');
           return redirect()->route('admin.post.index');
       }
        $post->name = $data['name'];
        $post->category_id = $data['category_id'];
        $post->content = $data['content'];       
        $post->status = $data['status'];
        if (!empty($data['category_id'])){
            $post->type = 'news';
        }
        $post->update_date = time();
        $post->save();
       alert()->success('Thông báo','Cập nhật thành công');
       return redirect()->route('admin.post.index');
    }
    public function delete(Request $request)
    {
        $data = $request->all();
        if(!isset($data['id']))
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        $post = Post::find($data['id']);
        if(!$post)
        {
            return response()->json(array('error' => true, 'msg' => 'Dữ liệu không tồn tại'));
        }
        //$avatar = $partner->img;        
        if($post->delete())
        {
            //Helper::removeFolder(public_path($avatar));
            //Helper::removeFolder(public_path($avatar_thumb));
            return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
        }
        return response()->json(array('error' => false, 'msg' => 'Xóa dữ liệu thành công'));
    }
}
