<div class="form-group row box_question_dien_tu box_question box_question_d">
  <div class="delete_question" title="Xóa câu hỏi" data-id="" data-type="{{ \App\Models\Question::TYPE_DIEN_TU }}">
    <i class="fa fa-remove" style="font-size:24px;color:red"></i>
  </div>
  <div class="col-sm-6">Câu hỏi</div>
  <div class="col-sm-6">Câu trả lời</div>                                
  <div class="col-sm-6">
    <div class="box_text">
      <div class="box_content_t">
        <textarea name="question[{{ $count }}]" class="col-sm-12 form-control" placeholder="Câu hỏi"></textarea>
        <div class="box_media">  
          <div class="box_audio">
            <div class="mediPlayer">
              <audio class="listen" preload="none" data-size="50" src=""></audio>
            </div>
            <input type="hidden" name="audio_question[{{ $count }}]" class="input_audio">
            <p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
          </div>
          <div class="box_image">
            <img  src="" name="" >
            <input class="input_image" type="hidden" name="image_question[{{ $count }}]" value="">  
            <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
          </div>                  
          @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true,'show_image'=>true])
        </div>      
      </div>
    </div>
    <div class="box_text box_explain">
      <div class="box_content_t">    
        <textarea name="interpret[{{ $count }}]" class="col-sm-12 form-control explain" placeholder="Giải thích câu hỏi"></textarea>
        <div class="box_media">                
          @include('backend.lesson.question.options.action',['show_format_content'=>true])          
        </div>
      </div>
    </div>
  </div>    
  <div class="col-sm-6 box_answer answer_{{ $count }}">
    <div class="box_text">
      <div class="box_content_t">
        <textarea name="answer[{{ $count }}]" class="col-sm-12 form-control" placeholder="Câu trả lời"></textarea>
        <div class="box_media">
          <div class="box_video">

          </div>
          {{-- <div class="box_audio">
            <div class="mediPlayer">
              <audio class="listen" preload="none" data-size="50" src=""></audio>
            </div>
            <input type="hidden" name="audio_answer[{{ $count }}]" class="input_audio">
          </div> --}}
          <div class="box_image">
            <img  src="" name="" >
            <input class="input_image" type="hidden" name="answer_dt_img[{{ $count }}]" value="">  
            <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
          </div>          
          @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_image'=>true,'show_explain'=>true])
          
        </div>
      </div>
    </div>
    <div class="box_text box_explain">
      <div class="box_content_t">    
        <textarea name="explain[{{ $count }}]" class="col-sm-12 form-control explain" placeholder="Gợi ý"></textarea>
        <div class="box_media">                
          @include('backend.lesson.question.options.action',['show_format_content'=>true])          
        </div>
      </div>
    </div>
  </div>
</div>