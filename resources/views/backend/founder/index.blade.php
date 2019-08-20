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
                            <a href="{{ route('admin.founder.add') }}" class="btn-primary btn">Thêm founder</a>
                        </div>
                        <div class="panel">
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        {{-- <th width="40">
                                            <div class="icheck checkbox-inline"><input type="checkbox"></div>
                                        </th> --}}
                                        <th>STT</th>
                                        <th>Ảnh</th>
                                        <th>Tiêu đề</th>
                                        <th>Họ tên</th>
                                        <th>Ngày tạo</th>
                                        <th width="150">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['founder'])
                                        @foreach($var['founder'] as $key => $founder)
                                            <tr class="tr">
                                                {{-- <td><div class="icheck checkbox-inline"><input type="checkbox"></div></td> --}}
                                                <td>{{ $key +1 }}</td>
                                                <td><img src="{{ asset($founder->img) }}" style="width: 70px; height: 70px" class="img-thumbnail"></td>
                                                <td>{{ $founder->title }}</td>     
                                                <td>{{ $founder->name }}</td>                                                
                                                <td>{{ date('d-m-Y',$founder->create_at) }}</td>
                                                <td>                                                    
                                                    <a href="{{ route('admin.founder.edit',['id'=>$founder->id]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-pencil"></i>Sửa</a>
                                                    <a href="#" data-id="{{ $founder->id }}" class="btn btn-danger btn-xs btn-label confirmButton"><i class="fa fa-trash-o"></i>Xóa</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>

                                </table>
                                <div class="pagination">
                                    {{ $var['founder']->links('vendor.pagination.default') }}
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
                            url: '{{ route('admin.founder.delete') }}',
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