
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-header text-center">
			
			<h2 class="modal-title">Cập nhật câu hỏi</h2>
		</div>
		<form class="addQuestion" method="POST" action="{{ route('admin.question.editSave') }}">			
			<div class="modal-body pad10">
				<input type="hidden" name="id" value="{{ $question->id }}">
				<input type="hidden" name="lesson_id" id="lesson_id" value="{{ $question->lesson_id }}">
				<input type="hidden" name="course_id" id="course_id" value="{{ $question->course_id }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				@if(isset($data['feedback_id']))
					<input type="hidden" name="feedback_id" value="{{ $data['feedback_id'] }}">
				@endif
				<div class="form-group row" style="margin: 5px;">                        
					<div class="col-sm-12 row form-group">						
						<div class="delete_question" title="Xóa câu hỏi" data-id="{{ $question->id }}" data-type="">
							<i class="fa fa-remove" style="font-size:24px;color:red"></i>
						</div>
						<div class="form-group row">
							<div class="col-sm-12">Loại câu hỏi</div>
							<div class="col-sm-3">
								<select class="form-control" name="type">
									<option disabled @if($question->type == \App\Models\Question::TYPE_FLASH_SINGLE) selected @endif value="{{ \App\Models\Question::TYPE_FLASH_SINGLE }}">FlashCard Đơn</option>
									<option disabled @if($question->type == \App\Models\Question::TYPE_FLASH_MUTI) selected @endif value="{{ \App\Models\Question::TYPE_FLASH_MUTI }}">FlashCard chuỗi</option>
									<option disabled @if($question->type == \App\Models\Question::TYPE_DIEN_TU) selected @endif value="{{ \App\Models\Question::TYPE_DIEN_TU }}">Điền từ</option>
									<option disabled @if($question->type == \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN) selected @endif value="{{ \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN }}">Điền từ đoạn văn</option>
									<option disabled @if($question->type == \App\Models\Question::TYPE_TRAC_NGHIEM) selected @endif value="{{ \App\Models\Question::TYPE_TRAC_NGHIEM }}">Trác nghiệm</option>
									<option disabled @if($question->type == \App\Models\Question::TYPE_TRAC_NGHIEM_DON) selected @endif value="{{ \App\Models\Question::TYPE_TRAC_NGHIEM_DON }}">Trác nghiệm đơn</option>
								</select>
							</div>
						</div>
						@if($question->type !== \App\Models\Question::TYPE_TRAC_NGHIEM_DON)
						<div class="form-group row">
							<div class="col-sm-12">Đoạn văn</div>
							<div class="col-sm-12">
								<div class="box_content box_content_t">
									<textarea name="content" class="col-sm-12">{{ $question->content }}</textarea>
									<div class="box_media">
										<div class="box_video">

										</div>
										<div class="box_audio @if(!empty($question->audio_question)) show @endif">
											<div class="mediPlayer">
												<audio class="listen" preload="none" data-size="60" src="{{ web_asset($question->audio_question) }}"></audio>
											</div>
											<p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
											<input type="hidden" name="audio_content" class="input_audio" value={{ $question->audio_question }}>
										</div>
										@if($question->type !== \App\Models\Question::TYPE_FLASH_SINGLE)
											<div class="box_image @if(!empty($question->img_before)) show @endif">
												<img  src="{{ web_asset($question->img_before) }}">
												<input class="input_image" type="hidden" name="image" value="{{ $question->img_before }}">
												<p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
											</div>
											@include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true,'show_image'=>true])
										@else
											{{-- <div class="box_image @if(!empty($question->img_before)) show @endif">
												<img  src="{{ web_asset($question->img_before) }}">
												<input class="input_image" type="hidden" name="image" value="{{ $question->img_before }}">
												<p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
											</div> --}}
											@include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
										@endif

									</div>
								</div>

							</div>
						</div>
						@endif
                            <!-- <div class="form-group row">
                                <div class="col-sm-12">Gợi ý</div>
                                <div class="col-sm-12">
                                    <textarea name="explain[1]" class="col-sm-12"></textarea>
                                </div>
                            </div> -->
                            @if($question->type == \App\Models\Question::TYPE_FLASH_SINGLE)
	                            <div class="form_question form_flash_card" style="display: block">
	                            	@include('backend.lesson.question.form_question_flash_card_don',['edit'=>true])
	                            </div>
	                            @endif
                            @if($question->type == \App\Models\Question::TYPE_FLASH_MUTI)
	                            <div class="form_question form_flash_card_chuoi">
	                            	@include('backend.lesson.question.form_question_flash_card_chuoi',['edit'=>true])
	                            </div>
	                            @endif
                            @if($question->type == \App\Models\Question::TYPE_DIEN_TU)
	                            <div class="form_question form_dien_tu">
	                            	@include('backend.lesson.question.form_question_dien_tu',['edit'=>true])
	                            </div>   
	                            @endif
                            @if($question->type == \App\Models\Question::TYPE_TRAC_NGHIEM)
	                            <div class="form_question form_trac_nghiem">
	                            	@include('backend.lesson.question.form_question_trac_nghiem',['edit'=>true])
	                            </div>                          
							@endif
                            @if($question->type == \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN)
	                            <div class="form_question form_dien_tu_doan_van">
	                            	@include('backend.lesson.question.form_question_dien_tu_doan_van',['edit'=>true])
	                            </div>                        
                            @endif
							@if($question->type == \App\Models\Question::TYPE_TRAC_NGHIEM_DON)
								<div class="form_question form_trac_nghiem">
									@include('backend.lesson.question.form_question_trac_nghiem_don',['edit'=>true])
								</div>
							@endif

                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="clear: both;text-align: center;">
                	<button type="submit" class="btn btn-primary">Lưu</button>
                	<a href="{{ route('lesson.detail',['id'=>$question->lesson_id]) }}" class="btn btn-danger">Hủy</a>
                	
                </div>
            </form>
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
