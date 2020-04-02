@extends('backend.layout')
@section('title', $page_title)
@push('js')
    {{-- <script src="{{ asset('/public/admintrator/assets/plugins/form-ckeditor/ckeditor.js') }}"></script> --}}
    <script src="{{ asset('/public/plugin/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/js/bootstrap-notify.min.js?ver=1') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.price').keyup(function () {
                $(this).val(number_format($(this).val()));
            });
            $('.discount').keyup(function () {
                $(this).val(number_format($(this).val()));
            });
            $('#course-submit').click(function () {
                CKEDITOR.instances.description.updateElement();
                var name        = $.trim($('input[name="name"]').val());
                var description = $.trim($('textarea[name="description"]').val());
                var file        = $('#avatar').val().toLowerCase();
                var course_status = $('#addCourse select[name="status"]').val();
                var course_time = $('#addCourse input[name="study_time"]').val();
                //validate
                if(parseInt(course_status) == 3 || parseInt(course_status) == 4 || parseInt(course_status) == 1)
                {
                    if(parseInt(course_time) == 0 || course_time == '')
                    {
                        showErrorMsg('Vui lòng nhập số ngày học');
                        return false;   
                    }
                }
                if (name == '') {
                    showErrorMsg('Vui lòng nhập tên');
                    return false;
                }
                if (description == '') {
                    showErrorMsg('Vui lòng nhập mô tả');
                    return false
                }

                if (file) {
                    var extension = file.substring(file.lastIndexOf('.') + 1);
                    var size     = $("#avatar")[0].files[0].size;
                    if ($.inArray(extension, ['jpg', 'png', 'jpeg']) == -1 || size > 1048576) {
                        showErrorMsg('File phải có định dạng jpg, jpeg, png và dung lượng dưới 1MB');
                        return false;
                    }
                }

                $('form#addCourse').submit();
            });
        });
    </script>
@endpush
@push('css')
    <link href="{{asset('/public/admintrator/assets/css/animate.min.css')}}" type="text/css" rel="stylesheet">
@endpush
@section('content')
    @include('include.backend.breadcrumb')
    <div id="panel-advancedoptions">
        <div class="panel panel-default" data-widget-editbutton="false" id="p1" role="widget">
            <div class="panel-heading" role="heading">
                <h2>@if(isset($course)) Sửa khóa học @else Tạo khóa học @endif</h2>
                @if(isset($course))
                    <a href="{{ route('course.detail',['id'=>$course['id']]) }}">(Xem chi tiết bài tập)</a>
                @endif
                <span class="panel-loader"></span></div>
            <div class="panel-body" role="content">
                <form id="addCourse" method="POST" action="{{ route('course.handle') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if (isset($course['id']))
                        <input type="hidden" value="{{ $course['id'] }}" name="id">
                    @endif
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-6">Tên <i class="fa fa-asterisk" style="color:red; font-size: 0.6em;" aria-hidden="true"></i></label>
                            <label class="col-sm-3">Danh mục</label>
                            <label class="col-sm-3">Status</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="name" placeholder="Tên khóa học" value="{{ $course['name'] ?? '' }}">
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control" name="category_id">
                                    <option value="0">Danh mục</option>
                                    @foreach($category as $val)
                                        <option value="{{ $val['id'] }}" @if(isset($course['category_id']) && $course['category_id']  == $val['id']) selected="selected" @endif>{{ $val['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">                                
                                <select class="form-control" name="status">
                                    <option value="{{ \App\Models\Course::TYPE_PUBLIC }}" @if(isset($course['status']) && $course['status'] == \App\Models\Course::TYPE_PUBLIC) selected="selected" @endif>Công khai</option>
                                    <option value="{{ \App\Models\Course::TYPE_FREE_TIME }}" @if(isset($course['status']) && $course['status'] == \App\Models\Course::TYPE_FREE_TIME) selected="selected" @endif>Miễn phí có thời hạn</option>
                                    <option value="{{ \App\Models\Course::TYPE_FREE_NOT_TIME }}" @if(isset($course['status']) && $course['status'] == \App\Models\Course::TYPE_FREE_NOT_TIME) selected="selected" @endif>Miễn phí không thời hạn</option>
                                    <option value="{{ \App\Models\Course::TYPE_APPROVAL }}" @if(isset($course['status']) && $course['status'] == \App\Models\Course::TYPE_APPROVAL) selected="selected" @endif>Cần xét duyệt</option>
                                    <option value="{{ \App\Models\Course::TYPE_PRIVATE }}" @if(isset($course['status']) && $course['status'] == \App\Models\Course::TYPE_PRIVATE) selected="selected" @endif>Riêng tư</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-sm-6">Mô tả <i class="fa fa-asterisk" style="color:red; font-size: 0.6em;" aria-hidden="true"></i></label>
                            <label class="col-sm-3">Giá gốc </label>
                            <label class="col-sm-3">Giảm giá</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <textarea name="description" cols="80" rows="20" class="ckeditor">{{ $course['description'] ?? '' }}</textarea>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control price" name="price" placeholder="Giá"
                                        @if(isset($course['price'])) value="{{ number_format($course['price'],0,',','.') }}" @endif>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control discount" name="discount" placeholder="Giảm giá"
                                        @if(isset($course['discount'])) value="{{number_format($course['discount'],0,',','.')}}"  @endif>
                                    </div>
                                </div>
                                <div class="row top10">
                                    {{-- <label class="col-sm-6">Free => Có giá</label> --}}
                                    <label class="col-sm-6">Thời gian học (Ngày)</label>
                                </div>
                                <div class="row">
                                    {{-- <div class="col-sm-6">
                                        <select class="form-control" name="is_free">
                                            <option value="1" @if(isset($course['is_free']) && $course['is_free'] == 1) selected="selected" @endif>Không cần mua</option>
                                            <option value="0" @if(!isset($course['is_free']) || !$course['is_free']) selected="selected" @endif>Phải mua lại</option>
                                        </select>
                                    </div> --}}
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control" name="study_time" @if(isset($course['study_time'])) value="{{ $course['study_time'] }}" @endif>
                                    </div>
                                </div>
                                <div class="row top10">
                                    <label class="col-sm-12">Avatar</label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        @if (isset($course['avatar']))
                                            <div class="fileinput fileinput-exists" style="width: 100%;" data-provides="fileinput">
                                                <input type="hidden" value="" name="">
                                                <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 150px; line-height: 150px;"><img src="{{ asset('/public/images/course/'.$course['avatar'])}}"></div>
                                                <div>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Xóa</a>
                                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Chọn ảnh</span>
                                                    <span class="fileinput-exists">Thay đổi</span>
                                                    <input type="file" name="avatar" id="avatar"></span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 150px;"></div>
                                                <div>
                                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Xoá</a>
                                                    <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Chọn ảnh</span>
                                                        <span class="fileinput-exists">Thay đổi</span>
                                                        <input type="file" name="avatar" id="avatar">
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button class="btn-primary btn" id="course-submit" type="submit">Lưu</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection