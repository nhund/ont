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
               <li class="active"><span>Thông tin thành viên</span></li>

           </ol>
       </div>
   </div>
</div>
</div>
<section id="collection" class="clearfix">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                
            <div class="row product-lists product-item box-product-lists clearfix" id="event-grid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-3">
                        <div class="text-center">
                            <img src="{{ !empty($var['user']->avatar) ? web_asset($var['user']->avatar) : web_asset('public/images/avatar-default.png') }}" id="user_avatar" class="avatar img-circle" style="width: 100px; height: 100px" alt="avatar">
                            <h6>Tải lên ảnh đại diện</h6>

                            <input type="file" id="upload_avatar" class="form-control">
                        </div>
                    </div>

                    <!-- edit form column -->
                    <div class="col-md-9 personal-info">

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('user.edit.userInfo') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Họ tên:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" name="full_name" value="{{ $var['user']->full_name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Ngày sinh:</label>
                                <div class="col-md-6">
                                    <div class="input-group date" id="datepicker-pastdisabled">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" value="{{ date('d-m-Y',$var['user']->birthday) }}"  name="birthday" class="form-control" id="datepicker" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Giới tính:</label>
                                <div class="col-lg-8">
                                    <label class="radio-inline"><input type="radio" name="gender" value="{{\App\User::GENDER_MALE}}" @if($var['user']->gender == \App\User::GENDER_MALE) checked @endif>Nam</label>
                                    <label class="radio-inline"><input type="radio" name="gender" value="{{\App\User::GENDER_FEMALE}}" @if($var['user']->gender == \App\User::GENDER_FEMALE) checked @endif>Nữ</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Số điện thoại:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="text" value="{{ $var['user']->phone }}" name="phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Email:</label>
                                <div class="col-lg-8">
                                    <input class="form-control" readonly type="text" name="email" value="{{ $var['user']->email }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Trường học:</label>
                                <div class="col-lg-8">
                                    <select class="form-control text_box" name="school_id">
                                        @if(empty($var['user']->school_id))
                                            <option value="0">Chọn trường</option>
                                        @endif
                                        @foreach($var['schools'] as $school)
                                            <option @if($school->id == $var['user']->school_id) selected @endif value="{{ $school->id }}">{{ $school->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Giới thiệu bản thân:</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" rows="5" name="note">{{ $var['user']->note }}</textarea>
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
<script src="{{ web_asset('public/admintrator/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#datepicker").datepicker({
            format: "d-m-yyyy",
            todayHighlight: true
        });

        $('#upload_avatar').change(function () {
            var file = $(this)[0].files[0];
            /*check type is images*/
            var fileType = file["type"];
            var ValidImageTypes = ["image/gif", "image/jpeg", "image/png", "image/jpg"];
            if ($.inArray(fileType, ValidImageTypes) < 0) {
                swal({
                    title: 'File không hợp lệ',
                    type: "error"
                });
                return false;
            }
            var formData = new FormData();
            formData.append('file', file);
            formData.append('_token', $('meta[name=csrf-token]').attr("content"));
            $('#openModalLoading').show();
            $.ajax({
                type: "POST",
                url: '{{route('user.upload.avatar')}}',
                contentType: false,
                dataType: 'json',
                cache: false,
                processData: false,
                data: formData,
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {

                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            var a = Math.round(percentComplete * 100) + "%";
                            console.log(a);
                                    //current.find('.uk-progress .uk-progress-bar').css("width", a);
                                }
                            }, false);
                    xhr.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {

                        }
                    }, false);
                    return xhr;
                },
                success: function (result) {

                    if (result.error === false) {
                        $('#openModalLoading').hide();
                        $("#user_avatar").attr("src",result.url);
                        swal({
                            title: "Thông báo",
                            text: result.msg,
                            timer: 2000,
                            type : 'success',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }else{

                    }
                },
                error: function (result) {
                    swal({
                        title: "Thông báo",
                        text: result.msg,
                        timer: 5000,
                        type : 'error',
                    })
                }
            }).always(function () {



            });


        });
        
    });
</script>
@endpush