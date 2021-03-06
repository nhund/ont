<div class="trac_nghiem_box dientu_chuoi_box">
    <form class="form_trac_nghiem">
        <input type="hidden" name="id" value="{{ $question->id }}" >
        <input type="hidden" name="type" value="{{ $var['type'] }}" >        
        <div class="head_content">
            @if(!empty($question->audio_content))
                <audio data-audio controls preload="metadata" style="width: 100%;">
                    <source data-size="60" src="{{ web_asset($question->audio_content) }}" type="audio/mpeg">
                </audio>
            @endif
            @if(!empty($question->img_before))
                <div class="box_image">
                    <img src="{{ $question->img_before }}">
                </div>
            @endif
            @if(!empty($question->content))
            <div class="box_des">
                {!! $question->content !!}
            </div>
            @endif

            <div class="box_action">
                @if(!empty($question->explain_before))
                    <div class="icon suggest" title="Gợi ý">
                        <img src="{{ web_asset('public/images/course/icon/icon_bongden.png') }}" >
                    </div>
                @endif 
                @if(!empty($question->content))
                     <div class="icon report send_report" title="Báo cáo" data-id="{{ $question->id }}">
                         <img src="{{ web_asset('public/images/course/icon/icon_flag.png') }}" >
                     </div>
                     <div class="icon bookmark {{ isset($var['userBookmark'][$question->id]) ? 'bookmarked' : '' }}" title="{{ isset($var['userBookmark'][$question->id]) ? 'Bỏ bookmark' : 'Thêm bookmark' }}" data-id="{{ $question->id }}">
                         <img src="{{ web_asset('public/images/course/icon/icon_bookmark.png') }}" >
                     </div>
                @endif     
         </div><div class="clearfix"></div>
         @if(!empty($question->explain_before))
            <div class="box_suggest">
                <p>Gợi ý</p>
                <div class="suggest_content">
                    {!! $question->explain_before !!}
                </div>
            </div> 
        @endif
        @if(!empty($question->interpret_all))
            <div class="box_interpret_all">
                <p>Giải thích chung : <span id="box_interpret_all_{{ $question->id }}">{!! $question->interpret_all !!}</span></p>
            </div> 
        @endif
    </div>
    <div class="content_question">
        @if(isset($question) && isset($question->child))
        <input type="hidden" name="count_question" value="{{ count($question->child) }}" >       
        <div class="list_question">
            @foreach ($question->child as $key => $question_child)
            <div class="question_item question_id_{{ $question_child->id }}">
                @if(!empty($question_child->audio_question))
                    <audio data-audio controls preload="metadata" style="width: 100%;">
                        <source data-size="60" src="{{ web_asset($question_child->audio_question) }}" type="audio/mpeg">
                    </audio>
                @endif
                <div class="question">
                    <p>{!! $question_child->question  !!}</p>     
                    @if(!empty($question_child->img_before))
                        <img class="img_question" src="{{ web_asset($question_child->img_before) }}" >
                    @endif                           
                </div>
                <div class="box_suggest_answer">
                    <div class="suggest_answer_content">
                        {{-- {{ $question_child-> }}  --}}   
                        <p>{!! $question_child->explain_before !!}</p>
                    </div>
                    <div class="suggest_answer_icon">
                        <div class="icon suggest" title="Gợi ý">
                             <img src="{{ web_asset('public/images/course/icon/icon_bongden.png') }}" >
                        </div>
                    </div>
                    <div class="icon report send_report" title="Báo cáo" data-id="{{ $question_child->id }}" >
                        <img src="{{ web_asset('public/images/course/icon/icon_flag.png') }}" >
                    </div>
                    @if(count($question->child) == 1 && empty($question->content))
                        <div class="icon bookmark {{ isset($var['userBookmark'][$question->id]) ? 'bookmarked' : '' }}" title="{{ isset($var['userBookmark'][$question->id]) ? 'Bỏ bookmark' : 'Thêm bookmark' }}" data-id="{{ $question->id }}">
                            <img src="{{ web_asset('public/images/course/icon/icon_bookmark.png') }}" >
                        </div>
                    @endif
                </div>
                <div class="list_answer">
                    @if(isset($question_child->answers))
                    @foreach ($question_child->answers as $key_chhild => $question_answe)
                    <div class="radio">
                        <label>

                            <input type="radio" class="answer_{{ $question_answe->id }}" value="{{ $question_answe->id }}" name="answers[{{ $question_child->id }}]">
                            @if(!empty($question_answe->image))
                                <img src="{{ web_asset($question_answe->image) }}">
                            @endif
                            {!! $question_answe->answer !!}
                        </label>
                        
                        
                    </div>
                    @endforeach
                    @endif                                    
                </div>
                @if(!empty($question_child->interpret))
                    <div class="box_interpret_question box_interpret_{{ $question_child->id }}">
                        <p>Giải thích : <span id="box_interpret_all_{{ $question_child->id }}"></span></p>
                    </div>
                @endif
            </div>    
            @endforeach              
        </div>
        <div class="submit_question">
            <button class="btn btn_submit">Nộp bài</button>
            <button class="btn btn_next">Câu tiếp</button>
            @if($var['lastRound'])
                <a href="{{route('course.learn', ['id'=>$var['course']->id,'title'=>str_slug($var['course']->name)])}}" class="btn btn_continue finish btn-primary">Hoàn thành</a>
            @else
                <a class="btn btn_continue btn-primary">Làm tiếp</a>
            @endif
        </div>
        @endif
    </div> 
</form>   
</div>