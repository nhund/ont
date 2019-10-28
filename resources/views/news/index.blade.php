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
                            @if(empty($var['newsfeatureHot']))
                                <a src="{{ asset('/public/images/news/'.$var['newsfeatureHot']->id.'/480_320/'.$var['newsfeatureHot']->avatar)}}" title="{{$var['newsfeatureHot']->name}}"></a>
                                <h2 class="tlt"><a href="{{route('news.detail',[str_slug($var['newsfeatureHot']->name, '-'), $var['newsfeatureHot']->id])}}">{{$var['newsfeatureHot']->name}}</a></h2>
                                <p class="update-news"><span>Tin tuyển dụng</span> - 9 giờ trước</p>
                                <p>{{$var['newsfeatureHot']->des}}</p>
                            @endif
                        </div>
                        <div class="news-lst">
                            <ul class="lst-top">
                                @if($var['newsfeature'])
                                    @foreach($var['newsfeature'] as $data)
                                        <li><a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}" title="{{$data->name}}">{{$data->name}}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="other-news">
                        <h3 class="tlt">Tin nổi bật khác</h3>
                        <div class="slider responsive slider-news-fl">
                            @if($var['newsfeatureOther'])
                                @foreach($var['newsfeatureOther'] as $data)
                                    <div>

                                        <div class="slider-news">
                                            <a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}"><img
                                                        src="{{ asset('/public/images/news/'.$data->id.'/480_320/'.$data->avatar)}}"></a>
                                            <h4 class="tlt-tltle"><a
                                                        href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}">{{$data->name}}</a>
                                            </h4>
                                            <p>
                                                <a href="{{route('news.detail',[str_slug($data->name, '-'), $data->id])}}">Xem
                                                    thêm <i class="fa fa-angle-right"></i></a></p>
                                        </div>
                                    </div>

                                @endforeach
                            @endif
                        </div>
                    </div>
                  {{--  <div class="group-news">
                        <h3 class="title-tlt">Thông báo của nhà trường</h3>
                        <div class="group-news-fl">
                            <div class="group-left">
                                <div class="group-news-main">
                                    <a href="#"><img src="images/news02.png"></a>
                                    <h4 class="tlt"><a href="#">Thanh Thanh Hiền: 'Chồng yêu thương con riêng của tôi'</a></h4>
                                    <p>Ông xã Thanh Thanh Hiền - Chế Phong - đưa đón con gái của vợ đi học vì sợ con gặp nhiều cám dỗ ở tuổi dậy thì.</p>
                                </div>
                            </div>
                            <div class="group-right">
                                <ul>
                                    <li>
                                        <div><a href="#"><img src="images/news03.png"></a></div>
                                        <h4 class="tlt"><a href="#">Thanh Thanh Hiền: 'Chồng yêu thương con riêng của tôi'</a></h4>
                                    </li>
                                    <li>
                                        <div><a href="#"><img src="images/news03.png"></a></div>
                                        <h4 class="tlt"><a href="#">Thanh Thanh Hiền: 'Chồng yêu thương con riêng của tôi'</a></h4>
                                    </li>
                                    <li>
                                        <div><a href="#"><img src="images/news03.png"></a></div>
                                        <h4 class="tlt"><a href="#">Thanh Thanh Hiền: 'Chồng yêu thương con riêng của tôi'</a></h4>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>--}}
                   {{-- <div class="group-news group-other-news">
                        <h3 class="title-tlt">Các tin khác</h3>
                        <div class="other-news-fl">
                            <ul>
                                <li>
                                    <div class="other-box">
                                        <a href="#"><img src="images/news.png"></a>
                                        <h4 class="other-title"><a href="#">Đoạn đường sắt 1,5 tỷ USD Trung Quốc xây ở Kenya</a></h4>
                                    </div>
                                </li>
                                <li>
                                    <div class="other-box">
                                        <a href="#"><img src="images/news.png"></a>
                                        <h4 class="other-title"><a href="#">Đoạn đường sắt 1,5 tỷ USD Trung Quốc xây ở Kenya</a></h4>
                                    </div>
                                </li>
                                <li>
                                    <div class="other-box">
                                        <a href="#"><img src="images/news.png"></a>
                                        <h4 class="other-title"><a href="#">Đoạn đường sắt 1,5 tỷ USD Trung Quốc xây ở Kenya</a></h4>
                                    </div>
                                </li>
                                <li>
                                    <div class="other-box">
                                        <a href="#"><img src="images/news.png"></a>
                                        <h4 class="other-title"><a href="#">Đoạn đường sắt 1,5 tỷ USD Trung Quốc xây ở Kenya</a></h4>
                                    </div>
                                </li>
                                <li>
                                    <div class="other-box">
                                        <a href="#"><img src="images/news.png"></a>
                                        <h4 class="other-title"><a href="#">Đoạn đường sắt 1,5 tỷ USD Trung Quốc xây ở Kenya</a></h4>
                                    </div>
                                </li>
                                <li>
                                    <div class="other-box">
                                        <a href="#"><img src="images/news.png"></a>
                                        <h4 class="other-title"><a href="#">Đoạn đường sắt 1,5 tỷ USD Trung Quốc xây ở Kenya</a></h4>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>--}}
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