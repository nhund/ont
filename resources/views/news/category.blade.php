@extends('layout')
@section('content')
    @push('css')
        <link href='{{ web_asset('public/css/styles-new.css') }}' rel='stylesheet' type='text/css'  media='all'/>
    @endpush
    <main class="box-body-container">
        <div class="header-navigate clearfix mb15">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                        <ol class="breadcrumb breadcrumb-arrow">
                            <li><a href="{{route('home')}}" target="_self">Trang chủ</a></li>
                            <li><i class="fa fa-angle-right"></i></li>
                            <li>Tin tức</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="content-d-flex">
                <div class="col-left">
                    <div class="box-content">
                        <div class="wrap-main">
                            @if(count($var['featureNewses']))
                                <div class="news-main">
                                    <a href="{{route('news.detail',[str_slug($var['featureNewses'][0]->name, '-'), $var['featureNewses'][0]->id])}}">
                                        <img src="{{ $var['featureNewses'][0]->thumbnail}}"></a>
                                    <h2 class="tlt"><a href="{{route('news.detail',[str_slug($var['featureNewses'][0]->name, '-'), $var['featureNewses'][0]->id])}}">{{ucfirst($var['featureNewses'][0]->name)}}</a></h2>
                                    <p class="update-news"><span><a href="{{route('news', ['cate-id' => $var['featureNewses'][0]->category_id])}}">{{$var['featureNewses'][0]->category->name}}</a></span> - {{$var['featureNewses'][0]->created_at}}</p>
                                    <p>{!! substr($var['featureNewses'][0]->content, 0, 200) !!}</p>
                                </div>
                                    @if(count($var['featureNewses']) > 1)
                                        <div class="news-lst">
                                            <ul class="lst-top-fl">
                                                @foreach($var['featureNewses'] as $index => $featureNews)
                                                    @if($index > 0)
                                                    <li>
                                                        <a href="{{route('news.detail',[str_slug($featureNews->name, '-'),$featureNews->id])}}">
                                                            <img src="{{ $featureNews->thumbnail }}" title="{{$featureNews->name}}"></a>
                                                        <h3 class="tlt"><a href="{{route('news.detail',[str_slug($featureNews->name, '-'), $featureNews->id])}}">{{ ucfirst($featureNews->name) }}</a></h3>
                                                    </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                            @endif

                        </div>
                        <div class="news">
                            <ul>
                                @if(isset($var['postbyCate']) && count($var['postbyCate']) > 0)
                                    @foreach ($var['postbyCate'] as $data)
                                        <li>
                                            <div class="news-thumb">
                                                <a href="{{route('news.detail',[str_slug($data->name, '-'),$data->id])}}">
                                                    <img src="{{ asset('/public/images/news/'.$data->id.'/480_320/'.$data->avatar)}}" title="{{$data->name}}"></a>
                                            </div>
                                            <div class="news-txt">
                                                <h3 class="tlt"><a href="{{route('news.detail',[str_slug($data->name, '-'),$data->id])}}">{{ucfirst($data->name)}}</a></h3>
                                                <p>{!! substr($data->content, 0, 200) !!}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                            <ul>
                                {{ $var['postbyCate']->appends(Request::except('page'))->render() }}
                            </ul>
                        </div>

                    </div>
                </div><!-- //col-right -->
                <div class="col-right">
                    <ul class="advertisement">
{{--                        <li><a href="#"><img src="images/add-img.png"></a></li>--}}
                    </ul>
                </div><!-- //col-left -->
            </div>
        </div>
    </main>
@stop