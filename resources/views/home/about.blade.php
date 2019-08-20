<div id="about-us">
    <div class="container">
       <div class="row">
          <div class="col-xs-12">
             <div class="box-aboutus">
                {{-- <h3 class="aboutus-title">Giới thiệu</h3> --}}
                {{-- <div class="border-bottom"></div> --}}
                <div class="aboutus-content">
                   {!! isset($var['about']->about_us) ? $var['about']->about_us : '' !!}
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>     