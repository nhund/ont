@extends('backend.layout')
@section('title', 'Danh sách bài viết')
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <a href="{{ route('admin.post.add') }}" class="btn-primary btn">Thêm bài viết</a>
                        </div>
                        <div class="col-sm-4">
                            <select name="category_id" class="form-control" id="category-news" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                <option value="{{route('admin.post.index')}}">--Chọn Loại bài viết --</option>
                                <option {{request('type') == 'news' ? 'selected' :''}} value="{{route('admin.post.index', ['type' => 'news'])}}">Tin tức</option>
                                <option {{request('type') == 'posting' ? 'selected' :''}} value="{{route('admin.post.index', ['type' => 'posting'])}}">Bài viết</option>
                            </select>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12">

                        <div class="panel">
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        {{-- <th width="40">
                                            <div class="icheck checkbox-inline"><input type="checkbox"></div>
                                        </th> --}}
                                        <th width="100">STT</th>
                                        <th>Tiêu đề</th>                   
{{--                                        <th>Nội dung</th>                                                                        --}}
                                        <th width="100">Chuyên mục</th>
                                        <th width="100">Trạng thái</th>
                                        <th width="150">Ngày tạo</th>
                                        <th width="150">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['posts'])
                                        @foreach($var['posts'] as $key => $post)
                                            <tr class="tr">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a target="_blank" href="{{ route('post.detail',['id'=>$post->id,'title'=>str_slug($post->name)]) }}">{{ $post->name }}</a>
                                                </td>   
{{--                                                <td>{{ substr($post->des, 0, 100)  }}</td>--}}
                                                <td>{{ \App\Models\CategoryNews::find($post->category_id)['name']}}</td>
                                                <td>
                                                    @if($post->status == \App\Models\Post::STATUS_OFF)
                                                        <span style="color: #c9302c; font-weight: bold;">Ẩn</span>
                                                    @else
                                                        <span style="color: #5cb85c;font-weight: bold;">Hiển thị</span>
                                                    @endif
                                                </td>                                                 
                                                <td>{{ date('d-m-Y',$post->create_date) }}</td>
                                                <td>                                                    
                                                    <a href="{{ route('admin.post.edit',['id'=>$post->id, 'type' => $post->type]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-pencil"></i>Sửa</a>
                                                    <a href="#" data-id="{{ $post->id }}" class="btn btn-danger btn-xs btn-label confirmButton"><i class="fa fa-trash-o"></i>Xóa</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                <div class="pagination">
                                    {{ $var['posts']->links('vendor.pagination.default') }}
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
                            url: '{{ route('admin.post.delete') }}',
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