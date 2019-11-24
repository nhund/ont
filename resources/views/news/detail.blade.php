@extends('layout')
@section('content')
    @push('css')
        <link href='{{ web_asset('public/css/styles-new.css') }}' rel='stylesheet' type='text/css'  media='all'/>
    @endpush
<main>
    <div class="header-navigate clearfix mb15">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                    <ol class="breadcrumb breadcrumb-arrow">
                        <li><a href="{{route('home')}}" target="_self">Trang chủ</a></li>
                        <li><i class="fa fa-angle-right"></i></li>
                        <li><a href="{{route('news', ['cate-id='. $var['news']->category_id])}}" target="_self">Tin tức</a></li>
                        <li><i class="fa fa-angle-right"></i></li>
                        <li>{!! substr($var['news']->name, 0, 50) !!} ...</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="wrap-detail">
            <div class="wrap-left">
                <div class="title-label">{{$var['news']->name}}</div>
                <div class="detail-news">
                    {!! $var['news']->content !!}
                </div>

                <div class="other">
                    <h3 class="title-tlt">Bài viết liên quan</h3>
                    @if(!empty($var['relatedPosts']))
                        <div class="other-news-fl">
                            <ul>
                                @foreach($var['relatedPosts'] as $data)
                                    <li>
                                        <div class="other-box">
                                            <a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}">
                                                <img src="{{ asset('/public/images/news/'.$data->id.'/480_320/'.$data->avatar)}}" title="{{$data->name}}"></a>
                                            <h4 class="other-title"><a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}">{!! substr($data->name, 0, 120) !!}...</a></h4>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="wrap-right">
                <div class="slidebar">
                    <h3 class="title-tlt">Bài viết xem nhiều nhất</h3>
                    @if(!empty($var['newsView']))
                        <ul class="posts-viewed">
                            @foreach($var['newsView'] as $data)

                                <li>
                                    <div class="posts-thumb">
                                        <a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}">
                                            <img src="{{ asset('/public/images/news/'.$data->id.'/480_320/'.$data->avatar)}}">
                                        </a>
                                    </div>
                                    <div class="posts-txt">
                                        <a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}">{!! ucfirst(substr($data->name, 0, 120))!!}...</a>
                                        <p>Ngày cập nhật: 14:06 22/10/2019</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <ul class="advertisement">
{{--                    <li><a href="#"><img src="images/add-img.png"></a></li>--}}
                </ul>
            </div>
        </div>
    </div>
</main>
@stop