<div id="menu-mobile">
   <div class="clearfix">
      <div class="account_mobile">
         @if(Auth::check())
            <div class="box_info">
               <div class="box_user">
                  <div class="box_avatar">
                     <img src="{{ Auth::user()->avatar_full }} " />
                  </div>
                  <div class="account_text">
                     <p>tài khoản</p>
                     <p class="username">{{ Auth::user()->name_full }}</p>
                  </div>
               </div>               
               <div class="cart-info">
                     <a class="cart-link" href="{{ route('user.wallet.add') }}">
                      <div class="icon-cart">
                        <img src="{{ web_asset('public/images/groupwallet.png') }}">
                      </div>
                      <span class="wallet">Nạp ví</span>
                   </a>                                    
                </div>
            </div>
            <ul class="account_text menu_account">
               <li><a href="{{ route('myCourse') }}">Khóa học của tôi</a></li>
               <li><a href="{{ route('courseCreated') }}">Khóa học đã tạo</a></li>
               <li><a href="{{ route('courseSupport') }}">Khóa học trợ giảng</a></li>
               <li><a href="{{ route('user.wallet.history') }}">Lịch sử ví</a></li>
               <li><a href="{{ route('userInfo') }}">Thay đổi thông tin</a></li>
               @if(empty(Auth::user()->social_type))
                <li><a href="{{ route('user.change.password') }}">Thay đổi mật khẩu</a></li>
               @endif
               <li><a href="{{ route('logout') }}"><span class="fa fa-sign-out">Đăng xuất</a></li>
            </ul>
         @else
            <ul class="account_text text-center">
               <li><button class="register_account btn btn-default" title="Đăng ký" data-toggle="modal" data-target="#registerModal">Đăng ký</button></li>
               <li>|</li>
               <li><button class="login_account btn btn-default"  title="Đăng nhập" data-toggle="modal" data-target="#loginModal">Đăng nhập</button></li>
            </ul>
         @endif
      </div>
      <ul class="menu-mobile">
        @if(isset($data_all['menus']))
          @foreach($data_all['menus'] as $menu)
            <li class="">
              <a href="{{ $menu->url }}" title="{{ $menu->name }}">{{ $menu->name }}@if(count($menu->child) > 0)<i class="fa fa-angle-right"></i>@endif</a>
                @if(count($menu->child) > 0)
                  <ul class="dropdown-menu submenu-level1-children" role="menu">               
                    @foreach($menu->child as $menu_child)
                      <li class="">
                        <a href="{{ $menu_child->url }}" title="{{ $menu_child->name }}">{{ $menu_child->name }}</a>
                      </li>  
                    @endforeach                      
                  </ul>
                @endif
            </li>
          @endforeach
        @endif         
      </ul>
   </div>
</div>