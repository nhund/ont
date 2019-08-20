@extends('layout')
@push('css')
   <link href="{{ web_asset('public/css/comment.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ web_asset('public/css/bootstrap-rating.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ web_asset('public/css/rating.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
        <div class="header-navigate clearfix mb15">
           <div class="container">
              <div class="row">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                    <ol class="breadcrumb breadcrumb-arrow">
                       <li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
                       <li><i class="fa fa-angle-right"></i></li>
                       <li><a href="{{ route('courseList') }}" target="_self">Khóa học</a></li>
                       <li><i class="fa fa-angle-right"></i></li>
                       <li class="active"><span> {{ $var['course']->name }}</span></li>
                    </ol>
                 </div>
              </div>
           </div>
        </div>
        <section id="product" class="clearfix">
           <div class="container">
              <div class="row">
                 <div id="surround" class="col-lg-6 col-md-6">
                    <img class="product-image-feature" src="{{ $var['course']->avatar_thumb }}" alt="{{ $var['course']->name }}">
                 </div>
                 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pd5 information-product">
                    <div class="product-title">
                       <h1>{{ $var['course']->name }}</h1>
                    </div>
                    <div class="clearfix product-sku-date">
                       <span class="pull-left product-sku" id="pro_sku">Mã khóa học: {{ $var['course']->id }}</span>
                        <span class="pull-right product-date">Ngày cập nhật: {{ date('d/m/Y H:i',$var['course']->updated_at) }}</span>
                    </div>
                    {{-- @if(!isset($var['user_course'])) --}}
                     <div class="product-price" id="price-preview">
                          @if($var['course']->status == \App\Models\Course::TYPE_FREE_TIME || $var['course']->status == \App\Models\Course::TYPE_FREE_NOT_TIME || $var['course']->status == \App\Models\Course::TYPE_APPROVAL)
                            <span>Miễn phí</span> 
                          @endif
                          @if($var['course']->status == \App\Models\Course::TYPE_PUBLIC)
                            <span>{{ number_format($var['course']->price_new).'₫' }}</span>
                          @endif
                           
                     </div>
                    {{-- @endif --}}
                     <form id="add-item-form" action="#" method="post" class="variants clearfix variant-style">                       
                        {{ csrf_field() }}
                       <input type="hidden" name="course_id" value="{{ $var['course']->id }}" >
                       <div class="clearfix">                          
                          
                          @if(isset($var['user_course']) && $var['user_course'])
                              @if(isset($var['user_course']->and_date) && $var['user_course']->and_date > 0 &&  $var['user_course']->and_date < time())
                                <button class="btn-style-add add-to-cart">
                                  <span class="icon_cart_btn"></span>
                                  <span>Gia hạn khóa học</span>                            
                                </button>
                              @else 
                                <a class="learn_now" href="{{ route('course.learn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id]) }}">
                                   Vào học ngay
                                </a>
                              @endif
                          @else
                            <button class="btn-style-add add-to-cart">
                              <span class="icon_cart_btn"></span>
                              @if($var['course']->status == \App\Models\Course::TYPE_APPROVAL)
                                <span>Xin tham gia</span>
                              @else
                                <span>Mua khóa học</span>
                              @endif                              
                            </button>
                          @endif
                       </div>
                    </form>
                 </div>
              </div>
              <div class="row box-bottom-product">
                 @include('course.detail.info')
                 <div class="col-lg-4 col-xs-12 pd5">
                     @include('course.detail.course_same')
                 </div> 
                 
              </div>
           </div>
        </section>
        
@stop
@push('js')
    <script>
       var comment_add = '{{ route('user.course.comment.add') }}';
       var comment_delete = '{{ route('user.course.comment.delete') }}';
       var rating = '{{ route('user.course.rating') }}';
       var course_buy = '{{ route('user.course.buy') }}';
    </script>    
    <script src='{{ web_asset('public/js/detail/jquery.mthumbnailscroller.js') }}' type='text/javascript'></script>
    <script src='{{ web_asset('public/js/detail/bootstrap-tabdrop.js') }}' type='text/javascript'></script>
    <script src='{{ web_asset('public/js/detail/comment.js') }}' type='text/javascript'></script>
    <script src='{{ web_asset('public/js/detail/bootstrap-rating.min.js') }}' type='text/javascript'></script>
    <script src='{{ web_asset('public/js/detail/rating.js') }}' type='text/javascript'></script>
    <script src='{{ web_asset('public/js/detail/detail.js') }}' type='text/javascript'></script>
<script>
        $(document).ready(function(){
            if($(".product-thumb-vertical").length > 0 && $(window).width() >= 768 ) {
                $(".product-thumb-vertical").mThumbnailScroller({
                    axis:"y",
                    type:"click-thumb",
                    theme:"buttons-out",
                    type:"hover-precise",
                    contentTouchScroll: true
                });
                setTimeout(function(){
                    $('.product-thumb-vertical').css('height',$('.product-image-feature').height());
                    $('#sliderproduct').show();
                },500);
            }
            if($(".product-thumb-vertical").length > 0 && $(window).width() < 767 ) {
                $(".product-thumb-vertical").mThumbnailScroller({
                    axis:"x",
                    theme:"buttons-out",
                    contentTouchScroll: true
                });
                $('#sliderproduct').show();
            }
        });
     </script>
@endpush