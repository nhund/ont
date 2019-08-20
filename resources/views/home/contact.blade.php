@extends('layout')
@section('content')    
<div class="header-navigate clearfix mb15">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                <ol class="breadcrumb breadcrumb-arrow">
                    <li><a href="../index.html" target="_self">Trang chủ</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active"><span>Liên hệ</span></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="layout-page contact clearfix">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 pd5">
                <h1>
                    Liên hệ
                </h1>                    
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="page-left-contact clearfix">
                            <div class="page-right-contact clearfix">                                        
                                <div class="phone">
                                    <i class="fa fa-phone" aria-hidden="true"></i> <span>{{ $about->phone }}</span>
                                </div>                                                                                    
                                <div class="address">
                                    <i class="fa fa-home" aria-hidden="true"></i> <span>{{ $about->address }}</span>
                                </div>
                                <div class="address">
                                    <i class="fa fa-envelope" aria-hidden="true"></i> <span>{{ $about->email }}</span>
                                </div>
                                <div class="address">
                                    <i class="fa  fa-facebook-square" aria-hidden="true"></i> <span><a href="{{ $about->page_facebook }}">Fanpage facebook</a></span>
                                </div>
                                <div class="address">
                                    <i class="fa  fa-facebook-square" aria-hidden="true"></i> <span><a href="{{ $about->group_facebook }}">Group facebook</a></span>
                                </div>
                            </div>
                            <div class="title-send">Tin nhắn</div>
                            <form accept-charset='UTF-8' action='{{ route('contactPost') }}' class='contact-form' method='post'>
                                {{ csrf_field() }}                                    
                                <input name='utf8' type='hidden' value='✓'>
                                <div class="contact-form page-form-contact">
                                    <div class="clearfix">
                                        <div class="col-sm-12 col-xs-12 box-input">
                                            <div class="input-group">                                                
                                                <input type="text" name="name" class="form-control" placeholder="Họ và tên" value="{{ isset($var['user']) ? $var['user']->full_name : '' }}">
                                            </div>
                                            <div class="input-group">                                                
                                                <input type="text" name="email" class="form-control" placeholder="Email" value="{{ isset($var['user']) ? $var['user']->email : '' }}">
                                            </div>
                                            <div class="input-group">                                                
                                                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại" value="{{ isset($var['user']) ? $var['user']->phone : '' }}">
                                            </div>
                                            <div class="input-group">
                                                <textarea name="content" placeholder="Nhập nội dung tin nhắn"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-xs-12" style="padding:0px;">
                                            <button>
                                                Gửi tin nhắn
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="clearfix page-description">
                            <p id="map_canvas" class="text-center">
                                {!! $about->map !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop