@extends('backend.layout')
@section('title', 'Danh sách tài khoản')
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
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Tên tài khoản</th>
                                        <th>Tên</th>
                                        <th>Xu</th>
                                        <th>Trạng thái</th>
                                        <th width="100">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['users'])
                                        @foreach($var['users'] as $key => $user)
                                            <tr class="tr">
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->full_name}}</td>
                                                <td>{{ number_format($user->xu) }}</td>
                                                <td>
                                                    @if($user->status == \App\Models\Wallet::STATUS_ON)
                                                        <span style="color: #5cb85c;font-weight: bold;">Hoạt động</span>
                                                    @endif
                                                    @if($user->status == \App\Models\Wallet::STATUS_OFF)
                                                        <span style="color: #c9302c; font-weight: bold;">Khóa</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.report.detail',['id'=>$user->id]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-eye"></i>Chi tiết</a>
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