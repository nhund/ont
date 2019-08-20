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