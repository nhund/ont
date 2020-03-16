@if(count($var['courses'])> 0)
<div class="container mb15 group-index">
    <div class="row">
       <div class="col-xs-12">
          <div class="title-block">
             <h3 class="title-group">Các khóa học nổi bật</h3>
             <div class="border-bottom"></div>
          </div>
       </div>
    </div>
    <div class="row box-product-lists">
        @foreach ($var['courses'] as $course)
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 product-wrapper product-resize mb30">
                <div class="product-information">
                   <div class="product-detail clearfix">
                      <div class="product-image image-resize">
                            <a href="{{ route('courseDetail',['title'=>str_slug($course->name),'id'=>$course->id]) }}" title="{{ $course->name }}">
                            <picture>
                               {{-- <source media="(max-width: 767px)" srcset="../product.hstatic.net/1000122408/product/upload_8724b945dea74124b94914449d6ebb04_medium.jpg">
                               <source media="(min-width: 768px) and (max-width: 991px)" srcset="../product.hstatic.net/1000122408/product/upload_8724b945dea74124b94914449d6ebb04_medium.jpg">
                               <source media="(min-width: 992px)" srcset="../product.hstatic.net/1000122408/product/upload_8724b945dea74124b94914449d6ebb04_large.jpg"> --}}
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
                         <p class="product-vendor">Người tạo: {{ $course->user->name_full }}</p>
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
    </div>
    <div class="row">
       <div class="col-xs-12">
          <div class="text-center">
            <a href="{{ route('courseList') }}" class="btn btn-view-more">Xem tất cả khóa học</a>
          </div>
       </div>
    </div>
 </div>
 @endif