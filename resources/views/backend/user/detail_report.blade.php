@extends('backend.layout')
@section('title', 'Chi tiết tài khoản')
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Họ và tên</th>
                                        <th>Tên khóa học</th>
                                        <th>Giá</th>
                                        <th>status</th>
                                        <th width="150">Ngày giao dịch</th>
                                        <th width="150">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['histories'])
                                        @foreach ($var['histories'] as $item)
                                            <tr data-user="{{$item->id}}">
                                                <td data-title="Họ tên :">{{$item->user->name_full}}</td>
                                                <td data-title="Họ tên :">{{ $item->course->name }}</td>
                                                <td data-title="Giá :">{{ number_format($item->course->price) }} VNĐ</td>
                                                <td data-title="Trạng thái :">{!! App\Models\Course::STATUS[$item->course->status] !!} </td>
                                                <td data-title="Ngày tạo :">{{ date('d/m/Y H:i',$item->created_at) }}</td>
                                                <td><button  data-user="{{$item->user->id}}" data-id="{{$item->course->id}}" class="btn-warning btn refundButton" >Hoàn khóa học</button></td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">Tài khoản chưa có giao dịch</td>
                                        </tr>
                                    @endif
                                    </tbody>

                                </table>
                                <div class="pagination">
                                    {{ $var['histories']->links('vendor.pagination.default') }}
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
            $('.refundButton').on('click',function () {
                var $this = $(this);
                swal({
                     title: "Xác nhận",
                     text: "Bạn có chắc muốn hoàn lại khóa học!",
                     type: "warning",
                     showCancelButton: true,
                     confirmButtonColor: "#DD6B55",
                     confirmButtonText: "Đồng ý",
                     closeOnConfirm: false
                 },
                 function () {
                     $.ajax({
                            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
                            type: "POST",
                            url: '{{ route('admin.course.refund') }}',
                            data: {
                                user_id: $this.attr('data-user'),
                                course_id: $this.attr('data-id')
                            },
                            success: function (data) {
                                if(data.error == false){
                                    $this.closest('tr').remove();
                                    swal(
                                        'Hoàn khóa học!',
                                        'Hoàn khóa học thành công',
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