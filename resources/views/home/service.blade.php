<div id="services">
    <div class="col-lg-6 col-md-6 col-xs-12 background-services"></div>
    <div class="container">
       <div class="row">
          <div class="col-lg-6 col-md-6 col-xs-12">
             <div class="box-services">
                <h2 class="title">Tính năng</h2>
                <div class="border-bottom"></div>
                <ul>
                   <li class="mb20">
                      <div class="flexbox-grid-default">
                         <div class="flexbox-auto-left box-icon">
                            <img src="{{ web_asset('public/images/function.png') }}" />
                         </div>
                         <div class="flexbox-content pd-l-10">
                             <div class="function_title">
                                 Nội dung đầy đủ, xúc tích
                             </div>
                            <p>Tài liệu ôn thi được tổng hợp và trình bày ngắn gọn, xúc tích để học nhanh, nhớ lâu.</p>
                         </div>
                      </div>
                   </li>
                   <li class="mb20">
                      <div class="flexbox-grid-default">
                         <div class="flexbox-auto-left box-icon">
                             <img src="{{ web_asset('public/images/function_2.png') }}" />
                         </div>
                         <div class="flexbox-content pd-l-10">
                             <div class="function_title">
                                 Tối ưu ghi nhớ:
                             </div>
                            <p>Cơ chế ưu tiên ôn lại những câu chưa nhớ và làm riêng các câu bookmark.</p>
                         </div>
                      </div>
                   </li>
                   <li class="mb20">
                      <div class="flexbox-grid-default">
                         <div class="flexbox-auto-left box-icon">
                             <img src="{{ web_asset('public/images/function_3.png') }}" />
                         </div>
                         <div class="flexbox-content pd-l-10">
                                 <div class="function_title">
                                         Học mọi lúc, mọi nơi:
                                     </div>
                            <p>Học mọi lúc mọi nơi chỉ cần có laptop, mobile,…</p>
                         </div>
                      </div>
                   </li>                              
                </ul>
             </div>
          </div>
          <div class="col-lg-6 col-md-6 col-xs-12 bg-mobile-about-us-slide bg_review">
             <div class="about-us-slide">
                <h2 class="title">Nhận xét đánh giá</h2>
                <div class="border-bottom"></div>
                <ul class="owl-carousel" id="aboutus-slide">
                  @if(count($var['user_feels']) > 0)
                    @foreach($var['user_feels'] as $user_feel)
                        <li>
                          <div class="box-customer row">

                           <div class="col-xs-12">
                             <div class="customer_rating">
                               <span class="fa fa-star checked"></span>
                               <span class="fa fa-star checked"></span>
                               <span class="fa fa-star checked"></span>
                               <span class="fa fa-star checked"></span>
                               <span class="fa fa-star checked"></span>
                             </div>
                             <p class="customer-content">{{ $user_feel->title }}</p>
                           </div>
                           <div class="customer-box">
                             <div class="col-md-2 col-xs-2">
                               @if(!empty($user_feel->avatar)) 
                                 <div class="customer-image">
                                    <img src="{{ web_asset($user_feel->avatar) }}" alt="{{ $user_feel->name }}" />
                                  </div>
                                @endif
                            </div>
                            <div class="col-md-10 col-xs-10 customer-info">
                             <div class="customer-name">{{ $user_feel->name }}</div>
                             <div class="customer-job">{{ $user_feel->school }}</div>
                           </div>
                         </div>

                       </div>
                     </li>
                    @endforeach
                  @endif
                </ul>
             </div>
          </div>
       </div>
    </div>
 </div>