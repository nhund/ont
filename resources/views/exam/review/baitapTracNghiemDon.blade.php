<div class="trac_nghiem_box pause-exam">
    <form class="form_trac_nghiem">
        <input type="hidden" name="id" value="{{ $question->id }}" >
        <input type="hidden" name="exam_id" value="{{ $var['lesson']->id }}" >
        <input type="hidden" name="until_number" value="{{ $key + 2 }}">

        <div class="head_content">
            @if(!empty($question->audio_question))
                <audio  data-audio controls preload="metadata" style="width: 100%;">
                    <source data-size="60" src="{{ web_asset($question->audio_question) }}" type="audio/mpeg">
                </audio>
            @endif
            @if(!empty($question->img_before))
                    <br/>
                <div class="box_image">
                    <img src="{{ web_asset($question->img_before) }}">
                </div>
            @endif
            @if(!empty($question->question))
            <div class="box_des">
                {!! $question->question !!}
            </div>
            @endif
            @if(!empty($question->explain_before))
                <div class="box_suggest">
                    <p>Gợi ý</p>
                    <div class="suggest_content">
                        {!! $question->explain_before !!}
                    </div>
                </div>
            @endif
    </div>
    <div class="content_question">
        @if(isset($question) && isset($question->answers))
        <input type="hidden" name="count_question" value="1" >
        <div class="list_question">
            <div class="question_item question_id_{{ $question->id }}">
                <div class="list_answer">
                    @if(isset($question->answers))
                        @foreach ($question->answers as $key_chhild => $question_answe)
                            <div class="radio">
                                <label>
                                    <input type="radio" class="answer_{{ $question_answe->id }}" value="{{ $question_answe->id }}" name="answers[{{ $question->id }}]">
                                    @if(!empty($question_answe->image))
                                        <img src="{{ web_asset($question_answe->image) }}">
                                    @endif
                                    {!! $question_answe->answer !!}
                                </label>
                            </div>
                        @endforeach
                    @endif
                </div>
                @if(!empty($question->interpret))
                    <div class="box_interpret_question box_interpret_{{ $question->id }}">
                        <p>Giải thích : <span id="box_interpret_all_{{ $question->id }}">{!! $question->interpret !!}</span></p>
                    </div>
                @endif
            </div>
        </div>
            <div class="submit_question">
                @if(count($var['questions']) - 2 >= $key)
                <button class="btn btn_next" data-type="{{$var['questions'][$key + 1]->type}}" data-stt="{{$key + 1}}">Câu tiếp</button>
                @endif
                <a href="{{route('exam.question', ['title' => str_slug($var['lesson']->name), 'id'=>$var['lesson']->id ])}}" class="btn btn_finish">Kết thúc</a>
            </div>
        @endif
    </div> 
</form>   
</div>