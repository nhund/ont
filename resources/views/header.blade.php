<header>
    <div class="hidden-xs">
       <div class="container header">
          <div class="row">
             <div class="col-md-3 col-md-6 col-sm-4">
                <div class="logo">
                   <a href="{{ route('home') }}" title="{{ isset($data_all['about']->title) ? $data_all['about']->title : '' }}">
                   <img src="{{ isset($data_all['about']->logo) ? web_asset($data_all['about']->logo) : '' }}" alt="{{ isset($data_all['about']->title) ? $data_all['about']->title : '' }}" />
                   </a>
                </div>
             </div>
             <div class=" header-right-box col-lg-7 col-lg-offset-2 col-md-6 col-md-offset-1 col-sm-8">
                <div class="row header-right">
                    @if(!Auth::check())
                        <div class="col-md-3 col-md-offset-1" style="margin-left: 45px;"></div>
                    @else 
                        <div class="col-md-2 col-md-offset-1" style="margin-left: 50px;"></div>
                    @endif
                   <div class="col-md-4 col-sm-5 col-md-offset-0 col-sm-offset-7 header-right-content">
                      <div class="header-contact-info">
                         <i class="fa fa-phone"></i>
                         <span style="margin-right: 3px">Hotline  </span>
                         <span class="phone"> {{ isset($data_all['about']->phone)? $data_all['about']->phone : '' }}</span>
                      </div>
                   </div>
                   @if(!Auth::check())
                        <div class="col-md-2 hidden-sm box-login">
                            <div class="login">
                                <a class="" href="#" data-toggle="modal" data-target="#loginModal">Đăng nhập</a>
                            </div>
                        </div>
                        <div class="col-md-2 hidden-sm box-register">
                                <div class="register">
                                    <a class=""  href="#" data-toggle="modal" data-target="#registerModal">Đăng ký</a>
                                </div>
                        </div>
                    @else 
                        <div class="col-md-2 hidden-sm box-create-course">
                            @if(Auth::user()->level == \App\User::USER_TEACHER ||  Auth::user()->level == \App\User::USER_ADMIN)
                                <div class="create-course">
                                    <a class="" href="{{ route('addcourse') }}" >Tạo khóa học</a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-3 hidden-sm box-user">
                                <div class="dropdown">
                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                                    <div class="avatar">
                                                        <img src="{{ Auth::user()->avatar_full }} " />
                                                    </div>
                                                    <div class="username" title="{{ Auth::user()->name_full }}">
                                                            {{ Auth::user()->name_full }}
                                                    </div>
                                                <span class="caret"></span>
                                        </div>                                        
                                        <ul class="dropdown-menu">
                                                <li><a href="{{ route('myCourse') }}">Khóa học của tôi</a></li>
                                                <li><a href="{{ route('courseCreated') }}">Khóa học đã tạo</a></li>
                                                <li><a href="{{ route('courseSupport') }}">Khóa học trợ giảng</a></li>
                                                <li><a href="{{ route('user.wallet.history') }}">Lịch sử ví</a></li>
                                                <li><a href="{{ route('userInfo') }}">Thay đổi thông tin</a></li>
                                                @if(empty(Auth::user()->social_type))
                                                    <li><a href="{{ route('user.change.password') }}">Thay đổi mật khẩu</a></li>
                                                @endif
                                                <li><a href="{{ route('logout') }}">Đăng xuất</a></li>
                                        </ul>    
                                </div>                                
                        </div>
                    @endif
                </div>
             </div>
          </div>
       </div>
    </div>
 </header>