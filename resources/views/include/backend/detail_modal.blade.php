
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
                <h1 class="modal-title">Tạo bài kiểm tra</h1>
            </div>
            <form id="addcourseExam" method="POST" action="{{ route('lesson.handleEx') }}"
                  enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="lesson_id" id="les_id" value="">
                    <input type="hidden" data-input="course_id" name="course_id" value="{{ $course['id'] }}">
                    <input type="hidden" name="type" id="type" value="">
                    <input type="hidden" name="level" id="level" value="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-sm-8">Tên bài kiểm tra</div>
                        <div class="col-sm-4">Trạng thái</div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <input type="text" data-input="Tên bài kiểm tra" class="form-control" placeholder="#Tên bài tập" name="exName">
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control" name="status">
                                <option value="1">Public</option>
                                <option value="2">Private</option>
                                <option value="3">Deleted</option>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-12"><label>Bài thi có hiệu lực (*)</label></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <input class="form-control date-today" data-input="từ ngày" type="text"  name="start_time_at" placeholder="từ ngày">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control date-fromday" data-input="Đến ngày" type="text" name="end_time_at" placeholder="Đến ngày">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control" data-input="Tông câu hỏi" type="number" name="total_question" placeholder="Tông câu hỏi">
                        </div>
                    </div>
                    <hr/>
                    <div class="row ">
                        <div class="col-sm-3">
                            <label for="minutes" >Thời gian làm bài (phút)</label>
                        </div>
                        <div class="col-sm-3">
                            <label for="total_score">Lựa chọn Barem điểm</label>
                        </div>
                        <div class="col-sm-3">
                            <label for="min_score">Số điểm tối thiểu?</label>
                        </div>
                    </div>

                    <div class="row  form-group">
                        <div class="col-sm-3 ">
                            <input class="form-control"  data-input="Thời gian làm bài" id="minutes" type="number" min="1"  name="minutes">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control"  data-input="Chọn điểm" id="total_score" type="number" min="1" name="total_score">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control"  data-input="Chọn điểm" id="min_score" type="number" min="1" name="min_score">
                        </div>

                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Bài thi được dừng mấy lần?</label>
                        </div>
                        <div class="col-sm-3">
                            <label>Bài thi được làm lại mấy lần?</label>
                        </div>
                        <div class="col-sm-3">
                            <label for="total_score">Bài thi có mấy phần?</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <input class="form-control" type="number" value="0" min="0" name="stop_time">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control" type="number" value="0" min="0" name="repeat_time">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control"  data-input="Bài thi có mấy phần?" type="number" min="1" name="parts">
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-12">Mô tả</div>
                    </div>
                    <div class="row">
                        <textarea class="ckeditor" name="exDescription"></textarea>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="ValidFormCommon('addcourseExam')">Lưu</button>
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
                <h1 class="modal-title">Tạo bài kiểm tra</h1>
            </div>
            <form id="editCourseExam" method="POST" action="{{ route('lesson.handleEx') }}"
                  enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="cur_lesson_id" id="les_id" value="{{$lesson->id ?? ''}}">
                    <input type="hidden" data-input="course_id" name="course_id" value="{{ $course['id'] }}">
                    <input type="hidden" name="type" id="type" value="exam">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-sm-8">Tên bài kiểm tra</div>
                        <div class="col-sm-4">Trạng thái</div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <input type="text" data-input="Tên bài kiểm tra" value="{{$lesson->name ?? ''}}" class="form-control" placeholder="#Tên bài tập" name="exName">
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control" name="status">
                                <option {{$lesson->status == 1 ? 'selected' : ''}} value="1">Public</option>
                                <option {{$lesson->status == 2 ? 'selected' : ''}} value="2">Private</option>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-12"><label>Bài thi có hiệu lực (*)</label></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <input class="form-control date-today" data-input="từ ngày" value="{{date('d-m-Y h:i', strtotime($lesson->exam->start_time_at  ?? now()))}}" type="text"  name="start_time_at" placeholder="từ ngày">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control date-fromday" value="{{date('d-m-Y h:i', strtotime($lesson->exam->end_time_at  ?? now()))}}" data-input="Đến ngày" type="text" name="end_time_at" placeholder="Đến ngày">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control" data-input="Tông câu hỏi" value="{{$lesson->exam->total_question ?? ''}}" type="number" name="total_question" placeholder="Tông câu hỏi">
                        </div>
                    </div>
                    <hr/>
                    <div class="row ">
                        <div class="col-sm-3">
                            <label for="minutes" >Thời gian làm bài (phút)</label>
                        </div>
                        <div class="col-sm-3">
                            <label for="total_score">Lựa chọn Barem điểm</label>
                        </div>
                        <div class="col-sm-3">
                            <label for="min_score">Số điểm tối thiểu?</label>
                        </div>
                    </div>

                    <div class="row  form-group">
                        <div class="col-sm-3 ">
                            <input class="form-control"  value="{{$lesson->exam->minutes ?? ''}}" data-input="Thời gian làm bài" id="minutes" type="number" min="1"  name="minutes">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control"   value="{{$lesson->exam->total_score ?? ''}}" data-input="Chọn điểm" id="total_score" type="number" min="1" name="total_score">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control"   value="{{$lesson->exam->min_score ?? ''}}" data-input="Chọn điểm" id="min_score" type="number" min="1" name="min_score">
                        </div>

                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Bài thi được dừng mấy lần?</label>
                        </div>
                        <div class="col-sm-3">
                            <label>Bài thi được làm lại mấy lần?</label>
                        </div>
                        <div class="col-sm-3">
                            <label for="total_score">Bài thi có mấy phần?</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <input class="form-control" type="number"   value="{{$lesson->exam->stop_time ?? ''}}"  min="0" name="stop_time">
                        </div>
                        <div class="col-sm-3 ">
                            <input class="form-control" type="number"   value="{{$lesson->exam->repeat_time ?? ''}}"  min="0" name="repeat_time">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control"   value="{{$lesson->exam->parts ?? ''}}"   data-input="Bài thi có mấy phần?" type="number" min="1" name="parts">
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-sm-12">Mô tả</div>
                    </div>
                    <div class="row">
                        <textarea class="ckeditor" name="exDescription">{!! $lesson->description ?? '' !!}</textarea>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="ValidFormCommon('editCourseExam')">Lưu</button>
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