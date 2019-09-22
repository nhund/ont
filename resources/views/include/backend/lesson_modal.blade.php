@if (isset($lesson))
    <div class="modal fade" id="delLesson" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-bold">Bạn có chắc chắn muốn xóa ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="window.location.href = '{{ route('lesson.delete', ['id' => $lesson['id']]) }}'">Xóa</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>

    @if ($lesson['is_exercise'])
        <div class="modal fade" id="editCourse" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h1 class="modal-title">Sửa {{ $lesson['name'] }}</h1>
                    </div>
                    <form id="editcourseEx" method="POST" action="{{ route('lesson.handleEx') }}" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="cur_lesson_id" value="{{ $lesson['id'] }}">
                            <input type="hidden" name="type" value="{{ $lesson['type'] }}">
                            <input type="hidden" name="course_id" value="{{ $course['id'] }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-8">Tên bài tập</div>
                                <div class="col-sm-4">Trạng thái</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="#Tên bài tập" name="exName" value="{{ $lesson['name'] }}">
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control" name="status">
                                        <option value="1" @if($lesson['status'] == 1) selected @endif>Public</option>
                                        <option value="2" @if($lesson['status'] == 2) selected @endif>Private</option>
                                        <option value="3" @if($lesson['status'] == 3) selected @endif>Deleted</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">Mô tả ngắn</div>
                                <div class="col-sm-4">Avatar</div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="sapo">{{ $lesson['sapo'] }}</textarea>
                                </div>
                                <div class="col-sm-4">
                                    @if (isset($lesson['avatar']))
                                        <div class="fileinput fileinput-exists" style="width: 100%;" data-provides="fileinput">
                                            <input type="hidden" value="" name="">
                                            <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 50%; height: 55px;"><img src="{{ asset('/public/images/lesson/'.$lesson['avatar'])}}"></div>
                                            <div>
                                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Xóa</a>
                                                <span class="btn btn-default btn-file"><span class="fileinput-new">Chọn ảnh</span>
                                                    <span class="fileinput-exists">Thay đổi</span>
                                                    <input type="file" name="avatar" id="avatar"></span>
                                            </div>
                                        </div>
                                    @else
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
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                {{-- <div class="col-sm-8">Số câu làm bài 1 lần</div> --}}
                                <div class="col-sm-4">Đáp án trác nghiệm</div>
                            </div>
                            <div class="form-group row">
                                {{-- <div class="col-sm-8">
                                    <input type="number" class="form-control" placeholder="#Số câu hỏi 1 lần làm bài" name="repeat_time" value="{{ $lesson['repeat_time'] }}">
                                </div> --}}
                                <div class="col-sm-4">
                                    <select class="form-control" name="random_question">
                                        <option value="{{ \App\Models\Lesson::TRAC_NGHIEM_ANSWER_NOT_RANDOM }}" @if($lesson['random_question'] == \App\Models\Lesson::TRAC_NGHIEM_ANSWER_NOT_RANDOM) selected @endif>Theo thứ tự</option>
                                        <option value="{{ \App\Models\Lesson::TRAC_NGHIEM_ANSWER_RANDOM }}" @if($lesson['random_question'] == \App\Models\Lesson::TRAC_NGHIEM_ANSWER_RANDOM) selected @endif>Đảo ngẫu nhiên</option>                                        
                                    </select>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-sm-12">Mô tả</div>
                            </div>
                            <div class="row">
                                <textarea class="ckeditor" name="exDescription">{{ $lesson['description'] }}</textarea>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="ValidExForm('editcourseEx')">Lưu</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif