<div class="wrap-filter clearfix mb15">
    {{-- <div class="group-collection" aria-expanded="true">
       <div class="title-block dropdown-filter">
          <h3 class="title-group">Danh mục nhóm</h3>
          <i class="fa fa-minus flexbox-grid-default flexbox-justifyContent-center flexbox-alignItems-center" aria-hidden="true"></i>
       </div>
       <div class="filter-box">
          <ul id="menusidebarleft" class="menu-collection clearfix mb15">
             <li class="">
                <a href="../index.html" title="Thiết kế đồ họa">Thiết kế đồ họa</a>
             </li>
             <li class="">
                <a href="../index.html" title="Thiết kế đồ họa nâng cao">Thiết kế đồ họa nâng cao</a>
             </li>
             <li class="">
                <a href="../index.html" title="Phân tích thiết kế đồ họa">Phân tích thiết kế đồ họa</a>
             </li>
             <li class="">
                <a href="../index.html" title="Thiết kế logo">Thiết kế logo</a>
             </li>
             <li class="">
                <a href="../index.html" title="Thiết kế nội thất">Thiết kế nội thất</a>
             </li>
             <li class="">
                <a href="../index.html" title="Thiết kế & kinh doanh thời trang">Thiết kế & kinh doanh thời trang</a>
             </li>
             <li class="">
                <a href="../index.html" title="Nhiếp ảnh đễ làm Marketing">Nhiếp ảnh đễ làm Marketing</a>
             </li>
             <li class="">
                <a href="../index.html" title="Nhiếp ảnh & sản xuất phim">Nhiếp ảnh & sản xuất phim</a>
             </li>
             <li class="">
                <a href="../index.html" title="Film quảng cáo - cinema 4D">Film quảng cáo - cinema 4D</a>
             </li>
             <li class="">
                <a href="../index.html" title="Phim quảng cáo Motion Graphic">Phim quảng cáo Motion Graphic</a>
             </li>
          </ul>
       </div>
     </div> --}}
    {{-- <div class="group-collection" aria-expanded="true">
        <div class="title-block dropdown-filter">
           <h3 class="title-group">Khóa đang học</h3>
           <i class="fa fa-minus flexbox-grid-default flexbox-justifyContent-center flexbox-alignItems-center" aria-hidden="true"></i>
        </div>
        <div class="filter-box">
           <ul id="menusidebarleft" class="menu-collection clearfix mb15">
              <li class="">
                 <a href="../index.html" title="Thiết kế đồ họa">Học thiết kế Photoshop & trở thành cao thủ trong 5 ngày</a>
              </li>
              <li class="">
                <a href="../index.html" title="Thiết kế đồ họa">Học thiết kế Photoshop & trở thành cao thủ trong 5 ngày</a>
             </li>
             <li class="">
                <a href="../index.html" title="Thiết kế đồ họa">Học thiết kế Photoshop & trở thành cao thủ trong 5 ngày</a>
             </li>
             
           </ul>
        </div>
      </div> --}}
     {{-- <div class="group-collection" aria-expanded="true">
        <div class="title-block dropdown-filter">
           <h3 class="title-group">Khóa đã tạo</h3>
           <i class="fa fa-minus flexbox-grid-default flexbox-justifyContent-center flexbox-alignItems-center" aria-hidden="true"></i>
        </div>
        <div class="filter-box">
           <ul id="menusidebarleft" class="menu-collection clearfix mb15">
              <li class="">
                 <a href="../index.html" title="Thiết kế đồ họa">Học thiết kế Photoshop & trở thành cao thủ trong 5 ngày</a>
              </li>
              <li class="">
                <a href="../index.html" title="Thiết kế đồ họa">Học thiết kế Photoshop & trở thành cao thủ trong 5 ngày</a>
             </li>
             <li class="">
                <a href="../index.html" title="Thiết kế đồ họa">Học thiết kế Photoshop & trở thành cao thủ trong 5 ngày</a>
             </li>
             
           </ul>
        </div>
      </div> --}}
     {{-- <div class="group-collection" aria-expanded="true">
        <div class="title-block dropdown-filter">
           <h3 class="title-group">Khóa học phổ biến</h3>
           <i class="fa fa-minus flexbox-grid-default flexbox-justifyContent-center flexbox-alignItems-center" aria-hidden="true"></i>
        </div>
        <div class="filter-box">
           <ul id="menusidebarleft" class="menu-collection clearfix mb15">
              <li class="">
                 <a href="../index.html" title="Thiết kế đồ họa">Học thiết kế Photoshop & trở thành cao thủ trong 5 ngày</a>
              </li>
              <li class="">
                <a href="../index.html" title="Thiết kế đồ họa">Học thiết kế Photoshop & trở thành cao thủ trong 5 ngày</a>
             </li>
             <li class="">
                <a href="../index.html" title="Thiết kế đồ họa">Học thiết kế Photoshop & trở thành cao thủ trong 5 ngày</a>
             </li>
             
           </ul>
        </div>
      </div> --}}
      <div class="group-collection" aria-expanded="true">
       <div class="title-block dropdown-filter">
        <h3 class="title-group">Khóa học</h3>
        <i class="fa fa-minus flexbox-grid-default flexbox-justifyContent-center flexbox-alignItems-center" aria-hidden="true"></i>
      </div>
      <div class="filter-box" id="filter-vendor">
        <ul>
          @if(isset($var['category']) && count($var['category']) > 0)
          @foreach ($var['category'] as $cate)
          <li>
            <label data-filter="nguyen-anh-tuan" class="nguyen-anh-tuan">
              <input type="checkbox" name="category_id[]" @if( isset($var['params']['category_id']) && in_array($cate->id,$var['params']['category_id'])) checked @endif value="{{ $cate->id }}" />
              <span>{{ $cate->name }}</span>
            </label>
          </li>
          @endforeach              
          @endif
        </ul>
      </div>
    </div>
    <div class="group-collection" aria-expanded="true">
     <div class="title-block dropdown-filter">
      <h3 class="title-group">Theo giá tiền</h3>
      <i class="fa fa-minus flexbox-grid-default flexbox-justifyContent-center flexbox-alignItems-center" aria-hidden="true"></i>
    </div>
    <div class="filter-box" id="filter-price">
      <ul>
        <li>
          <label>
            <input type="radio" name="price-filter" @if(isset($var['params']['price']) && $var['params']['price'] == 'free') checked @endif data-price="0:0" value="free" />
            <span>Miễn phí</span>
          </label>
        </li>
        <li>
          <label>
            <input type="radio" name="price-filter" @if(isset($var['params']['price']) && $var['params']['price'] == '0-50000') checked @endif  data-price="0:50000" value="0-50000" />
            <span>Nhỏ hơn 50.000₫</span>
          </label>
        </li>
        <li>
          <label>
            <input type="radio" name="price-filter" @if(isset($var['params']['price']) && $var['params']['price'] == '0-100000') checked @endif  data-price="0:100000" value="0-100000" />
            <span>Nhỏ hơn 100.000₫</span>
          </label>
        </li>
        <li>
          <label>
            <input type="radio" name="price-filter" @if(isset($var['params']['price']) && $var['params']['price'] == '0-200000') checked @endif  data-price="0:200000" value="0-200000" />
            <span>Nhỏ hơn 200.000₫</span>
          </label>
        </li>
        <li>
          <label>
            <input type="radio" name="price-filter" @if(isset($var['params']['price']) && $var['params']['price'] == '0-500000') checked @endif  data-price="0:500000" value="0-500000" />
            <span>Nhỏ hơn 500.000₫</span>
          </label>
        </li>
        <li>
          <label>
            <input type="radio" name="price-filter" @if(isset($var['params']['price']) && $var['params']['price'] == '500000-max') checked @endif  data-price="500000:max" value="500000-max" />
            <span>Lớn hơn 500.000₫</span>
          </label>
        </li>
      </ul>
    </div>
  </div>
  <div class="group-collection" aria-expanded="true">
    <div class="title-block dropdown-filter">
     <h3 class="title-group">Theo đánh giá</h3>
     <i class="fa fa-minus flexbox-grid-default flexbox-justifyContent-center flexbox-alignItems-center" aria-hidden="true"></i>
   </div>
   <div class="filter-box" id="filter-rating">
     <ul>
      <li>
       <label data-filter="nguyen-anh-tuan" class="">
         <input type="radio" name="rating-filter" @if(isset($var['params']['rating']) && $var['params']['rating'] == 5) checked @endif data-rating="5" value="5" />
       </label>
       <div class="course_rating">
         <span>5</span>
         <span class="fa fa-star checked"></span>
         <span class="fa fa-star checked"></span>
         <span class="fa fa-star checked"></span>
         <span class="fa fa-star checked"></span>
         <span class="fa fa-star checked"></span>
       </div>
     </li>
     <li>
      <label data-filter="nguyen-anh-tuan" class="">
        <input type="radio" name="rating-filter" @if(isset($var['params']['rating']) && $var['params']['rating'] == 4) checked @endif data-rating="4" value="4" />
      </label>
      <div class="course_rating">
        <span>4</span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>                               
      </div>
    </li>
    <li>
      <label data-filter="nguyen-anh-tuan" class="">
        <input type="radio" name="rating-filter" @if(isset($var['params']['rating']) && $var['params']['rating'] == 3) checked @endif data-rating="3" value="3" />
      </label>
      <div class="course_rating">
        <span>3</span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
      </div>
    </li>
    <li>
      <label data-filter="nguyen-anh-tuan" class="">
        <input type="radio" name="rating-filter" @if(isset($var['params']['rating']) && $var['params']['rating'] == 2) checked @endif data-rating="2" value="2" />
      </label>
      <div class="course_rating">
        <span>2</span>
        <span class="fa fa-star checked"></span>
        <span class="fa fa-star checked"></span>
      </div>
    </li>
    <li>
      <label data-filter="nguyen-anh-tuan" class="">
        <input type="radio" name="rating-filter" @if(isset($var['params']['rating']) && $var['params']['rating'] == 1) checked @endif data-rating="1" value="1" />
      </label>
      <div class="course_rating">
        <span>1</span>
        <span class="fa fa-star checked"></span>
      </div>
    </li>              
    
  </ul>
</div>
</div>
<div class="clear_filter">Xóa bộ lọc</div>
</div>