@extends('layout')

@section('content')
    <div class="header-navigate clearfix mb15">
       <div class="container">
          <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                <ol class="breadcrumb breadcrumb-arrow">
                   <li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
                   <li><i class="fa fa-angle-right"></i></li>
                   <li class="active"><span>Khóa học của tôi</span></li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <section id="collection" class="clearfix my_course">
       <div class="container">
          <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                   <div class="col-xs-12 pd5">
                      <div class="group-collection mb15">
                         <div class="title-block">
                            <h1 class="title-group"></h1>
                            <div class="browse-tags pull-right hidden-xs">
                               <span class="mr5">Sắp xếp theo:</span>
                               <span class="custom-dropdown custom-dropdown--white">
                                  <select class="sort-by custom-dropdown__select custom-dropdown__select--white">                                     
                                     <option value="created-ascending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'created-ascending') selected @endif>Cũ nhất</option>
                                     <option value="created-descending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'created-descending') selected @endif>Mới nhất</option>                                     
                                     {{-- <option value="price-ascending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'price-ascending') selected @endif>Giá: Tăng dần</option>
                                     <option value="price-descending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'price-descending') selected @endif >Giá: Giảm dần</option>                                                                           --}}
                                  </select>
                               </span>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="row product-lists product-item box-product-lists clearfix" id="event-grid">
                    @if(count($var['courses']) > 0)
                        @foreach ($var['courses'] as $course)
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 product-wrapper product-resize">
                                <div class="product-information">
                                   <div class="product-detail clearfix">
                                      <div class="product-image image-resize">

                                        <a href="{{ route('course.learn',['title'=>str_slug($course->course->name),'id'=>$course->course->id]) }}" title="{{ $course->course->name }}">
                                            <picture>
                                                  <img src="{{ $course->course->avatar_thumb }}" alt="{{ $course->course->name }}" />
                                            </picture>
                                         </a>
                                         @if($course->course->is_free !== 1 && $course->course->discount_percent > 0)
                                            <div class="product-pricesale-percent">-{{ number_format($course->course->discount_percent , 0)}}%</div>
                                        @endif
                                      </div>
                                      <div class="product-info">
                                         <a href="{{ route('course.learn',['title'=>str_slug($course->course->name),'id'=>$course->course->id]) }}" title="{{ $course->course->name }}">
                                            <h2>{{ $course->course->name }}</h2>
                                         </a>
                                         <p class="product-vendor">Người tạo: {{ $course->course->user->name_full }}</p>
                                         <div class="product-info-description clearfix hidden">
                                            <p class="col-xs-12 pd-none mt5">
                                                    {{ $course->course->sapo }}
                                            </p>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                             </div>
                        @endforeach
                        <div class="clearfix loadmore clear-ajax">
                                <div class="paginations">
                                        {{ $var['courses']->appends($var['params'])->links('vendor.pagination.default') }}
                                </div>
                        </div>
                    @endif   
                </div>
             </div>
          </div>
       </div>
    </section>    
@stop
@push('js')
    <script src='{{ web_asset('public/js/list/list.js') }}' type='text/javascript'></script>
@endpush