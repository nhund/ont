@extends('layout')

@section('content')
    <div class="header-navigate clearfix mb15">
       <div class="container">
          <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                <ol class="breadcrumb breadcrumb-arrow">
                   <li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
                   <li><i class="fa fa-angle-right"></i></li>
                   <li><a href="{{ route('courseList') }}" target="_self">Khóa học</a></li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <section id="collection" class="clearfix">
       <div class="container">
          <div class="row">
             <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 pd5 pr-none-destop box-filter">
                @include('course.filter')
             </div>
             <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <div class="row">
                   <div class="col-xs-12 pd5">
                      <div class="group-collection mb15">
                         <div class="title-block">
                            <h1 class="title-group">
                               @if(isset($var['cate']) && $var['cate']) 
                                    {{ $var['cate']->name }}
                               @endif
                            </h1>
                            <div class="browse-tags pull-right hidden-xs">
                               <span class="mr5">Sắp xếp theo:</span>
                               <span class="custom-dropdown custom-dropdown--white">
                                  <select class="sort-by custom-dropdown__select custom-dropdown__select--white">
                                     {{-- <option value="highlight" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'highlight') selected @endif>Khóa học nổi bật</option> --}}
                                     <option value="price-ascending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'price-ascending') selected @endif>Giá: Tăng dần</option>
                                     <option value="price-descending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'price-descending') selected @endif >Giá: Giảm dần</option>                                     
                                     <option value="created-ascending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'created-ascending') selected @endif>Cũ nhất</option>
                                     <option value="created-descending" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'created-descending') selected @endif>Mới nhất</option>
                                     <option value="best-selling" @if(isset($var['params']['sortBy']) && $var['params']['sortBy'] == 'best-selling') selected @endif>Bán chạy nhất</option>
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
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 product-wrapper product-resize">
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
                                            <div class="product-pricesale-percent">-{{ number_format($course->discount_percent , 0) }}%</div>
                                         @endif
                                      </div>
                                      <div class="product-info">
                                         <a href="{{ route('courseDetail',['title'=>str_slug($course->name),'id'=>$course->id]) }}" title="{{ $course->name }}">
                                            <h2>{{ $course->name }}</h2>
                                         </a>
                                         <p class="product-vendor">Người tạo: {{ $course->user->full_name }}</p>
                                         <p class="product-box-price clearfix flexbox-grid-default">
                                            @if($course->status == \App\Models\Course::TYPE_FREE_TIME || $course->status == \App\Models\Course::TYPE_FREE_NOT_TIME || $course->status == \App\Models\Course::TYPE_APPROVAL)
                                              <span class="price-new flexbox-content text-left">Miễn phí</span> 
                                            @endif
                                            @if($course->status == \App\Models\Course::TYPE_PUBLIC)
                                              <span class="price-new flexbox-content text-left">{{ number_format($course->price_new).'₫' }}</span>
                                              @if((int)$course->price > 0 && (int)$course->discount > 0)
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
                     <p>Không có khóa học</p>    
                    @endif                   
                   
                   {{-- <div class="icon-loading clear-ajax" style="display: none;">
                      <div class="uil-ring-css">
                         <div></div>
                      </div>
                   </div>
                   <div class="clearboth clear-ajax"></div>
                   <div class="clearfix loadmore clear-ajax">
                      <a href="javascript:" class="btn-loading">Xem thêm <span>nhiều</span> sản phẩm khác</a>
                   </div> --}}
                </div>
             </div>
          </div>
       </div>
    </section>    
@stop
@push('js')
    <script src='{{ web_asset('public/js/list/list.js') }}' type='text/javascript'></script>
@endpush