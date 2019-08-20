<header id="topnav" class="navbar navbar-inverse navbar-fixed-top clearfix" role="banner">
    <a id="leftmenu-trigger" class="" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
    <a class="navbar-brand" href="{{ url('/manager') }}"></a>
    <div class="yamm navbar-left navbar-collapse collapse">
    </div>

    <ul class="nav navbar-nav toolbar pull-right">
        <li class="dropdown">
            <a href="#" id="navbar-links-toggle" data-toggle="collapse" data-target="header>.navbar-collapse">&nbsp;</a>
        </li>

        <li class="dropdown">
            @if(Auth::user())
                <a href="#" class="dropdown-toggle username" data-toggle="dropdown">
                    <span class="hidden-xs">{{ Auth::user()->name_full }}</span>
                    <img class="img-circle avatar" src="{{ Auth::user()->avatar_full }}" alt="Avatar" />
                </a>
                <ul class="dropdown-menu userinfo">
                    <li>
                        <a href="{{ route('logout') }}">
                            <span class="pull-left">Đăng xuất</span>
                            <i class="pull-right fa fa-sign-out"></i>
                        </a>
                    </li>
                </ul>
            @endif
        </li>

    </ul>
</header>