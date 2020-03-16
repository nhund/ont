@if(count($var['news'])> 0)
<div class="container mb15 group-index">
    <hr/>
    <div class="row">
       <div class="col-xs-12">
          <div class="title-block">
             <h3 class="title-group">Blog học tập</h3>
             <div class="border-bottom"></div>
          </div>
       </div>
    </div>
    <div class="row box-product-lists">
        @foreach ($var['news'] as $news)
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 product-wrapper  mb30">
                <div class="product-information">
                   <div class="product-detail clearfix">
                      <div class="product-image image-resize">
                            <a href="{{ route('courseDetail',['title'=>str_slug($news->name),'id'=>$news->id]) }}" title="{{ $news->name }}">
                            <picture>
                               <img src="{{$news->thumbnail}}" alt="{{ $news->name }}" />
                            </picture>
                         </a>
                      </div>
                      <div class="product-info">
                         <a href="{{ route('news.detail',[str_slug($news->name, '-'), $news->id]) }}" title="{{ $news->name }}">
                            <h2>{!! substr($news->name, 0, 120) !!}...</h2>
                         </a>
                      </div>
                   </div>
                </div>
             </div>
        @endforeach              
    </div>
    <div class="row">
       <div class="col-xs-12">
          <div class="text-center">
            <a href="{{ route('news') }}" class="btn btn-view-more">Xem tất cả bài viết</a>
          </div>
       </div>
    </div>
 </div>
 @endif