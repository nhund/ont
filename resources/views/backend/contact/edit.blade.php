@extends('backend.layout')
@section('title', 'Dashboard')
@section('content')
@include('backend.include.breadcrumb')
<div class="container-fluid">
    <div id="panel-advancedoptions">
        <div class="container-fluid">
            <div id="panel-advancedoptions">
                <div class="panel panel-default" data-widget-editbutton="false">
                    <div class="panel-heading">
                        <h2>Sửa thành viên</h2>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-9">
                                <form method="POST" action="{{ route('admin.user.update') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $var['user']->id }}">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Chức vụ</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="level">
                                                <option @if($var['user']->level == \App\User::USER_STUDENT) selected @endif value="{{ \App\User::USER_STUDENT }}">Học sinh</option>
                                                <option  @if($var['user']->level == \App\User::USER_TEACHER) selected @endif  value="{{ \App\User::USER_TEACHER }}">Giáo viên</option>
                                                <option  @if($var['user']->level == \App\User::USER_ADMIN) selected @endif  value="{{ \App\User::USER_ADMIN }}">Admin</option>
                                            </select>                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Tên tài khoản</label>
                                        <div class="col-sm-8">
                                            <input type="text" value="{{ $var['user']->name }}" name="name" placeholder="Tên tài khoản" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Họ tên</label>
                                        <div class="col-sm-8">
                                            <input type="text" value="{{ $var['user']->full_name }}" name="full_name" placeholder="Họ tên" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-8">
                                            <input type="text" value="{{ $var['user']->email }}" name="email" placeholder="Email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Phone</label>
                                        <div class="col-sm-8">
                                            <input type="text" value="{{ $var['user']->phone }}" name="phone" placeholder="Phone" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Mật khẩu</label>
                                        <div class="col-sm-8">
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Giới tính</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="gender">
                                                <option @if($var['user']->gender == \App\User::GENDER_MALE) selected @endif value="{{ \App\User::GENDER_MALE }}">Nam</option>
                                                <option @if($var['user']->gender == \App\User::GENDER_FEMALE) selected @endif value="{{ \App\User::GENDER_FEMALE }}">Nữ</option>
                                            </select>                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Tải ảnh đại diện</label>
                                        <div class="col-sm-5">
                                            <div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 100%; height: 150px;">
                                                    @if(!empty($var['user']->avatar))
                                                            <img src="{{ asset($var['user']->avatar) }}" />
                                                        @endif
                                                </div>
                                                <div>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Xóa ảnh</a>
                                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Tải ảnh</span>
                                                    <span class="fileinput-exists">Đổi ảnh khác</span>
                                                    <input type="file" name="file">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group pb0">
                                    <label for="" class="control-label col-sm-2">Trạng thái</label>
                                    <div class="col-sm-2 tabular-border">
                                        <select class="form-control" name="status">
                                            <option @if($var['user']->status == \App\User::STATUS_ACTIVE) selected @endif value="{{ \App\User::STATUS_ACTIVE }}">Hoạt động</option>
                                            <option @if($var['user']->status == \App\User::STATUS_BLOCK) selected @endif  value="{{ \App\User::STATUS_BLOCK }}">Khóa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <input type="submit" class="btn-primary btn" value="Save">
                                            <a href="{{ route('admin.user.index')}}" class="btn-default btn">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
</div>
@stop
@push('js')

{{-- <script src="{{ asset('public/admintrator/assets/plugins/ckfinder/ckfinder.js') }}"></script>     --}}

<script type="text/javascript">

</script>
@endpush