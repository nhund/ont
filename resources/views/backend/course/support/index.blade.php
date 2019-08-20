@extends('backend.layout')
@section('title', 'Danh sách trợ giảng')
@push('css')
    <style type="text/css">
    .search-form {
        position: relative;
        max-width: 100%;
    }
    .instant-results {
        background: #fff;
        width: 300px;
        color: gray;
        position: absolute;
        top: 45px;
        left: 0;
        border: 1px solid rgba(0, 0, 0, .15);
        border-radius: 4px;
        -webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
        box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
        display: none;
        z-index: 9;
    }
    .result-link {
        color: #4f7593;
    }
    .result-link .media-body {
        font-size: 13px;
        color: gray;
    }
    .result-link .media-heading {
        font-size: 15px;
        font-weight: 400;
        color: #4f7593;
    }
    .result-link .media{
        display: flex;
        align-items: center;
    }
    .result-link .media:hover{
        background: #eaeaea;
    }
    .result-link:hover,
    .result-link:hover .media-heading,
    .result-link:hover .media-body {
        text-decoration: none;
        color: #4f7593
    }
    .result-link .media-object {
        width: 50px;
        padding: 3px;
        border: 1px solid #c1c1c1;
        border-radius: 3px;
    }
    .result-entry + .result-entry {
        border-top:1px solid #ddd;
    }
    .top-keyword {
        margin: 3px 0 0;
        font-size: 12px;
        font-family: Arial;
    }
    .top-keyword a {
        font-size: 12px;
        font-family: Arial;
    }
    .top-keyword a:hover {
        color: rgba(0, 0, 0, 0.7);
    }
    </style>

@endpush
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            
                                <form method="POST" action="{{ route('admin.course.support.save') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                                    {{ csrf_field() }}                                                                    
                                    <input type="hidden" name="course_id" value="{{ $var['course']->id }}">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Họ tên</label>
                                        <div class="col-sm-2">
                                            <div class="search-form">
                                                <input type="hidden" name="user_id" value="">
                                                <input type="text" name="name" placeholder="Họ tên" class="form-control" autocomplete="off" >
                                                <div class="instant-results">
                                                    {{-- @include('backend.course.support.list_user') --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                        
                                    <div class="form-group pb0">
                                        <label for="" class="control-label col-sm-2">Trạng thái</label>
                                        <div class="col-sm-2 tabular-border">
                                            <select class="form-control" name="status">                                                                    
                                                <option value="{{ \App\Models\TeacherSupport::STATUS_ON }}">hoạt động</option>
                                                <option value="{{ \App\Models\TeacherSupport::STATUS_OFF }}">khóa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <input type="submit" class="btn-primary btn" value="Save">
                                            <button class="btn-default btn">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                
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
                                        <th>Họ tên</th>
                                        <th>Trang thái</th>
                                        <th>Ngày tạo</th>
                                        <th width="150">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['supports'])
                                        @foreach($var['supports'] as $key => $support)
                                            <tr class="tr">
                                                {{-- <td><div class="icheck checkbox-inline"><input type="checkbox"></div></td> --}}
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img src="{{ asset($support->user->avatar_full) }}" style="width: 50px; height: 50px" class="img-thumbnail"></td>
                                                <td>{{ $support->user->name_full }}</td>                                                    <td>                                                    
                                                    @if($support->status == \App\Models\TeacherSupport::STATUS_ON)
                                                        <span style="color: #5cb85c;font-weight: bold;">hoạt động</span>
                                                    @endif
                                                    @if($support->status == \App\Models\TeacherSupport::STATUS_OFF)
                                                        <span style="color: #c9302c; font-weight: bold;">khóa</span>
                                                    @endif
                                                </td>                                         
                                                <td>{{ date('d-m-Y H:i',$support->create_date) }}</td>
                                                <td>                                                    
                                                    {{-- <a href="{{ route('admin.founder.edit',['id'=>$founder->id]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-pencil"></i>Sửa</a> --}}
                                                    <a href="#" data-id="{{ $support->id }}" class="btn btn-danger btn-xs btn-label confirmButton"><i class="fa fa-trash-o"></i>Xóa</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>

                                </table>
                                <div class="pagination">
                                    {{ $var['supports']->links('vendor.pagination.default') }}
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
        var sugges_user = '{{ route('admin.course.support.suggesUser') }}';
    </script>    
    <script src="{{ web_asset('/public/admintrator/assets/js/teacher_support.js') }}"></script>
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
                            url: '{{ route('admin.course.support.delete') }}',
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