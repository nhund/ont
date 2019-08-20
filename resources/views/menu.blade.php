<div class="navbar-header">
    <div class="flexbox-grid-default hidden-lg hidden-md hidden-sm">
       <div class="flexbox-content box-logo-mobile">
          <div class="logo-mobile">
             <a href="{{ route('home') }}" title="Trang chủ">             
             <img src="{{ isset($data_all['about']->logo) ? web_asset($data_all['about']->logo) : '' }}" alt="{{ isset($data_all['about']->title) ? $data_all['about']->title : '' }}" />
             </a>
          </div>
       </div>
       <div class="flexbox-auto">
          <div class="mobile-menu-icon-wrapper">
             <ul class="mobile-menu-icon clearfix">
                <li class="search">
                   <div class="btn-group">
                      <button type="button" class="btn btn-default dropdown-toggle icon-search" data-toggle="dropdown" aria-expanded="false">
                         <i class="fa fa-search"></i>
                      </button>
                      <div class="dropdown-menu" role="menu">
                         <div class="search-bar">
                            <div class="">                               
                                <form class="col-md-12" action="{{ route('search') }}" method="GET">  
                                  <input type="hidden" name="type" value="" />
                                  <input type="text" name="q" placeholder="Tìm kiếm..." />
                               </form>
                            </div>
                         </div>
                      </div>
                   </div>
                </li>
                {{-- <li id="cart-target" class="cart">
                   <a href="cart.html" class="cart " title="Giỏ hàng">
                      <svg class="svg-next-icon svg-next-icon-size-20">
                         <use xmlns:xlink="https://www.w3.org/1999/xlink" xlink:href="#icon-cart-header"></use>
                      </svg>
                      <span id="cart-count">0</span>
                   </a>
                </li> --}}
             </ul>
          </div>
       </div>
    </div>
 </div>
<div id="navbar" class="navbar-collapse collapse">
    <div class="row clearfix">
       <div class="col-lg-6 col-md-6 col-sm-6">
          <ul class="nav navbar-nav clearfix">
            @if(isset($data_all['menus']))
              @foreach($data_all['menus'] as $menu)
                <li class="">
                  <a href="{{ $menu->url }}" title="{{ $menu->name }}">{{ $menu->name }} @if(count($menu->child) > 0)<i class="fa fa-angle-down">@endif</i></a>
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
       <div class="col-lg-6 col-md-6 col-sm-6">
          <ul class="icon-control-header text-right">
             <li class="search-header">
               <div class="dropdown-menu-search form-search">
                  <form action="{{ route('search') }}" method="GET">                      
                      <input type="text" class="form-control" name="q" placeholder="Tìm kiếm...">
                      <button type="submit"><i class="fa fa-search"></i></button>
                  </form>
                </div>
             </li>
             <li class="cart">
                <div class="cart-info">
                     <a class="cart-link" href="{{ route('user.wallet.add') }}">
                      <div class="icon-cart">
                        <img src="{{ web_asset('public/images/groupwallet.png') }}" />
                      </div>
                      <span class="wallet">Nạp ví</span>
                   </a>                                    
                </div>
             </li>
          </ul>
       </div>
    </div>
 </div>