<div class="dientu_chuoi_box dien_tu_doan_van">    
    <form class="form_dien_tu_dien_tu_doan_van">
        <input type="hidden" name="id" value="{{ $question->id }}" >
        <input type="hidden" name="type" value="{{ $var['type'] }}" >
        <div id="format_content_{{ $question->id }}" style="display: none"></div>
        <div class="head_content">
            @if(!empty($question->audio_content))
                <audio controls preload="metadata" style="width: 100%;">
                    <source data-size="60" src="{{ web_asset($question->audio_content) }}" type="audio/mpeg">
                </audio>
            @endif
            @if(!empty($question->img_before))
            <div class="box_image">
                <img src="{{ web_asset('public/'.$question->img_before) }}">
            </div>
            @endif
            @if(!empty($question->content))
            <div class="box_des">
                {!! $question->content !!}
            </div>
            @endif

            <div class="box_action">
                {{-- <div class="icon suggest" title="Gợi ý">
                   <img src="{{ web_asset('public/images/course/icon/icon_bongden.png') }}" >
               </div> --}}
               <div class="icon report send_report" title="Báo cáo" data-id="{{ $question->id }}">
                   <img src="{{ web_asset('public/images/course/icon/icon_flag.png') }}" >
               </div>
               <div class="icon bookmark {{ isset($var['userBookmark'][$question->id]) ? 'bookmarked' : '' }}" title="{{ isset($var['userBookmark'][$question->id]) ? 'Bỏ bookmark' : 'Thêm bookmark' }}" data-id="{{ $question->id }}">
                   <img src="{{ web_asset('public/images/course/icon/icon_bookmark.png') }}" >
               </div>
           </div>
           {{-- <div class="box_suggest">
            <p>Gợi ý</p>
            <div class="suggest_content">
                {!! $question->explain_before !!}
            </div>
        </div>  --}}
        @if(!empty($question->interpret_all))
                <div class="box_interpret_all">
                    <p>Giải thích chung : <span>{!! $question->interpret_all !!}</span></p>                
                </div> 
            @endif
    </div>
    <div class="content_question">
        @if(isset($question))        
        <div class="list_question">
            @foreach ($question->childs as $key => $question_child)
            <div class="question_item question_id_{{ $question_child->id }}">
                <div class="question">
                    {{-- <span>{{ $key + 1  }}).</span> --}}
                    {!! $question_child->question_display !!}
                    {{-- <p>{{ $question->question  }}</p> --}}                                
                </div>                            
                <div class="explain-text box_action">
                    <div class="icon suggest" title="Gợi ý">
                       <img src="{{ web_asset('public/images/course/icon/icon_bongden.png') }}" >
                   </div>
                    <div class="icon report send_report" title="Báo cáo" data-id="{{ $question_child->id }}">
                        <img src="{{ web_asset('public/images/course/icon/icon_flag.png') }}" >
                    </div>
                    <div class="icon bookmark {{ isset($var['userBookmark'][$question_child->id]) ? 'bookmarked' : '' }}" title="{{ isset($var['userBookmark'][$question_child->id]) ? 'Bỏ bookmark' : 'Thêm bookmark' }}" data-id="{{ $question_child->id }}">
                       <img src="{{ web_asset('public/images/course/icon/icon_bookmark.png') }}" >
                   </div>
                </div>
                <div class="box_suggest">
                    <p class="title">Gợi ý</p>
                    <div class="suggest_content">
                        {!! $question_child->explain_before !!}
                    </div>
                </div>
                @if(!empty($question_child->interpret))
                                <div class="box_interpret_question box_interpret_{{ $question_child->id }}">
                                    <p>Giải thích : <span>{!! $question_child->interpret !!}</span></p>
                                </div>
                            @endif 
            </div>    
            @endforeach              
        </div>
        <div class="submit_question">
            <button class="btn btn_submit">Nộp bài</button>
            <button class="btn btn_next">Câu tiếp</button>
            <a class="btn btn_continue btn-primary">Làm tiếp</a>
        </div>
        @endif
    </div> 
</form>   
</div>