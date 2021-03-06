<div class="trac_nghiem_box">
    <form class="form_trac_nghiem">
        <input type="hidden" name="id" value="{{ $question->id }}" >
        <input type="hidden" name="type" value="{{ $var['type'] }}" >
        <div class="head_content">
            @if(!empty($question->audio_question))
                <audio data-audio controls preload="metadata" style="width: 100%;">
                    <source data-size="60" src="{{ web_asset($question->audio_question) }}" type="audio/mpeg">
                </audio>
            @endif
            @if(!empty($question->img_before))
            <div class="box_image">
                <img src="{{ web_asset($question->img_before) }}">
            </div>
            @endif
                <div class="row">
                    @if(!empty($question->question))
                        <div class="box_des">
                            {!! $question->question !!}
                            <div class="box_action">
                                @if(!empty($question->explain_before))
                                    <div class="icon suggest" title="Gợi ý">
                                        <img src="{{ web_asset('public/images/course/icon/icon_bongden.png') }}" >
                                    </div>
                                @endif
                                @if(!empty($question->question))
                                    <div class="icon report send_report" title="Báo cáo" data-id="{{ $question->id }}">
                                        <img src="{{ web_asset('public/images/course/icon/icon_flag.png') }}" >
                                    </div>
                                    <div class="icon bookmark {{ isset($var['userBookmark'][$question->id]) ? 'bookmarked' : '' }}" title="{{ isset($var['userBookmark'][$question->id]) ? 'Bỏ bookmark' : 'Thêm bookmark' }}" data-id="{{ $question->id }}">
                                        <img src="{{ web_asset('public/images/course/icon/icon_bookmark.png') }}" >
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <div class="clearfix"></div>
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
                        <p>Giải thích : <span id="box_interpret_all_{{ $question->id }}"></span></p>
                    </div>
                @endif
            </div>
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