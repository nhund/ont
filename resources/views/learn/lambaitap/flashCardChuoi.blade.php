<div class="flash_content flash_chuoi">        
   <div class="description">
      <div class="des">
         {!! $question->content !!}
      </div>
      @if(!empty($question->audio_content))
           <audio controls preload="metadata" style="width: 100%;">
               <source data-size="60" src="{{ web_asset($question->audio_content) }}" type="audio/mpeg">
           </audio>
      @endif
      <div class="action">

      </div>
   </div>    
   <div class="box_action">
      <div class="icon suggest" title="Gợi ý">
         <img src="{{ web_asset('public/images/course/icon/icon_bongden.png') }}" >
      </div>
      <div class="icon report send_report" title="Báo cáo" data-id="{{ $question->id }}">
         <img src="{{ web_asset('public/images/course/icon/icon_flag.png') }}" >
      </div>
      <div class="icon bookmark {{ isset($var['userBookmark'][$question->id]) ? 'bookmarked' : '' }}" title="{{ isset($var['userBookmark'][$question->id]) ? 'Bỏ bookmark' : 'Thêm bookmark' }}" data-id="{{ $question->id }}">
         <img src="{{ web_asset('public/images/course/icon/icon_bookmark.png') }}" >
      </div>
   </div>
   @if(isset($question->child) && count($question->child) > 0)   
   @foreach ($question->child as $question_child)
   <div class="box_flash">
    <input type="hidden" name="question_id" value="{{ $question->id }}">
    <input type="hidden" name="type" value="{{ $var['type'] }}" > 
    @if(!empty($question_child->img_before) && !empty($question_child->img_after))
    <div class="image card">
      <div class="box_img box_before card__face card__face--front">      
         <div>
            @if(!empty($question_child->img_before))
               <img src="{{ web_asset($question_child->img_before) }}" class="img_before" style="width: 350px; height: 240px;">
            @endif
         </div>                                                                           
         
      </div>

      <div class="box_img box_after card__face card__face--back" style="">
         <div>
            @if(!empty($question_child->img_after))
               <img src="{{ web_asset($question_child->img_after) }}" class="img_after" style="width: 350px; height: 240px;">                     
            @endif            
         </div>         
         
      </div>                                                                  
   </div>
   @endif
   <div class="box_suggest">
      <div class="before">
         <div class="question">
            <p>{!! $question_child->question !!}</p>
         </div>
         @if(!empty($question_child->audio_question))
              <audio controls preload="metadata" style="width: 100%;">
                  <source data-size="60" src="{{ web_asset($question_child->audio_question) }}" type="audio/mpeg">
              </audio>
         @endif
         <div class="suggest suggest_before">{!! $question_child->explain_before !!}</div>
      </div>
      <div class="after">
         <div class="question">
            <p>{!! $question_child->question_after !!}</p>
         </div>
         @if(!empty($question_child->audio_question_after))
            <div class="mediPlayer">
              <audio class="listen" preload="none" data-size="60" src="{{ web_asset($question_child->audio_question_after) }}"></audio>
            </div>      
         @endif
         <div class="suggest suggest_after">{!! $question_child->explain_after !!}</div>
      </div>
   </div>
   <div class="box_caction_muti">
      <div class="icon suggest" title="Gợi ý">
         <img src="{{ web_asset('public/images/course/icon/bong_den_size.png') }}">
      </div>
      <div class="icon report send_report" title="Báo cáo" data-id="{{ $question_child->id }}" data-type="{{ $question->type }}">
         <img src="{{ web_asset('public/images/course/icon/icon_flag.png') }}" >
      </div>
      <div class="face">
         <i class="fa fa-history before"></i>
      </div>
   </div>   
</div>
@if(isset($question_child->child) && count($question_child->child) > 0)
@foreach ($question_child->child as $question_child_child)
<div class="box_flash sub_card" id="{{ $question_child_child->id }}">
 <input type="hidden" name="question_id" value="{{ $question->id }}">
 @if(!empty($question_child_child->img_before))
 <div class="image card">
   <div class="box_img box_before card__face card__face--front">      
      <div>
         @if(!empty($question_child_child->img_before) && !empty($question_child_child->img_after))
            <img src="{{ web_asset($question_child_child->img_before) }}" class="img_before" style="width: 350px; height: 240px;">
         @endif
      </div>                                                                  
      
      
   </div>

   <div class="box_img box_after card__face card__face--back" style="">
      <div>
         @if(!empty($question_child_child->img_after))
            <img src="{{ web_asset($question_child_child->img_after) }}" class="img_after" style="width: 350px; height: 240px;">
         @endif                                   
      </div>      
      
   </div>                                                                  
</div>
@endif
<div class="box_suggest">
   <div class="before">
      <div class="question">
         <p>{!! $question_child_child->question !!}</p>
      </div>
      @if(!empty($question_child_child->audio_question))
           <audio controls preload="metadata" style="width: 100%;">
               <source data-size="60" src="{{ web_asset($question_child_child->audio_question) }}" type="audio/mpeg">
           </audio>
      @endif
      <div class="suggest suggest_before">{!! $question_child_child->explain_before !!}</div>
   </div>
   <div class="after">
      <div class="question">
         <p>{!! $question_child_child->question_after !!}</p>
      </div>
      @if(!empty($question_child_child->audio_question_after))
            <div class="mediPlayer">
              <audio class="listen" preload="none" data-size="60" src="{{ web_asset($question_child_child->audio_question_after) }}"></audio>
            </div>      
      @endif
      <div class="suggest suggest_after">{!! $question_child_child->explain_after !!}</div>
   </div>
</div>
<div class="box_caction_muti">
   <div class="icon suggest" title="Gợi ý">
      <img src="{{ web_asset('public/images/course/icon/bong_den_size.png') }}">
   </div>
   <div class="icon report send_report" title="Báo cáo" data-id="{{ $question_child_child->id }}" data-type="{{ $question->type }}">
         <img src="{{ web_asset('public/images/course/icon/icon_flag.png') }}" >
      </div>
   <div class="face">
      <i class="fa fa-history before"></i>
   </div>
</div> 
</div>
@endforeach
@endif
@endforeach                                         

@endif

<div class="next">
   <button class="btn not_remeber check_flashcard" data-reply='1'>
      <i class="fa fa-close"></i>
      <p>Chưa nhớ</p>
   </button>
   <button class="btn remeber check_flashcard" data-reply="2">
      <i class="fa fa-check"></i>
      <p>Đã nhớ</p>
   </button>
</div>
</div>  