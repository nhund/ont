@extends('backend.layout')
@section('title', 'Danh sách khóa học')
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
                            <a href="{{ route('addcourse') }}" class="btn-primary btn">Thêm khóa học</a>
                        </div>
                        <div class="form-group">
                            <form action="{{ route('admin.course.index') }}" id="form_search_course" class="form-inline mb10" method="GET">
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
                                                <input type="text" value="{{ isset($var['params']['name'])?$var['params']['name']:'' }}" name="name" placeholder="#Tên" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" name="phone" value="{{ isset($var['params']['phone'])?$var['params']['phone']:'' }}" placeholder="Số điện thoại" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" value="{{ isset($var['params']['email'])?$var['params']['email']:'' }}" name="email" placeholder="email" class="form-control">
                                            </div>
                                        </div> --}}
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control" name="created_at" value="{{ isset($var['params']['created_at'])?$var['params']['created_at']:'' }}" placeholder="#Ngày tạo" autocomplete="off" id="daterangepicker1">
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
                                        <th width="50">Ảnh</th>
                                        <th width="200">Tên</th>
                                        <th width="200">Chuyên mục</th>                                                                                
                                        <th width="200">Người tạo</th>
                                        <th width="200">Giá</th>
                                        <th width="100">Ngày tạo</th> 
                                        <th width="100">Thời gian học</th>
                                        <th width="100">Trạng thái</th>
                                        <th width="100">Nổi bật</th>                                                                        
                                        <th width="150">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['courses'])
                                        @foreach($var['courses'] as $key => $course)
                                            <tr class="tr">                                                
                                                <td>
                                                    <img src="{{ $course->avatar_thumb }}" class="" style="width: 50px; height: 50px;">                                                 
                                                </td>
                                                <td>
                                                    {{ $course->name }}
                                                </td>
                                                <td>
                                                    {{ $course->category->name }}
                                                </td>
                                                <td>
                                                   <span>({{ $course->user->position }})</span> - {{ $course->user->name_full }}
                                                </td>
                                                <td>
                                                    <span style="color: #FF3F3F;">{{ number_format($course->price_new) }}đ</span> 
                                                    @if((int)$course->price > 0)
                                                        <span style="color: #9298A3;">( {{ number_format($course->price) }})đ</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ date('d-m-Y H:i',$course->created_at ) }}                                                    
                                                </td>
                                                <td>
                                                    {{ date('d-m-Y H:i',$course->study_time ) }}

                                                </td>  
                                                <td>                                                    
                                                    @if($course->status == \App\Models\Course::TYPE_FREE_TIME)
                                                        <span style="color: #FF8515;font-weight: bold;">Miễn phí có thời hạn</span>
                                                    @endif
                                                    @if($course->status == \App\Models\Course::TYPE_FREE_NOT_TIME)
                                                        <span style="color: #3c3bb3; font-weight: bold;">Miễn phí không thời hạn</span>
                                                    @endif
                                                    @if($course->status == \App\Models\Course::TYPE_PUBLIC)
                                                        <span style="color: #5cb85c; font-weight: bold;">Công khai</span>
                                                    @endif
                                                    @if($course->status == \App\Models\Course::TYPE_APPROVAL)
                                                        <span style="color: #000; font-weight: bold;">Cần xét duyệt</span>
                                                    @endif
                                                    @if($course->status == \App\Models\Course::TYPE_PRIVATE)
                                                        <span style="color: #c9302c; font-weight: bold;">Riêng tư</span>
                                                    @endif
                                                </td>                                              
                                                <td><div class="icheck checkbox-inline"><input type="checkbox" class="checkbox_sticky" value="{{ $course->id }}" @if($course->sticky == \App\Models\Course::STICKY) checked @endif ></div></td>                                            
                                                <td>
                                                    <a href="{{ route('course.detail',['id'=>$course->id]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-pencil"></i>Sửa</a>
                                                    <a data-id="{{ $course->id }}" href="#" class="btn btn-danger btn-xs btn-label confirmButton"><i class="fa fa-trash-o"></i>Xóa</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>

                                </table>
                                <div class="pagination">
                                    {{ $var['courses']->links('vendor.pagination.default') }}
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
                $('#form_search_course').submit();
            });
            $('.icheck input').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            }).on('ifChanged', function(e) {
                // Get the field name
                var isChecked = e.currentTarget.checked;
                var course_id = e.currentTarget.value;
                var sticky = 0;
                if (isChecked == true) {
                    var sticky = 1;
                }
                $.ajax({
                            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
                            type: "POST",
                            url: '{{ route('admin.course.changeSticky') }}',
                            data: {
                                course_id: course_id,
                                sticky : sticky,
                            },
                            success: function (data) {
                                if(data.error == false){
                                    toastr.success(data.msg,'Thông báo');
                                }else{
                                    toastr.error(data.msg,'Thông báo');
                                }
                            },
                            error: function (e) {
                                console.log(e);
                            }
                        });

            });
            $('.confirmButton').on('click',function (e) {
                e.preventDefault();
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
                            url: '{{ route('admin.course.delete') }}',
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

            //update khoa hoc noi bat
            $(".checkbox_sticky").change(function() {
                var sticky = false;
                if(this.checked) {
                    console.log("checked");
                }else{
                    console.log("un checked");
                }
            });
        });
    </script>
@endpush