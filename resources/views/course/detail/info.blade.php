<div class="col-lg-8 col-xs-12 pd5">
        <div class="product-comment">
           <!-- Nav tabs -->
           <ul class="product-tablist nav nav-tabs" id="tab-product-template">
              <li class="active">
                 <a data-toggle="tab" data-spy="scroll" href="#description">
                 <span>Giới thiệu chương trình</span>
                 </a>
              </li>
              <li>
                 <a data-toggle="tab" data-spy="scroll" href="#comment">
                 <span>Bình luận</span>
                 </a>
              </li>
              <li>
                    <a data-toggle="tab" data-spy="scroll" href="#rating">
                    <span>Đánh giá</span>
                    </a>
                 </li>
           </ul>
           <!-- Tab panes -->
           <div id="description" class="box-info active">
              <div class="container-fluid product-description-wrapper">
                 {!! $var['course']->description !!}
              </div>
           </div>
           <div id="comment" class="box-info">              
              <div class="container-fluid">
                 <div class="row">
                    @include('course.detail.comment.comment_list')
                    
                 </div>
              </div>
           </div>
           @include('course.detail.rating',['rating'=>$var['rates'],'rating_value'=>$var['rating_value'],'rating_avg'=>$var['rating_avg'],'user_rating'=>$var['user_rating']])
        </div>
     </div>