<div class="dientu_box pause-exam">
    <form class="form_dien_tu">
        <input type="hidden" name="id" value="{{ $question->id }}" >
        <input type="hidden" name="exam_id" value="{{ $var['lesson']->id }}" >
        <input type="hidden" name="until_number" value="{{ $key + 2 }}">

        <div class="head_content">
            @if(!empty($question->audio_question))
                <audio data-audio controls preload="metadata" style="width: 100%;">
                    <source data-size="60" src="{{ web_asset($question->audio_question) }}" type="audio/mpeg">
                </audio>
            @endif
            @if(!empty($question->img_before))
                    <br/>
                <div class="box_image">
                    <img src="{{ web_asset($question->img_before) }}">
                </div>
            @endif
            @if(!empty($question->content))
                <div class="box_des">
                    {!! $question->content !!}
                </div>
            @endif
            @if(!empty($question->interpret_all))
                <div class="box_interpret_all">
                    <p>Giải thích chung : <span>{!! $question->interpret_all !!}</span></p>
                </div>
            @endif
        </div>
        <div class="content_question">
            @if(isset($question))        
                <div class="list_question">
                    @foreach ($question->child as $question)
                        <div class="question_item question_id_{{ $question->id }}">
                            @if(!empty($question->audio_question))
                                <audio data-audio controls preload="metadata" style="width: 100%;">
                                    <source data-size="60" src="{{ web_asset($question->audio_question) }}" type="audio/mpeg">
                                </audio>
                            @endif
                            <div class="question">
                                <p>{!! $question->question  !!}</p>
                                @if(!empty($question->img_before))
                                    <br/>
                                    <div class="image">
                                        <img src="{{ web_asset($question->img_before) }}">
                                    </div>
                                @endif
                            </div>
                            @if(!empty($question->audio_question))
                                <div class="mediPlayer">
                                    <audio class="listen" preload="none" data-size="60" src="{{ web_asset($question->audio_question) }}"></audio>
                                </div>
                            @endif
                            <div class="clearfix"></div>
                            <div class="answer">
                                <input type="text" class="form-control answer_value" name="answers[{{ $question->id }}]" value="">
                                <div class="explain" title="Gợi ý" data-id="{{ $question->id }}">
                                    <img src="{{ web_asset('public/images/course/icon/icon_bongden.png') }}">
                                </div>
                            </div>
                            <div class="result">
                                <div class="user_input">
                                    Câu trả lời của bạn : <span></span>
                                </div>
                                <div class="result_ok">
                                    Câu trả lời chính xác : <span></span>
                                </div>
                            </div>
                            @if(!empty($question->interpret))
                                <div class="box_interpret_question box_interpret_{{ $question->id }}">
                                    <p>Giải thích : <span>{!! $question->interpret !!}</span></p>
                                </div>
                            @endif
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