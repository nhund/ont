<div class="flash_content"> 
   <div class="description">
      <div class="des">
         {!! $question->content !!}
      </div>
      @if(!empty($question->audio_content))
           <audio controls preload="metadata" style="width: 100%;">
               <source data-size="60" src="{{ web_asset($question->audio_content) }}" type="audio/mpeg">
           </audio>
      @endif
   </div>                                                      
      <div class="box_flash">
       <input type="hidden" name="question_id" value="{{ $question->id }}">
       <input type="hidden" name="type" value="{{ $var['type'] }}" >
       @if(!empty($question->img_before) && !empty($question->img_after))
            <div class="image card">
               <div class="box_img box_before card__face card__face--front">      
                  <div class="box_image">
                     @if(!empty($question->img_before))
                        <img src="{{ web_asset($question->img_before) }}" class="img_before" >
                     @endif   
                  </div>                                                                                             
               </div>            
               <div class="box_img box_after card__face card__face--back" style="">
                     <div class="box_image">
                        @if(!empty($question->img_after))
                        <img src="{{ web_asset($question->img_after) }}" class="img_after" >            
                        @endif                     
                     </div>                              
               </div>                                                                  
            </div>  
         @endif
         <div class="box_suggest">
            <div class="before">
               <div class="question">
                  <p>{!! $question->question !!}</p>
               </div>
               <div class="suggest suggest_before">{!! $question->explain_before !!}</div>
            </div>
            <div class="after">
               <div class="question">
                  <p>{!! $question->question_after !!}</p>
               </div>
               <div class="suggest suggest_after">{!! $question->explain_after !!}</div>
            </div>
         </div>       
         <div class="face">
            <i class="fa fa-history before"></i>
         </div>
      </div>
      <div class="box_action suggest_flash_card_single">
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