@extends('backend.layout')
@section('title', 'Dashboard')
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="{{ route('admin.user_feel.add') }}" class="btn-primary btn">Thêm đánh giá</a>
                        </div>
                        <div class="panel">
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        {{-- <th width="40">
                                            <div class="icheck checkbox-inline"><input type="checkbox"></div>
                                        </th> --}}
                                        <th width="100">STT</th>
                                        <th width="50">Ảnh</th>
                                        <th>Họ tên</th>
                                        <th>Địa chỉ</th>
                                        <th>Nội dung</th>                                        
                                        <th>Ngày tạo</th>
                                        <th>Trang thái</th>
                                        <th width="150">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['users'])
                                        @foreach($var['users'] as $key => $user)
                                            <tr class="tr">
                                                {{-- <td><div class="icheck checkbox-inline"><input type="checkbox"></div></td> --}}
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img src="{{ asset($user->avatar) }}" style="width: 50px; height: 50px" class="img-thumbnail"></td>
                                                <td>{{ $user->name }}</td>     
                                                <td>{{ $user->school }}</td>
                                                <td>{{ $user->title }}</td>                                                
                                                <td>{{ date('d-m-Y',$user->create_date) }}</td>
                                                <td>
                                                    @if($user->status == \App\Models\UserFeel::STATUS_ON)
                                                        <span style="color: #5cb85c;font-weight: bold;">Public</span>
                                                    @else
                                                        <span style="color: #c9302c; font-weight: bold;">private</span>                                                        
                                                    @endif
                                                </td>
                                                <td>                                                    
                                                    <a href="{{ route('admin.user_feel.edit',['id'=>$user->id]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-pencil"></i>Sửa</a>
                                                    <a href="#" data-id="{{ $user->id }}" class="btn btn-danger btn-xs btn-label confirmButton"><i class="fa fa-trash-o"></i>Xóa</a>
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

    <script type="text/javascript">
        $(document).ready(function() {
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
                            url: '{{ route('admin.user_feel.delete') }}',
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