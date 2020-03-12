<div class="addQuestionModal" id="addQuestionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header text-center">                
                <h2 class="modal-title">Tạo câu hỏi</h2>
            </div>
            
            <form class="addQuestion add_question" method="POST" action="{{ route('exercise.handle') }}">
                <div class="modal-body pad10">
                    <input type="hidden" name="lesson_id" id="lesson_id" value="{{ $lesson['id'] }}">
                    <input type="hidden" name="type_lesson" id="type_lesson" value="{{ $lesson['type'] }}">
                    <input type="hidden" name="course_id" id="course_id" value="{{ $lesson['course_id'] }}">
                    <input type="hidden" name="part_id" value="{{ $part->id ?? '' }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group row" style="margin: 5px;">
                        <div class="col-sm-12 row form-group">

                            <div class="form-group row">
                                <div class="col-sm-12">Loại câu hỏi</div>
                                <div class="col-sm-3">
                                    <select class="form-control" name="type" id="type-question">
                                        <option value="{{ \App\Models\Question::TYPE_FLASH_SINGLE }}">FlashCard Đơn</option>
                                        <option value="{{ \App\Models\Question::TYPE_FLASH_MUTI }}">FlashCard chuỗi</option>
                                        <option value="{{ \App\Models\Question::TYPE_DIEN_TU }}">Điền từ</option>
                                        <option value="{{ \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN }}">Điền từ đoạn văn</option>
                                        <option value="{{ \App\Models\Question::TYPE_TRAC_NGHIEM }}">Trác nghiệm</option>
                                        <option value="{{ \App\Models\Question::TYPE_TRAC_NGHIEM_DON }}">Trác nghiệm đơn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row doan-van">
                                <div class="col-sm-12">Đoạn văn</div>
                                <div class="col-sm-12">
                                    <div class="box_content box_content_t">
                                        <textarea rows="4" name="content" class="col-sm-12 conten_textarea"></textarea>
                                        <div class="box_media">
                                            <div class="box_video">

                                            </div>
                                            <div class="box_audio">
                                                <div class="mediPlayer">
                                                    <audio class="listen" preload="none" data-size="50" src=""></audio>
                                                </div>
                                                <p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
                                                <input type="hidden" name="audio_content" class="input_audio">
                                            </div>
                                            <div class="box_image">
                                                <img  src="" name="" >
                                                <input class="input_image" type="hidden" name="image" value="">
                                                <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
                                            </div>
                                            @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true,'show_image'=>true])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <div class="col-sm-12">Gợi ý</div>
                                <div class="col-sm-12">
                                    <textarea name="explain[1]" class="col-sm-12"></textarea>
                                </div>
                            </div> -->
                            <div class="form_question form_flash_card" style="display: block">
                                @include('backend.lesson.question.form_question_flash_card_don')
                            </div>
                            <div class="form_question form_flash_card_chuoi">
                                @include('backend.lesson.question.form_question_flash_card_chuoi')
                            </div>
                            <div class="form_question form_dien_tu">
                                @include('backend.lesson.question.form_question_dien_tu',['count'=>1])
                            </div>   
                            <div class="form_question form_trac_nghiem">
                                @include('backend.lesson.question.form_question_trac_nghiem')
                            </div>
                            <div class="form_question form_trac_nghiem_don">
                                @include('backend.lesson.question.form_question_trac_nghiem_don')
                            </div>
                            <div class="form_question form_dien_tu_doan_van">
                                @include('backend.lesson.question.form_question_dien_tu_doan_van')
                            </div>                          
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="clear: both;text-align: center;">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-danger btn_cancel_add_question">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('js')
@include('backend.lesson.question.options.js')
<script>
    $(document).ready(function () {
      $('.mediPlayer').mediaPlayer();
  });
</script>
@endpush
