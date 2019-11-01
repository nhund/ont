<?php

namespace App\Http\Controllers\BackEnd;

use App\Helpers\Helper;
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
        $post = new Post();
        $post->name = $data['name'];
        $post->category_id = $data['category_id'];
        $post->content = $data['content'];
        $post->des = $data['des'];
        $post->status = $data['status'];
        if (!empty($data['category_id'])) {
            $post->type = 'news';
            $post->feature = $data['feature'];
        }
        $post->create_date = time();
        $hasError = false;

        // if have image
        if ($request->hasFile('avatar') && $post->save()){

            $avatar = $request->file('avatar');

            if (!in_array($avatar->clientExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp'])) {
                $hasError = true;
            }
            if ($avatar->getClientSize() > 2048000) {
                $hasError = true;
            }
            if (!$hasError) {
                $name = time().'_'.str_slug($avatar->getClientOriginalName()).'.'.$avatar->getClientOriginalExtension();
                $path = 'images/news/'.$post->id;
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777);
                }
                $avatar->move($destinationPath, $name);
                $avatar = 'public/images/news/'.$post->id.'/'.$name;
                $post->avatar  = $name;
                $post->avatar_path  = $path;
                Helper::thumbImages($name, $avatar, 480, 320, 'fit', $destinationPath . '/480_320');
            }
        }

        if ($post->save()){
            alert()->success('Thông báo', 'Thêm dữ liệu thành công');
            return redirect()->route('admin.post.index');
        }
        else {
            alert()->error('Có lỗi', 'Thêm dữ liệu không thành công');
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
        $post->des = $data['des'];
        $post->content = $data['content'];
        $post->status = $data['status'];
        if (!empty($data['category_id'])){
            $post->type = 'news';
            $post->feature = $data['feature'];
        }

        if ($request->hasFile('avatar')){
            $avatar = $request->file('avatar');

            $hasError = false;

            if (!in_array($avatar->clientExtension(), ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp'])) {
                $hasError = true;
            }
            if ($avatar->getClientSize() > 2048000) {
                $hasError = true;
            }
            if (!$hasError) {
                $name = time().'_'.str_slug($avatar->getClientOriginalName()).'.'.$avatar->getClientOriginalExtension();
                $path = '/images/news/'.$post->id;
                $destinationPath = public_path($path);
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $avatar->move($destinationPath, $name);
                $avatar = 'public/images/news/'.$post->id.'/'.$name;
                $post->avatar  = $name;
                $post->avatar_path  = $path;
                if ($post->save()) {
                    Helper::thumbImages($name, $avatar, 480, 320, 'fit', $destinationPath . '/480_320');
                }
            }
        }
        $post->update_date = time();

        if ($post->save()){
            alert()->success('Thông báo','Cập nhật thành công');
            return redirect()->route('admin.post.index');
        }else{
            alert()->error('Có lỗi', 'Cập nhật dữ liệu không thành công');
            return redirect()->route('admin.post.add');
        }
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
