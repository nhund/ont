<footer>
    <div class="footer-center">
       <div class="container">
          <div class="row">
             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pd5">
                <div class="box-footer-colum">
                   <h3 class="">Dịch vụ</h3>
                   <ul class="footer-list-menu">
                      <li class="footer-address">{{ isset($data_all['about']->address)? $data_all['about']->address : '' }}</li>
                      <li class="fooer-phone">
                         <label class="mr5">Phone: </label><span><a href="tel:{{ isset($data_all['about']->phone)? $data_all['about']->phone : '' }}">{{ isset($data_all['about']->phone)? $data_all['about']->phone : '' }}</a></span>
                      </li>
                      <li class="footer-email">
                         <label class="mr5">Email: </label><span>{{ isset($data_all['about']->email)? $data_all['about']->email : '' }}</span>
                      </li>
                   </ul>
                </div>
             </div>
             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pd5">
                <div class="box-footer-colum">
                   <h3 class="">Khóa học</h3>
                   <ul class="footer-list-menu">
                      @if(isset($data_all['category']))    
                        @foreach ($data_all['category'] as $cate)
                            <li><a href="{{ route('courseList',['category_id'=>$cate->id]) }}" title="{{ $cate->name }}">{{ $cate->name }}</a></li>
                        @endforeach   
                      @endif                      
                   </ul>
                </div>
             </div>
             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pd5">
                <div class="box-footer-colum">
                   <h3 class="">Liên kết</h3>
                   <div class="social">
                      <ul class="footer-list-menu">
                         <li>Hãy kết nối với chúng tôi.</li>
                      </ul>
                      <ul class="list-unstyled clearfix">
                         <li class="facebook">
                            <a target="_blank"  href="{{ isset($data_all['about']->page_facebook)? $data_all['about']->page_facebook : '#' }}"  class="fa fa-facebook"></a>
                         </li>
                         <li class="twitter">
                            <a class="fa fa-twitter" target="_blank" href="{{ isset($data_all['about']->twitter)? $data_all['about']->twitter : '#' }}" ></a>
                         </li>
                         <li class="google-plus">
                            <a class="fa fa-google-plus" target="_blank" href="{{ isset($data_all['about']->google)? $data_all['about']->google : '#' }}"></a>
                         </li>
                         <li class="rss">
                            <a class="fa fa-instagram" target="_blank" href="{{ isset($data_all['about']->instagram)? $data_all['about']->instagram : '#' }}"></a>
                         </li>
                         <li class="youtube">
                            <a class="fa fa-youtube" target="_blank" href="{{ isset($data_all['about']->youtube)? $data_all['about']->youtube : '#' }}"></a>
                         </li>
                      </ul>
                      {{-- <div class="dkbocongthuong">
                         <img src="{{ web_asset('public/images/dkbocongthuong9bf4.png?v=31')}}" />
                      </div> --}}
                      <ul class="footer-list-menu">
                         <li><a href="{{ route('chinhsachriengtu') }}">Chính sách riêng tư</a></li>
                         <li><a href="{{ route('dieukhoansudung') }}">Điều khoản sử dụng</a></li>
                      </ul>
                   </div>
                </div>
             </div>
             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pd5">
                <div class="box-footer-colum">
                   <h3 class="">Facebook</h3>
                   <ul class="footer-list-menu">
                         <li>Like fanpage để nhận thông tin.</li>
                   </ul>
                   <div class="fb-page" data-href="https://www.facebook.com/onthiez/" data-width="270" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/onthiez/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/onthiez/">Ôn thi EZ</a></blockquote></div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="footer-bottom">
       <div class="pd5 text-center">
          <div class="footer-copyright">
             <p>&copy; Bản quyền thuộc về <a href="#" target="_blank">{{ isset($data_all['about']->title)? $data_all['about']->title : '' }}</a>. Cung cấp bởi <a href="{{ isset($data_all['about']->url)? $data_all['about']->url : '#' }}" target="_blank">{{ isset($data_all['about']->title)? $data_all['about']->title : '' }}</a>.</p>
          </div>
       </div>
    </div>
 </footer>