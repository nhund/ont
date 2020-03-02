<div class="sidebar">
    <div class="widget stay-on-collapse">
        <div class="widget-body welcome-box tabular">
            <div class="tabular-row">
                @if(Auth::user())
                    <div class="tabular-cell welcome-avatar">
                        <img class="img-circle avatar" src="{{ Auth::user()->avatar_full }}" alt="Avatar" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="widget stay-on-collapse" id="widget-sidebar">
        <span class="widget-heading">MANAGER</span>
        <nav class="widget-body">
            <ul class="acc-menu">
                @if(Auth::user()->level == \App\User::USER_ADMIN)
                    {{--<li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i><span>Dashboard</span></a></li>--}}
                    <li class="hasChild {{ Request()->route()->getPrefix() == 'admin/course' ? 'active':''  }}"><a href="javascript:;"><i class="fa fa-book"></i><span>Khóa học</span></a>
                        <ul class="acc-menu" @if(Request()->route()->getPrefix() == 'admin/course' ? 'active':'')  style="display: block" @endif>
                            <li ><a class="{{ url()->current() == route('addcourse') ? 'active':''  }}" href="{{ route('addcourse') }}">Tạo khóa học</a></li>
                            <li><a class="{{ url()->current() == route('admin.course.index') ? 'active':''  }}" href="{{ route('admin.course.index') }}">Danh sách khóa học</a></li>
                        </ul>
                    </li>
                    <li class="hasChild {{ Request()->route()->getPrefix() == 'admin/user' ? 'active':''  }}"><a href="javascript:;"><i class="fa fa-group"></i><span>Thành viên</span></a>
                        <ul class="acc-menu" @if(Request()->route()->getPrefix() == 'admin/user' ? 'active':'')  style="display: block" @endif>    
                            <li ><a class="{{ url()->current() == route('admin.user.add') ? 'active':''  }}" href="{{ route('admin.user.add') }}">Thêm thành viên</a></li>                    
                            <li><a class="{{ url()->current() == route('admin.user.index') ? 'active':''  }}" href="{{ route('admin.user.index') }}">Danh sách thành viên</a></li>
                        </ul>
                    </li>
                    <li class="hasChild {{ Request()->route()->getPrefix() == 'admin/post' ? 'active':''  }}"><a href="javascript:;"><i class="fa fa-eyedropper"></i><span>Bài viết</span></a>
                        <ul class="acc-menu" @if(Request()->route()->getPrefix() == 'admin/post' ? 'active':'')  style="display: block" @endif>
                            <li ><a class="{{ url()->current() == route('admin.post.add') ? 'active':''  }}" href="{{ route('admin.post.add') }}">Thêm bài viết</a></li>
                            <li><a class="{{ url()->current() == route('admin.post.index') ? 'active':''  }}" href="{{ route('admin.post.index') }}">Danh sách bài viết</a></li>
                        </ul>
                    </li>
                    <li class="hasChild {{ Request()->route()->getPrefix() == 'admin/category' ? 'active':''  }}"><a href="javascript:;"><i class="fa fa fa-book"></i><span>Danh mục</span></a>
                        <ul class="acc-menu" @if(Request()->route()->getPrefix() == 'admin/category' ? 'active':'')  style="display: block" @endif>
                            <li><a class="{{ url()->current() == route('admin.category.index') ? 'active':''  }}" href="{{ route('admin.category.index') }}">Danh mục bài viết</a></li>
                            <li><a class="{{ url()->current() == route('admin.news.index') ? 'active':''  }}" href="{{ route('admin.news.index') }}">Danh mục Blog TMU</a></li>
                        </ul>
                    </li>
                    <li class="hasChild {{ Request()->route()->getPrefix() == 'admin/school' ? 'active':''  }}"><a href="javascript:;"><i class="fa fa fa-graduation-cap"></i><span>Trường học</span></a>
                        <ul class="acc-menu" @if(Request()->route()->getPrefix() == 'admin/school' ? 'active':'')  style="display: block" @endif>
                            <li ><a class="{{ url()->current() == route('admin.school.add') ? 'active':''  }}" href="{{ route('admin.school.add') }}">Thêm trường học</a></li>
                            <li><a class="{{ url()->current() == route('admin.school.index') ? 'active':''  }}" href="{{ route('admin.school.index') }}">Danh sách trường học</a></li>
                        </ul>
                    </li>
                    {{-- <li class="hasChild {{ Request()->route()->getPrefix() == 'admin/slider' ? 'active':''  }}"><a href="javascript:;"><i class="fa fa-image"></i><span>Slider</span></a>
                        <ul class="acc-menu" @if(Request()->route()->getPrefix() == 'admin/slider' ? 'active':'')  style="display: block" @endif>
                            <li ><a class="{{ url()->current() == route('admin.slider.add') ? 'active':''  }}" href="{{ route('admin.slider.add') }}">Thêm slider</a></li>
                            <li><a class="{{ url()->current() == route('admin.slider.index') ? 'active':''  }}" href="{{ route('admin.slider.index') }}">Danh sách slider</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="hasChild {{ Request()->route()->getPrefix() == 'admin/founder' ? 'active':''  }}"><a href="javascript:;"><i class="fa fa-anchor"></i><span>Founder</span></a>
                        <ul class="acc-menu" @if(Request()->route()->getPrefix() == 'admin/founder' ? 'active':'')  style="display: block" @endif>
                            <li ><a class="{{ url()->current() == route('admin.founder.add') ? 'active':''  }}" href="{{ route('admin.founder.add') }}">Thêm Founder</a></li>
                            <li><a class="{{ url()->current() == route('admin.founder.index') ? 'active':''  }}" href="{{ route('admin.founder.index') }}">Danh sách Founder</a></li>
                        </ul>
                    </li> --}}

                    <li class="hasChild"><a href="javascript:;"><i class="fa fa-cog"></i><span>Cài đặt chung</span></a>
                        <ul class="acc-menu">
                            <li ><a class="{{ url()->current() == route('admin.about.index') ? 'active':''  }}" href="{{ route('admin.about.index') }}">Thông tin website</a></li>
                            <li><a class="{{ url()->current() == route('admin.user_feel.index') ? 'active':''  }}" href="{{ route('admin.user_feel.index') }}">Nhận xét - Đánh giá</a></li>
                            <li><a class="{{ url()->current() == route('admin.feedback.index') ? 'active':''  }}" href="{{ route('admin.feedback.index') }}">Phản hồi</a></li>
                            <li><a class="{{ url()->current() == route('admin.slider.index') ? 'active':''  }}" href="{{ route('admin.slider.index') }}">Slider</a></li>
                            <li><a class="{{ url()->current() == route('admin.founder.index') ? 'active':''  }}" href="{{ route('admin.founder.index') }}">Founder</a></li>
                            <li><a class="{{ url()->current() == route('admin.menu.index') ? 'active':''  }}" href="{{ route('admin.menu.index') }}">Menu ngang</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('admin.contact.index') }}"><i class="fa fa-comment-o"></i><span>Tin nhắn</span></a></li>                    
                    <li><a href="{{ route('code.list') }}"><i class="fa fa-barcode"></i><span>Tạo Mã Code</span></a></li>
                    <li><a href="{{ route('admin.toolUpload') }}"><i class="fa fa-image"></i><span>Upload ảnh</span></a></li>
                @else 
                   @if(Auth::user()->level == \App\User::USER_TEACHER) 
                        <li><a href="{{ route('addcourse') }}"><i class="fa fa-pencil-square-o"></i><span>Tạo khóa học</span></a></li>     
                   @endif
                @endif
                
            </ul>
        </nav>
    </div>
</div>