@extends('layout')
@section('content')
    @push('css')
        <link href='{{ web_asset('public/css/slick.css') }}' rel='stylesheet' type='text/css'  media='all'/>
        <link href='{{ web_asset('public/css/styles-new.css') }}' rel='stylesheet' type='text/css'  media='all'/>
    @endpush
<main class="box-body-container">
    <div class="header-navigate clearfix mb15">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                    <ol class="breadcrumb breadcrumb-arrow">
                        <li><a href="#" target="_self">Trang chủ</a></li>
                        <li><i class="fa fa-angle-right"></i></li>
                        <li><a href="#" target="_self">Tin tức</a></li>
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
                        <div class="news-main">
                            @if(count($var['newsFeature']) > 0)
                                <img src="{{ $var['newsFeature'][0]->thumbnail}}" title="{{$var['newsFeature'][0]->name}}"/>
                                <h2 class="tlt"><a href="{{route('news.detail',[str_slug($var['newsFeature'][0]->name, '-'), $var['newsFeature'][0]->id])}}">{{$var['newsFeature'][0]->name}}</a></h2>
                                <p class="update-news"><span><a href="{{route('news', ['cate-id' => $var['newsFeature'][0]->category_id])}}">{{$var['newsFeature'][0]->category->name}}</a></span> - {{$var['newsFeature'][0]->created_at}}</p>
                                <p>{{$var['newsFeature'][0]->des}}</p>
                            @endif
                        </div>
                        <div class="news-lst">
                            <ul class="lst-top">
                                @if(count($var['newsFeature']) > 1)
                                    @foreach($var['newsFeature'] as $index => $data)
                                        @if($index > 0)
                                        <li><a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}" title="{{$data->name}}">{{$data->name}}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    @if(count($var['otherNewsFeature']))
                        <div class="other-news">
                            <h3 class="tlt">Tin nổi bật khác</h3>
                            <div class="slider responsive slider-news-fl">
                                    @foreach($var['otherNewsFeature'] as $data)
                                        <div>
                                            <div class="slider-news">
                                                <a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}">
                                                    <img src="{{$data->thumbnail}}"  title="{{$data->name}}"/></a>
                                                <h4 class="tlt-tltle"><a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}">{{$data->name}}</a></h4>
                                                <p><a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}">Xem thêm <i class="fa fa-angle-right"></i></a></p>
                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                    @endif

                @foreach($var['newsCategories'] as $newsCategory)
                    @if(strtolower($newsCategory->name) != 'các tin khác')
                    <div class="group-news">
                           <h3 class="title-tlt">{!! $newsCategory->name !!}</h3>
                           <div class="group-news-fl">
                               <div class="group-left">
                                   @if($newsCategory->news)
                                       <div class="group-news-main">
                                           <a href="#"><img src="{{$newsCategory->news[0]->thumbnail}}"></a>
                                           <h4 class="tlt"><a href="#">{!! $newsCategory->news[0]->name !!}</a></h4>
                                           <p>{!! $newsCategory->news[0]->des !!}</p>
                                       </div>
                                   @endif
                               </div>
                               <div class="group-right">
                                   <ul>
                                       @if(count($newsCategory->news) > 1)
                                           @foreach($newsCategory->news as $index => $posting)
                                               @if($index > 0)
                                                   <li>
                                                       <div><a  href="{{route('news.detail',[str_slug($posting->name, '-'), $posting->id])}}"><img src="{{$posting->thumbnail}}"></a></div>
                                                       <h4 class="tlt"><a href="{{route('news.detail',[str_slug($posting->name, '-'), $posting->id])}}">{!! substr($posting->name, 0, 120) !!}...</a></h4>
                                                   </li>
                                               @endif
                                           @endforeach
                                       @endif
                                   </ul>
                               </div>
                           </div>
                    </div>
                    @else
                        <div class="group-news group-other-news">
                            <h3 class="title-tlt">Các tin khác</h3>
                            <div class="other-news-fl">
                                <ul>
                                    @if(count($newsCategory->news))
                                        @foreach($newsCategory->news as $other)
                                            <li>
                                                <div class="other-box">
                                                    <a href="{{route('news.detail',[str_slug($other->name, '-'), $other->id])}}"><img src="{{$other->thumbnail}}"></a>
                                                    <h4 class="other-title"><a href="{{route('news.detail',[str_slug($other->name, '-'), $other->id])}}">{!! substr($other->name, 0, 120) !!}...</a></h4>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                    @endforeach

                </div>
            </div><!-- //col-right -->
            {{--<div class="col-right">
                <ul class="advertisement">
                    <li><a href="#"><img src="images/add-img.png"></a></li>
                </ul>
            </div><!-- //col-left -->--}}
        </div>

    </div>
</main>
@stop
@push('js')
    <script src='{{ web_asset('public/js/slick.js') }}?v=1' type='text/javascript'></script>
    <script type="text/javascript">
        $('.responsive').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 676,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    </script>
@endpush