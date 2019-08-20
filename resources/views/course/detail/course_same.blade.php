
        <div id="product-related" class="mb10">
           <div class="wrapper-product-related">
              <div class="title-group-related">
                 <h3 class="title-group">
                    Khóa học liên quan
                 </h3>
              </div>
              <ul class="list-product-related">

                  @if(isset($var['course_same']) && count($var['course_same']) > 0)
                        @foreach ($var['course_same'] as $item)
                              <li>
                                    <div class="flexbox-grid-default">
                                       <div class="flexbox-auto-100px">
                                          <a href="{{ route('courseDetail',['title'=>str_slug($item->name),'id'=>$item->id]) }}">
                                            <img src="{{ $item->avatar_thumb }}" />
                                          </a>
                                       </div>
                                       <div class="flexbox-content pd-l-10">
                                          <a href="{{ route('courseDetail',['title'=>str_slug($item->name),'id'=>$item->id]) }}">
                                             <h2>{{ $item->name }}</h2>
                                             <p class="product-box-price-related clearfix flexbox-grid-default">
                                              @if($item->status == \App\Models\Course::TYPE_FREE_TIME || $item->status == \App\Models\Course::TYPE_FREE_NOT_TIME || $item->status == \App\Models\Course::TYPE_APPROVAL)
                                                <span class="price-new-related flexbox-content text-left">Miễn phí</span> 
                                              @endif
                                              @if($item->status == \App\Models\Course::TYPE_PUBLIC)
                                                  <span class="price-new-related flexbox-content text-left">{{  number_format($item->price_new).'₫' }}</span>
                                                @if((int)$item->price > 0)
                                                    <span class="price-old-related flexbox-content">{{ number_format($item->price) }}₫</span>
                                                @endif
                                              @endif
                                                                                              
                                             </p>
                                          </a>
                                       </div>
                                    </div>
                                 </li>
                        @endforeach
                  @endif
              </ul>
           </div>
        </div>                    
     