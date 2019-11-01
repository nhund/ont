<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\CategoryNews;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function news(Request $request){

        $data = $request->all();
        $limit = 20;
        $var = [];
        $var['params'] = [];
        if(isset($data['cate-id']) && $data['cate-id'] !== '')
        {
            $var['params']['cate-id'] = explode(',',$data['cate-id']);
            $var['cate'] = CategoryNews::find($data['cate-id']);
            //posts by category
            $var['postbyCate'] = Post::where('category_id', $data['cate-id'])
                ->where('feature', '!=', 1)
                ->where('status', Post::STATUS_ON)
                ->orderBy('id','DESC')
                ->paginate($limit);

            //post with feature == 1 anh feature_hot != 1
            $var['featurePost'] = Post::where('category_id', $data['cate-id'])
                ->where('feature', 1)
                ->orderBy('id', 'DESC')
                ->where('status', Post::STATUS_ON)->take(2)->get();

            //post feature_hot == 1
            $var['featureHot'] =  Post::where('category_id', $data['cate-id'])
            ->where('feature', 1)
            ->where('status', Post::STATUS_ON)->take(1)->orderBy('id','DESC')->first();


            return view('news.category', compact('var'));
        }

        $var['newsfeatureHot'] = Post::where('feature', 1)
            ->where('status', Post::STATUS_ON)->take(1)->orderBy('id','DESC')->first();

        $var['newsfeature'] = Post::where('feature', 1)
            ->where('status', Post::STATUS_ON)->take(5)->orderBy('id','DESC')->get();

        $var['newsfeatureOther'] = Post::where('feature', 1)
            ->where('status', Post::STATUS_ON)->orderBy('id','DESC')->get();
        //TODO
        return view('news.index' , compact('var'));
    }

    /**
     * @param $title
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function newsDetail($title, $id){

        $news = Post::find($id);
        if (!$news)
            return redirect()->route('home');
        $var = [];

        $var['news'] = $news;

        //related posts
        $var['relatedPosts'] = Post::where('category_id', $var['news']->category_id)
            ->where('id', '!=', $var['news']->id)
            ->where('status', Post::STATUS_ON)
            ->take(3)->get();

        $var['newsView'] = Post::where('type', 'news')
            ->where('id', '!=', $var['news']->id)
            ->where('status', Post::STATUS_ON)
            ->orderBy('id', 'DESC')
            ->take(6)->get();
        return view('news.detail', compact('var'));
    }

    public function detail($title,$id)
    {
        $post = Post::find($id);
        if(!$post)
        {

            return redirect()->route('home');
        }
        $var = [];
        $var['post'] =  $post;       
        return view('post.detail',$var);
    }    
}
