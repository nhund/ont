@if(isset($edit) && $edit)
  @if($templateType != 'error')
    <div class="box_text answer_box">
      <div class="box_content_t">
        <textarea name="answer_tn[{{ $count }}]" class="col-sm-12 form-control" placeholder="Câu trả lời đúng">{{ isset($question_child->answer_ok->answer) ? $question_child->answer_ok->answer : '' }}</textarea>
        <div class="box_media">
          <div class="box_video">

          </div>          
          <div class="box_image @if(isset($question_child->answer_ok->image) && !empty($question_child->answer_ok->image)) show @endif">
            <img  src="{{ isset($question_child->answer_ok->image) ? asset($question_child->answer_ok->image) : ''  }}" name="" >
            <input class="input_image" type="hidden" name="answer_img[{{ $count }}]" value="{{ isset($question_child->answer_ok->image) ? $question_child->answer_ok->image : '' }}">  
            <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
          </div>
          @include('backend.lesson.question.options.action',['show_format_content'=>true,'add_answer_error'=>true,'add_answer_error_count'=>$count,'show_image'=>true])          
        </div>  
      </div>        
    </div>  
  @else
    <div class="box_text answer_box_error" data-child="{{ $count_child }}">
      <div class="box_content_t">
        <textarea name="answer_error_tn[{{ $count }}][{{ $count_child }}]" class="col-sm-12 form-control" placeholder="Câu trả lời sai">{{ $question_error->answer }}</textarea>
        <div class="box_media">
          <div class="box_video">

          </div>
          <div class="box_image @if(!empty($question_error->image)) show @endif">
            <img  src="{{ asset($question_error->image)  }}" name="" >
            <input class="input_image" type="hidden" name="answer_img_error[{{ $count }}][{{ $count_child }}]" value="{{$question_error->image }}">  
            <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
          </div>
          @include('backend.lesson.question.options.action',['show_format_content'=>true,'add_answer_error'=>true,'add_answer_error_count'=>$count,'show_image'=>true,'delete_anwser'=>true])          
        </div>  
      </div>        
    </div> 
  @endif 

@else 
  {{-- Thêm mới --}}
  @if($templateType != 'error')
    <div class="box_text answer_box">
      <div class="box_content_t">
        <textarea name="answer_tn[{{ $count }}]" class="col-sm-12 form-control" placeholder="Câu trả lời đúng"></textarea>
        <div class="box_media">
          <div class="box_video">

          </div>
          {{-- <div class="box_audio">
            <div class="mediPlayer">
              <audio class="listen" preload="none" data-size="60" src=""></audio>
            </div>
            <input type="hidden" name="audio_answer_tn[{{ $count }}]" class="input_audio">
          </div> --}}          
          <div class="box_image">
            <img  src="" name="" >
            <input class="input_image" type="hidden" name="answer_img[{{ $count }}]" value="">  
            <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
          </div>
          @include('backend.lesson.question.options.action',['show_format_content'=>true,'add_answer_error'=>true,'add_answer_error_count'=>$count,'show_image'=>true])
          
        </div>  
      </div>        
    </div>  
  @else
    <div class="box_text answer_box_error" data-child="{{ $count_child }}">
      <div class="box_content_t">
        <textarea name="answer_error_tn[{{ $count }}][{{ $count_child }}]" class="col-sm-12 form-control" placeholder="Câu trả lời sai"></textarea>
        <div class="box_media">
          <div class="box_video">

          </div>
          {{-- <div class="box_audio">
            <div class="mediPlayer">
              <audio class="listen" preload="none" data-size="60" src=""></audio>
            </div>
            <input type="hidden" name="audio_answer_error[{{ $count }}][{{ $count_child }}]" class="input_audio">
          </div> --}}          
          <div class="box_image">
            <img  src="" name="" >
            <input class="input_image" type="hidden" name="answer_img_error[{{ $count }}][{{ $count_child }}]" value="">  
            <p class="delete" title="Xóa ảnh" onclick="deleteImage(this)">Xóa</p>
          </div>
          @include('backend.lesson.question.options.action',['show_format_content'=>true,'add_answer_error'=>true,'add_answer_error_count'=>$count,'show_image'=>true,'delete_anwser'=>true])        
        </div> 
      </div>         
    </div> 
  @endif 
@endif
