<div class="trac_nghiem_box pause-exam">
    <form class="form_trac_nghiem">
        <input type="hidden" name="id" value="{{ $question->id }}" >
        <input type="hidden" name="exam_id" value="{{ $var['lesson']->id }}" >
        <input type="hidden" name="until_number" value="{{ $key + 2 }}">

        <div class="head_content">
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
            @if(!empty($question->audio_content))
                <audio controls preload="metadata" style="width: 100%;">
                    <source data-size="60" src="{{ web_asset($question->audio_content) }}" type="audio/mpeg">
                </audio>
            @endif
    </div>
    <div class="content_question">
        @if(isset($question) && isset($question->child))     
        <input type="hidden" name="count_question" value="{{ count($question->child) }}" >       
        <div class="list_question">
            @foreach ($question->child as $subKey => $question_child)
            <div class="question_item question_id_{{ $question_child->id }}">
                <div class="question">
                    <p>{!! $question_child->question  !!}</p>     
                    @if(!empty($question_child->img_before))
                        <img class="img_question" src="{{ web_asset($question_child->img_before) }}" >
                    @endif                           
                </div>
                @if(!empty($question->audio_question))
                    <div class="mediPlayer">
                      <audio class="listen" preload="none" data-size="60" src="{{ web_asset($question->audio_question) }}"></audio>
                    </div>      
                @endif
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
            </div>
            @endforeach              
        </div>
        <div class="submit_question">
            @if(count($var['questions']) - 2 >= $key)
                <button class="btn btn_next" data-type="{{$var['questions'][$key + 1]->type}}" data-stt="{{$key + 1}}">Câu tiếp</button>
            @endif
            <a style="display: none" href="{{route('exam.question', ['title' => str_slug($var['lesson']->name), 'id'=>$var['lesson']->id ])}}" class="btn btn_finish">Kết thúc</a>
        </div>
        @endif
    </div> 
</form>   
</div>