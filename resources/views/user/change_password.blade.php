@extends('layout')

@push('js')    
<link href="{{ web_asset('public/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css">
@endpush

@section('content')
<div class="header-navigate clearfix mb15">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
            <ol class="breadcrumb breadcrumb-arrow">
               <li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
               <li><i class="fa fa-angle-right"></i></li>
               <li class="active"><span>Đổi mật khẩu</span></li>

           </ol>
       </div>
   </div>
</div>
</div>
<section id="collection" class="clearfix">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                
            <div class="row product-lists product-item box-product-lists clearfix change_password" id="event-grid">
                <div class="row">                   
                    <!-- edit form column -->
                    <div class="col-md-9 personal-info">

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('user.change.password.post') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Mật khẩu cũ:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="password" name="password_old" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Mật khẩu mới:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="password" name="password_new" value="">
                                </div>
                            </div>                            
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-8">
                                    <input type="submit" class="save-btn btn btn-primary" value="Lưu thay đổi">
                                    <span></span>
                                    {{-- <a href="#" class="save-btn btn btn-default">Hủy</a> --}}
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>    
@stop
@push('js')

@endpush