@extends('backend.layout')
@section('title', 'Danh sách bài học')
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">                                                
                        <div class="panel">
                            <div class="panel-body panel-no-padding">
                                <div class="col-md-6">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h2>Danh sách bài học - kéo để sắp sếp</h2>                                        
                                        </div>
                                        <div class="panel-heading">                                        
                                            <a href="{{ route('course.detail',['id'=>$var['course']->id]) }}">Khóa học : {{ $var['course']->name }}</a>
                                        </div>
                                        <div class="panel-body">
                                            <div class="dd" id="nestable_list_2">
                                                <ol class="dd-list">
                                                    <input type="hidden" name="lesson" value="">
                                                    @foreach($var['lessons'] as $lesson)
                                                        <li class="dd-item" data-id="{{ $lesson->id }}" data-type="root">
                                                            <div class="dd-handle">
                                                                {{ $lesson->name }}
                                                            </div>
                                                            <div class="action" style="text-align: right;">
                                                                <a href="{{ route('lesson.detail', ['id' => $lesson->id]) }}" title="Sửa {{ $lesson->name }}" class=""><i class="fa fa-pencil"></i>Sửa</a>
                                                                <a href="#" data-id="{{ $lesson->id }}" title="Xóa {{ $lesson->name }}" class="confirmButton"><i class="fa fa-trash-o"></i>Xóa</a>
                                                            </div>   
                                                            @if(isset($lesson->childs))
                                                                <ol class="dd-list">
                                                                    @foreach($lesson->childs as $child)
                                                                        <li class="dd-item" data-id="{{ $child->id }}" data-type="child">
                                                                            <div class="dd-handle">
                                                                                {{ $child->name }}
                                                                            </div>
                                                                            <div class="action" style="text-align: right;">
                                                                                <a href="{{ route('admin.question.order', ['id' => $child->id]) }}" title="sắp xếp {{ $child->name }}" class=""><i class="fa fa-arrows"></i>Sắp xếp</a>
                                                                                <a href="{{ route('lesson.detail', ['id' => $child->id]) }}" title="Sửa {{ $child->name }}" class=""><i class="fa fa-pencil"></i>Sửa</a>
                                                                                <a href="#" data-id="{{ $child->id }}" title="Xóa {{ $child->name }}" class="confirmButton"><i class="fa fa-trash-o"></i>Xóa</a>
                                                                            </div>

                                                                        </li>
                                                                    @endforeach
                                                                </ol>
                                                            @endif                                                        
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2 submit_box" style="display: none">
                                                    <input type="submit" class="btn-primary btn btn-save-menu" value="Save">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@stop
@push('css')
    <link href="{{asset('public/admintrator/assets/plugins/form-nestable/jquery.nestable.css')}}" type="text/css" rel="stylesheet">
@endpush
@push('js')
    <script src="{{ asset('public/js/jquery.nestable.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            $('#nestable_list_2').nestable({
                group: 1,
                maxDepth : 2,
                reject: [{
                    rule: function () {                        
                        var ils = $(this).find('>ol.dd-list > li.dd-item');
                        
                        for (var i = 0; i < ils.length; i++) {
                            var datatype = $(ils[i]).data('type');
                            
                            if (datatype === 'child')
                                return true;
                        }
                        return false;
                    },
                    action: function (nestable) {                       
                        swal({
                            title: 'Thông báo',
                            text: 'Không thể di chuyển bài tập',
                            timer: 2000,
                            type: 'error',
                        })
                    }
                }]
            }).on('change', updateOutput);

            // output initial serialised data
            updateOutput($('#nestable_list_2').data('output', $('#nestable_list_2 input[name="lesson"]')));

            function updateOutput(e) {
                $('.submit_box').show();
                var list = e.length ? e : $(e.target),
                    output = list.data('output');
                if (window.JSON) {
                    output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
                }
            }

            $('body').on('click', '.btn-save-menu', function (e) { console.log("xxx");
                var $this = $(this);
                var order = $('#nestable_list_2 input[name="lesson"]').val();
                if(order === '')
                {
                    return false;
                }
                $.ajax({
                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
                    type: "POST",
                    url: '{{ route('lesson.order.save') }}',
                    data: {
                        order: order
                    },
                    success: function (data) {
                        swal({
                            title: 'Thông báo',
                            text: data.msg,
                            timer: 2000,
                            type: 'success',
                        })
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            });

            $('body').on('click', '.confirmButton', function (e) { console.log("xxx");
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
                            url: '{{ route('lesson.delete.post') }}',
                            data: {
                                id: $this.attr('data-id')
                            },
                            success: function (data) {
                                if(data.error == false){
                                    $this.closest('.dd-item').remove();
                                    swal({
                                        title: 'Thông báo',
                                        text: data.msg,
                                        timer: 2000,
                                        type: 'success',
                                    })
                                }else{ 
                                    swal({
                                        title: 'Thông báo',
                                        text: data.msg,
                                        timer: 2000,
                                        type: 'error',
                                    })
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