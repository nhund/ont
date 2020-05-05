@extends('backend.layout')
@section('title', 'Dashboard')
@push('css')

    <link href="{{ asset('public/plugin/form-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css">

@endpush
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="{{ route('admin.user.add') }}" class="btn-primary btn">Thêm thành viên</a>
                        </div>
                        <div class="form-group">
                            <form action="{{ route('admin.user.index') }}" id="form_search_user" class="form-inline mb10" method="GET">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- <div class="col-md-2">
                                            <div class="form-group">
                                                <select name="user_group" id="" class="form-control">
                                                    <option value="">Tất cả thành viên</option>
                                                    <option @if(isset($var['params']['user_group']) && $var['params']['user_group'] == 1) selected  @endif value="3">Thành viên thường</option>
                                                    <option @if(isset($var['params']['user_group']) && $var['params']['user_group'] == 3) selected  @endif value="1">Admin</option>
                                                    <option @if(isset($var['params']['user_group']) && $var['params']['user_group'] == 2) selected  @endif value="2">Thành viên vip</option>                                                    
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" value="{{ isset($var['params']['full_name'])?$var['params']['full_name']:'' }}" name="full_name" autocomplete="off" placeholder="#Họ tên" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" name="phone" value="{{ isset($var['params']['phone'])?$var['params']['phone']:'' }}" placeholder="#Số điện thoại" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" value="{{ isset($var['params']['email'])?$var['params']['email']:'' }}" name="email" placeholder="#email" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control" name="create_at" value="{{ isset($var['params']['create_at'])?$var['params']['create_at']:'' }}" placeholder="#Ngày đăng ký" autocomplete="off" id="daterangepicker1">
                                            </div>
                                        </div>
                                        
                                        
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel">
                            <h4>Tổng số thành viên : {{ number_format($var['users']->total()) }}</h4>
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="50">Ảnh</th>
                                        <th width="100">Chức vụ</th> 
                                        <th width="150">Nguồn</th>                                       
                                        <th>Tên</th>
                                        <th>Tên trường</th>
                                        <th width="100">Phone</th>
                                        <th width="100">Email</th>
                                        <th width="100">Giới tính</th>
                                        <th>Ví hiện tại</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Trạng thái</th>
                                        <th width="150">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['users'])
                                        @foreach($var['users'] as $key => $user)
                                            <tr class="tr">                                                
                                                <td>
                                                    @if(!empty($user->avatar))
                                                        <img src="{{ asset($user->avatar) }}" class="" style="width: 40px; height: 40px;">
                                                    @endif                                                    
                                                </td>
                                                <td>
                                                    @if($user->level == \App\User::USER_STUDENT)
                                                        <span style="color: #00000">Học viên</span>
                                                    @endif
                                                    @if($user->level == \App\User::USER_TEACHER)
                                                        <span style="color: #5cb85c;font-weight: bold;">Giáo viên</span>
                                                    @endif
                                                    @if($user->level == \App\User::USER_ADMIN)
                                                        <span style="color: #c9302c; font-weight: bold;">Admin</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(empty($user->social_type))
                                                          Web      
                                                    @else
                                                        @if($user->social_type == \App\User::LOGIN_FB)
                                                          FaceBook
                                                        @else 
                                                          Google      
                                                        @endif
                                                    @endif                                                    
                                                </td>
                                                <td><a target="_blank" href="#">{{ $user->name_full }}</a></td>
                                                <td>
                                                    {{ $user->school->name }}
                                                </td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if($user->level == \App\User::GENDER_MALE)
                                                        Nam
                                                    @else 
                                                        Nữ
                                                    @endif
                                                </td>
                                                <td>{{ number_format($user->wallet->xu) }}</td>
                                                <td>{{ date('d-m-Y H:i',$user->create_at ) }}</td>
                                                <td>                                                    
                                                    @if($user->status == \App\User::STATUS_ACTIVE)
                                                        <span style="color: #5cb85c;font-weight: bold;">hoạt động</span>
                                                    @endif
                                                    @if($user->status == \App\User::STATUS_BLOCK)
                                                        <span style="color: #c9302c; font-weight: bold;">khóa</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.user.edit',['id'=>$user->id]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-pencil"></i>Sửa</a>
                                                    <a href="{{ route('admin.report.detail',['id'=>$user->id]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-eye"></i>Lịch sử</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>

                                </table>
                                <div class="pagination">
                                    {{ $var['users']->links('vendor.pagination.default') }}
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
    <script src="{{ asset('public/plugin/form-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('public/plugin/form-daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#daterangepicker1').daterangepicker({ format: 'DD/MM/YYYY' });
            $('body').on('click','.daterangepicker .applyBtn',function(event) {
                $('#form_search_user').submit();
            });

            $('.icheck input').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
            $('.confirmButton').on('click',function () {
                var $this = $(this);
                swal({
                    title: "Xác nhận",
                    text: "Bạn có chắc muốn xóa dữ liệu!", type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Đồng ý",
                    closeOnConfirm: false
                },
                function () {
                           $.ajax({
                            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
                            type: "POST",
                            url: '{{ route('admin.user.delete') }}',
                            data: {
                                id: $this.attr('data-id')
                            },
                            success: function (data) {
                                if(data.error == false){
                                    $this.closest('tr').remove();
                                    swal(
                                        'Deleted!',
                                        'Xóa thành công',
                                        'success'
                                    )
                                }
                            },
                            error: function (e) {
                                console.log(e);
                            }
                        });
                });
            });
        });
    </script>
@endpush