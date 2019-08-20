@extends('layout')

@section('content')
    <div class="header-navigate clearfix mb15">
       <div class="container">
          <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                <ol class="breadcrumb breadcrumb-arrow">
                   <li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
                   <li><i class="fa fa-angle-right"></i></li>
                   <li class=""><span>Tìm kiếm</span></li>
                   <li><i class="fa fa-angle-right"></i></li>
                   <li class="active"><span>{{ isset($var['q']) ? $var['q'] : '' }}</span></li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <section id="collection" class="clearfix">
       <div class="container">
          <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                   <div class="col-xs-12 pd5">
                      <div class="group-collection mb15">
                         <div class="title-block">
                            <h1 class="title-group">Tìm kiếm : {{ isset($var['q']) ? $var['q'] : '' }} </h1>
                            <div class="browse-tags pull-right hidden-xs">
                               <span class="mr5">Sắp xếp theo:</span>
                               <span class="custom-dropdown custom-dropdown--white">
                                  <select class="sort-by custom-dropdown__select custom-dropdown__select--white">                                     
                                     <option value="created-ascending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'created-ascending') selected @endif>Cũ nhất</option>
                                     <option value="created-descending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'created-descending') selected @endif>Mới nhất</option>                                     
                                     <option value="price-ascending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'price-ascending') selected @endif>Giá: Tăng dần</option>
                                     <option value="price-descending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'price-descending') selected @endif >Giá: Giảm dần</option>                                                                          
                                  </select>
                               </span>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="row product-lists product-item box-product-lists clearfix" id="event-grid">
                    @if(isset($var['courses']) && count($var['courses']) > 0)
                        @foreach ($var['courses'] as $course)
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 product-wrapper product-resize">
                                <div class="product-information">
                                   <div class="product-detail clearfix">
                                      <div class="product-image image-resize">
                                        <a href="{{ route('courseDetail',['title'=>str_slug($course->name),'id'=>$course->id]) }}" title="{{ $course->name }}">
                                            <picture>
                                               {{-- <source media="(max-width: 1199px)" srcset="../../product.hstatic.net/1000122408/product/upload_2161eda575ed44b2942861d9ddeb9ecc_medium.jpg">
                                               <source media="(min-width: 1200px)" srcset="../../product.hstatic.net/1000122408/product/upload_2161eda575ed44b2942861d9ddeb9ecc_large.jpg"> --}}                                                  
                                                  <img src="{{ $course->avatar_thumb }}" alt="{{ $course->name }}" />
                                            </picture>
                                         </a>
                                         @if($course->is_free !== 1 && $course->discount_percent > 0)
                                            <div class="product-pricesale-percent">-{{ $course->discount_percent }}%</div>
                                        @endif
                                      </div>
                                      <div class="product-info">
                                         <a href="{{ route('courseDetail',['title'=>str_slug($course->name),'id'=>$course->id]) }}" title="{{ $course->name }}">
                                            <h2>{{ $course->name }}</h2>
                                         </a>
                                         <p class="product-vendor">GV: {{ $course->user->full_name }}</p>
                                         <p class="product-box-price clearfix flexbox-grid-default">
                                            @if($course->status == \App\Models\Course::TYPE_FREE_TIME || $course->status == \App\Models\Course::TYPE_FREE_NOT_TIME || $course->status == \App\Models\Course::TYPE_APPROVAL)
                                              <span class="price-new flexbox-content text-left">Miễn phí</span> 
                                            @endif
                                            @if($course->status == \App\Models\Course::TYPE_PUBLIC)
                                              <span class="price-new flexbox-content text-left">{{ number_format($course->price_new).'₫' }}</span>
                                              @if((int)$course->price > 0)
                                                  <span class="price-old flexbox-content text-right">{{ number_format($course->price) }}₫</span>
                                              @endif
                                            @endif  
                                         </p>
                                         <div class="product-info-description clearfix hidden">
                                            <p class="col-xs-12 pd-none mt5">
                                                    {{ $course->sapo }}
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
                    @else 
                        <span>Không tìm thấy khóa học</span>
                    @endif  
                </div>
             </div>
          </div>
       </div>
    </section>    
@stop
@push('js')
    <script src='{{ web_asset('public/js/list/list.js') }}?v=1' type='text/javascript'></script>
@endpush