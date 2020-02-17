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
                            <a href="{{ route('admin.news.add') }}" class="btn-primary btn">Thêm danh mục tin</a>
                        </div>
                        <div class="panel">
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>STT</th>                                        
                                        <th>Tiêu đề</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th width="150">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($var['categories']) > 0)
                                        @foreach($var['categories'] as $key => $category)
                                            <tr class="tr">
                                                <td>{{ $key +1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                @if($category->status == 1)
                                                    <td>Hiển thị</td>
                                                @else
                                                    <td>Không hiển thị</td>
                                                @endif
                                                <td>{{ date('d-m-Y H:i:s',$category->create_at ) }}</td>
                                                <td>
                                                    <a href="{{ route('admin.news.edit',['id'=>$category->id]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-pencil"></i>Sửa</a>
                                                    <a href="#" data-id="{{ $category->id }}" class="btn btn-danger btn-xs btn-label confirmButton"><i class="fa fa-trash-o"></i>Xóa</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" style="text-align: center">Không có dữ liệu</td>
                                        </tr>
                                    @endif
                                    </tbody>

                                </table>
                                <div class="pagination">
                                    {{ $var['categories']->links('vendor.pagination.default') }}
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
                            url: '{{ route('admin.news.delete') }}',
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