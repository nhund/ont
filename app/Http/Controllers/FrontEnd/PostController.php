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
        $limit = 10;
        $var['params'] = [];
        if(isset($data['cate-id']) && $data['cate-id'] !== '')
        {
            $var['params']['cate-id'] = explode(',',$data['cate-id']);
            $var['cate'] = CategoryNews::findOrFail($data['cate-id']);

            //post feature_hot == 1
             $newsFeature =  Post::where('category_id', $var['cate']->id)
                 ->where('type', Post::NEWS)
                 ->where('status', Post::STATUS_ON)->take(3)
                 ->orderBy('feature', 'DESC')
                 ->orderBy('id','DESC');

            $var['featureNewses'] = $newsFeature->get();

            //posts by category
            $var['postbyCate'] = Post::where('category_id', $data['cate-id'])
                ->where('type', Post::NEWS)
                ->whereNotIn('id', $newsFeature->pluck('id'))
                ->where('status', Post::STATUS_ON)
                ->orderBy('id','DESC')
                ->paginate($limit);

            return view('news.category', compact('var'));
        }

        $newsFeatureHot = Post::where('status', Post::STATUS_ON)
            ->where('type', Post::NEWS)
            ->limit(5)
            ->orderBy('feature','DESC')
            ->orderBy('id','DESC')
            ;

        $var['newsFeature'] = $newsFeatureHot->get();

        $var['otherNewsFeature'] = Post::where('status', Post::STATUS_ON)
            ->whereNotIn('id', $newsFeatureHot->pluck('id'))
            ->where('type', Post::NEWS)
            ->limit(5)
            ->orderBy('feature','DESC')
            ->orderBy('id','DESC')
            ->get();

        $var['otherNews'] = Post::where('status', Post::STATUS_ON)
            ->where('type', Post::NEWS)
            ->limit(5)
            ->orderBy('update_date','DESC')
            ->get();

        $var['newsCategories'] = CategoryNews::where('status', CategoryNews::STATUS_ON)
            ->whereHas('news')
            ->with(['news' => function ($q){
                $q->orderBy('create_date', 'DESC')->limit(5);
            }])->get();

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
        $var['post'] =  $post;
        return view('post.detail',$var);
    }    
}
