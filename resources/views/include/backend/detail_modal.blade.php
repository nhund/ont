
<div class="modal fade" id="courseLesson" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Tạo bài giảng</h2>
            </div>
            <form id="addCourseLesson" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="course_id" value="{{ $course['id'] }}">
                    <input type="hidden" name="lesson_id" id="lesson_id" value="">
                    <input type="hidden" name="level" id="level" value="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <p class="title-courseLesson"></p>
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <input type="text" class="form-control lessonName" placeholder="#Lesson name" name="name[]">
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" name="status[]">
                                <option value="1">Public</option>
                                <option value="2">Private</option>
                                <option value="3">Deleted</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <a class="color-red" onclick="deleteRow(this)">Xóa</a>
                        </div>
                    </div>
                    <div class="form-group bot-0">
                        <a onclick="addRowLesson()">Thêm bài học</a>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addLesson()">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="courseLevel2" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Tạo bài giảng cấp 2</h2>
            </div>
            <form id="addCourseLevel2" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="course_id" value="{{ $course['id'] }}">
                    <input type="hidden" name="level" id="level" value="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <p class="title-courseLesson"></p>
                    <div class="form-group row">
                        <div class="col-sm-5">
                            <input id="lessonName" type="text" class="form-control lessonName" placeholder="tên bài tâp cấp 2 ..." name="name">
                        </div>
                        <div class="col-sm-5">
                            <select class="form-control" name="status">
                                <option value="1">Public</option>
                                <option value="2">Private</option>
                                <option value="3">Deleted</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addLevel2()">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="courseEx" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="modal-title">Tạo bài tập</h1>
            </div>
            <form id="addcourseEx" method="POST" action="{{ route('lesson.handleEx') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="lesson_id" id="les_id" value="">
                    <input type="hidden" name="course_id" value="{{ $course['id'] }}">
                    <input type="hidden" name="type"  id="type" value="">
                    <input type="hidden" name="level"  id="level" value="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-sm-8">Tên bài tập</div>
                        <div class="col-sm-4">Trạng thái</div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="#Tên bài tập" name="exName">
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control" name="status">
                                <option value="1">Public</option>
                                <option value="2">Private</option>
                                <option value="3">Deleted</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">Mô tả ngắn</div>
                        <div class="col-sm-4">Avatar</div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <textarea class="form-control" name="sapo"></textarea>
                        </div>
                        <div class="col-sm-4">
                            <div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 55px;"></div>
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Xoá</a>
                                    <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">Chọn ảnh</span>
                                        <span class="fileinput-exists">Đổi</span>
                                        <input type="file" name="avatar" id="avatar">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-sm-8">Số câu làm bài 1 lần</div> --}}
                        <div class="col-sm-4">Đáp án trác nghiệm</div>
                    </div>
                    <div class="form-group row">
                        {{-- <div class="col-sm-8">
                            <input type="number" class="form-control" placeholder="#Số câu hỏi 1 lần làm bài" name="repeat_time" value="10">
                        </div> --}}
                        <div class="col-sm-4">
                            <select class="form-control" name="random_question">
                                <option value="{{ \App\Models\Lesson::TRAC_NGHIEM_ANSWER_NOT_RANDOM }}">Theo thứ tự</option>
                                <option value="{{ \App\Models\Lesson::TRAC_NGHIEM_ANSWER_RANDOM }}">Đảo ngẫu nhiên</option>                                
                            </select>
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-sm-12">Mô tả</div>
                    </div>
                    <div class="row">
                        <textarea class="ckeditor" name="exDescription"></textarea>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="ValidExForm('addcourseEx')">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="courseExam" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="modal-title">Tạo bài tập</h1>
            </div>
            <form id="addcourseExam" method="POST" action="{{ route('lesson.handleEx') }}"
                  enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="lesson_id" id="les_id" value="">
                    <input type="hidden" name="course_id" value="{{ $course['id'] }}">
                    <input type="hidden" name="type" id="type" value="">
                    <input type="hidden" name="level" id="level" value="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-sm-8">Tên bài tập</div>
                        <div class="col-sm-4">Trạng thái</div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder="#Tên bài tập" name="exName">
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control" name="status">
                                <option value="1">Public</option>
                                <option value="2">Private</option>
                                <option value="3">Deleted</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="sapo"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">Mô tả</div>
                    </div>
                    <div class="row">
                        <textarea class="ckeditor" name="exDescription"></textarea>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-12"><label>Bài thi có hiệu lực (*)</label></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-1">Từ
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control date-today" type="text" name="start_time_at">
                        </div>
                        <div class="col-sm-1">Đến
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control date-fromday" type="text" name="end_time_at">
                        </div>
                    </div>
                    <hr/>
                    <div class="row ">
                        <div class="col-sm-3">
                            <label for="minutes">Thời gian làm bài</label>
                        </div>
                        <div class="col-sm-3">
                            <label for="total_score">Lựa chọn Barem điểm</label>
                        </div>
                    </div>

                    <div class="row  form-group">
                        <div class="col-sm-3 ">
                            <input class="form-control" id="minutes" type="number"  name="minutes">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control" id="total_score" type="number" name="total_score">
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-sm-3">
                            <label>Bài thi có mấy phần?</label>
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" type="number" name="parts">
                        </div>
                    </div>
                    <hr/>
                    <div class="row  form-group">
                        <div class="col-sm-3">
                            <label>Bài thi được dừng mấy lần?</label>
                        </div>
                        <div class="col-sm-1 ">
                            <input class="form-control" type="number"  name="stop_time">
                        </div>
                        <div class="col-sm-3">
                            <label>Bài thi được làm lại mấy lần?</label>
                        </div>
                        <div class="col-sm-1 ">
                            <input class="form-control" type="number" name="repeat_time">
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="ValidExForm('addcourseExam')">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

{{-- update score exam--}}
<div class="modal fade" id="update-part-exam" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 class="modal-title"><strong>Cập nhật điểm của phần kiểm tra</strong></h1>
            </div>
            <form id="form-update-part-exam" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="exam_id" id="exam_id" value="{{$lesson->id ?? 0}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="row" style="font-weight: bold">
                        <div class="col-sm-offset-1 col-sm-2">Số lần làm bài</div>
                        <div class="col-sm-2"><input type="number" value="{{$lesson->repeat_time??0}}" name="repeat_time"/></div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-3"></div>
                    </div>
                    <hr/>
                    <div class="row" style="font-weight: bold">
                        <div class="col-sm-offset-1 col-sm-2">Phần</div>
                        <div class="col-sm-3">Điểm</div>
                        <div class="col-sm-2">Phần</div>
                        <div class="col-sm-3">Điểm</div>
                    </div>
                    <hr/>
                    <div class="form-group row">
                        <div class="col-sm-offset-1 col-sm-2">phần 1</div>
                        <div class="col-sm-3"><input value="{{$parts->part_1 ?? 0}}" type="number" name="part_1"></div>
                        <div class="col-sm-2">phần 2</div>
                        <div class="col-sm-3"><input value="{{$parts->part_2 ?? 0}}" type="number" name="part_2"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-1 col-sm-2">phần 3</div>
                        <div class="col-sm-3"><input value="{{$parts->part_3 ?? 0}}" type="number" name="part_3"></div>
                        <div class="col-sm-2">phần 4</div>
                        <div class="col-sm-3"><input value="{{$parts->part_4 ?? 0}}" type="number" name="part_4"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-1 col-sm-2">phần 5</div>
                        <div class="col-sm-3"><input value="{{$parts->part_5 ?? 0}}" type="number" name="part_5"></div>
                        <div class="col-sm-2">phần 6</div>
                        <div class="col-sm-3"><input value="{{$parts->part_6 ?? 0}}" type="number" name="part_6"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-1 col-sm-2">phần 7</div>
                        <div class="col-sm-3"><input value="{{$parts->part_7 ?? 0}}" type="number" name="part_7"></div>
                        <div class="col-sm-2">phần 8</div>
                        <div class="col-sm-3"><input value="{{$parts->part_8 ?? 0}}" type="number" name="part_8"></div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-offset-1 col-sm-2">phần 9</div>
                        <div class="col-sm-3"><input value="{{$parts->part_9 ?? 0}}" type="number" name="part_9"></div>
                        <div class="col-sm-2">phần 10</div>
                        <div class="col-sm-3"><input value="{{$parts->part_10 ?? 0}}" type="number" name="part_10"></div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="updatePartExam()">Lưu</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ web_asset('public/admintrator/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".date-today").datetimepicker({
                format: 'dd-mm-yyyy h:i'
             });

            $(".date-fromday").datetimepicker({
                useCurrent: false, format: 'dd-mm-yyyy h:i'
            });

            $(".date-today").on("dp.change", function (e) {
                $('.date-fromday').data("DateTimePicker").minDate(e.date);
            });
        });
    </script>
@endpush