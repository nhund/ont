@if(isset($edit) && $edit)
  <div class="form-group div_question_tn row box_question_d">
    <div class="col-sm-6">Câu hỏi</div>
    <div class="col-sm-6">Câu trả lời</div>
    <div class="col-sm-6">
      <div class="box_question">
        <div class="box_content_t">
          <textarea name="question_tnd" class="col-sm-12 form-control" placeholder="Câu hỏi">{{ $question->question }}</textarea>
          <div class="box_media">
            <div class="box_video">
            </div>
            <div class="box_audio @if(!empty($question->audio_question)) show @endif">
              <div class="mediPlayer">
                <audio class="listen" preload="none" data-size="50" src="{{ !empty($question->audio_question) ?web_asset($question->audio_question) : '' }}"></audio>
              </div>
              <p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
              <input type="hidden" name="audio_question_tnd" class="input_audio" value="{{ $question->audio_question }}">
            </div>
            <div class="box_image @if(!empty($question->img_before)) show @endif">
              <img  src="{{ asset($question->img_before) }}" name="" >
              <input class="input_image" type="hidden" name="question_img" value="{{ $question->img_before}}">
              <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
            </div>
            @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true,'show_image'=>true])
          </div>
        </div>
      </div>
    </div>
    @include('backend.lesson.question.trac_nghiem_don.trac_nghiem_answer',['count'=>$question->id,'edit'=>$edit])
  </div>
@else 
  {{-- thêm mới --}}
  <div class="form-group div_question_tn row box_question_d">
    <div class="delete_question" title="Xóa câu hỏi" data-id="">
        <i class="fa fa-remove" style="font-size:24px;color:red"></i>
      </div>
    <div class="col-sm-6">Câu hỏi</div>
    <div class="col-sm-6">Câu trả lời</div>                                
    <div class="col-sm-6">
      <div class="box_question">
        <div class="box_content_t">
          <textarea name="question_tnd" class="col-sm-12 form-control" placeholder="Câu hỏi"></textarea>
          <div class="box_media">
            <div class="box_video">
            </div>
            <div class="box_audio">
              <div class="mediPlayer">
                <audio class="listen" preload="none" data-size="50" src=""></audio>
              </div>
              <p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
              <input type="hidden" name="audio_question_tnd" class="input_audio">
            </div>            
            <div class="box_image">
              <img  src="" name="" >
              <input class="input_image" type="hidden" name="question_img[{{ $count }}]" value="">
              <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
            </div>
            @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true,'show_image'=>true])
          </div>   
        </div>
      </div>
    </div>
    @include('backend.lesson.question.trac_nghiem_don.trac_nghiem_answer',['count'=>$count])
  </div>
@endif
