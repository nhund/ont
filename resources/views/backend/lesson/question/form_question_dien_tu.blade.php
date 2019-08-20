@if(isset($edit) && $edit)
  <div class="form-group row">
    <div class="col-sm-12">Giải thích chung</div>
    <div class="col-sm-12">
      <div class="box_content_t">
        <textarea name="interpret_dt_global" class="col-sm-12">{{ $question->interpret_all }}</textarea>	
        <div class="box_media">                            
                @include('backend.lesson.question.options.action',['show_format_content'=>true])
              </div>
      </div>
    </div>
  </div>
    @foreach($question->childs as $key => $question_child)
      <div class="form-group row box_question_dien_tu box_question box_question_d @if(isset($data['feedback_question']) && $data['feedback_question'] == $question_child->id ) border_feedback @endif">
        <div class="delete_question" title="Xóa câu hỏi" data-id="{{ $question_child->id }}">
          <i class="fa fa-remove" style="font-size:24px;color:red"></i>
        </div>
        <div class="col-sm-6">Câu hỏi</div>
        <div class="col-sm-6">Câu trả lời</div>                                
        <div class="col-sm-6">
          <div class="box_text">
            <div class="box_content_t">
              <textarea name="question[{{ $question_child->id }}]" class="col-sm-12 form-control" placeholder="Câu hỏi">{{ $question_child->question }}</textarea>
              <div class="box_media">  
                <div class="box_audio @if(!empty($question_child->audio_question)) show @endif">
                  <div class="mediPlayer">
                    <audio class="listen" preload="none" data-size="50" src="{{ web_asset($question_child->audio_question) }}"></audio>
                  </div>
                  <p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
                  <input type="hidden" name="audio_question[{{ $question_child->id }}]" class="input_audio" value="{{ $question_child->audio_question }}">
                </div>
                <div class="box_image @if(!empty($question_child->img_before)) show @endif">
                  <img  src="{{ web_asset($question_child->img_before) }}" name="" >
                  <input class="input_image" type="hidden" name="image_question[{{ $question_child->id }}]" value="{{ $question_child->img_before }}">  
                  <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
                </div>                  
                @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true,'show_image'=>true])
              </div>
            </div>
          </div>    
          <div class="box_text box_explain">
            <div class="box_content_t">    
              <textarea name="interpret[{{ $question_child->id }}]" class="col-sm-12 form-control explain" placeholder="Giải thích câu hỏi">{{ $question_child->interpret }}</textarea>
              <div class="box_media">                
                @include('backend.lesson.question.options.action',['show_format_content'=>true])          
              </div>
            </div>
          </div>              
        </div>    
        <div class="col-sm-6 box_answer answer_{{ $question_child->id }}">
          <div class="box_text">
            <div class="box_content_t">
              <textarea name="answer[{{ $question_child->id }}]" class="col-sm-12 form-control" placeholder="Câu trả lời">{{ $question_child->answers->answer }}</textarea>
              <div class="box_media">
                <div class="box_video">

                </div>              
                <div class="box_image @if(!empty($question_child->answers->image)) show @endif">
                  <img  src="{{ web_asset($question_child->answers->image) }}" name="" >
                  <input class="input_image" type="hidden" name="answer_dt_img[{{ $question_child->id }}]" value="{{ $question_child->answers->image }}">  
                  <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
                </div>
                @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_image'=>true,'show_explain'=>true])
              </div>
            </div>            
          </div>
          <div class="box_text box_explain">
            <div class="box_content_t">  
                <textarea name="explain[{{ $question_child->id }}]" style="display: {{ !empty($question_child->explain_before) ? 'block' :'none' }}" class="col-sm-12 form-control explain" placeholder="Gợi ý">{{ $question_child->explain_before }}</textarea>
                <div class="box_media">                
                  @include('backend.lesson.question.options.action',['show_format_content'=>true])          
                </div>
            </div>
          </div>              
        </div>
      </div>
    @endforeach

    <div class="form-group row">
      <div class="col-sm-12">
        <button type="button" class="btn btn-primary add_question" data-count="100000">Thêm câu hỏi</button>
      </div> 
    </div>
@else
<div class="form-group row">
	<div class="col-sm-12">Giải thích chung</div>
	<div class="col-sm-12">
		<div class="box_content_t">
			<textarea name="interpret_dt_global" class="col-sm-12"></textarea>	
			<div class="box_media">                            
            	@include('backend.lesson.question.options.action',['show_format_content'=>true])
          	</div>
		</div>
	</div>
</div>
  @include('backend.lesson.question.dien_tu.box_dien_tu')

<div class="form-group row">
  <div class="col-sm-12">
    <button type="button" class="btn btn-primary add_question" data-count="{{ $count }}">Thêm câu hỏi</button>
  </div> 
</div>
@endif
