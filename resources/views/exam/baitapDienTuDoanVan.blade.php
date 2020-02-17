<div class="dientu_chuoi_box dien_tu_doan_van pause-exam">
    <form class="form_dien_tu_dien_tu_doan_van">
        <input type="hidden" name="id" value="{{ $question->id }}" >
        <input type="hidden" name="exam_id" value="{{ $var['lesson']->id }}" >
        <input type="hidden" name="until_number" value="{{ $key + 2 }}">

        <div id="format_content_{{ $question->id }}" style="display: none"></div>
        <div class="head_content">
            <div class="audio_box">

            </div>
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

           </div>
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
            <button class="btn btn_next">Làm tiếp</button>
            <a href="{{route('exam.question', ['title' =>str_slug($var['lesson']->name), 'id'=> $var['lesson']->id ])}}" class="btn btn_finish">Kết thúc</a>
        </div>
        @endif
    </div> 
</form>   
</div>