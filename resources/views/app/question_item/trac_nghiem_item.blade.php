<div class="question-app-trac-nghiem">
    <div class="title">
        @if(!empty($item->audio_question))
                    <audio data-audio controls preload="metadata" style="width: 100%;">
                        <source data-size="60" src="{{ web_asset($item->audio_question) }}" type="audio/mpeg">
                    </audio>
        @endif
        {!! $item->question !!}
        @if(!empty($item->img_before))
            <div class="box_image">
                <img class="img_question" src="{{ web_asset($item->img_before) }}" >
            </div>
        @endif
    </div>

    <div class="content">
        {{-- <div class="question_all">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
        </div> --}}
        <div class="sugess_item">
            <div class="title">
                Gợi ý
            </div>
            <div class="content content_text">
                    {!! $item->explain_before !!}
            </div>
        </div>
        <div class="box-answer">
            <div class="title">
                Trả lời
            </div>
            <div class="list-answer" data-id="{{ $item->id }}">
                @foreach ($item->answers as $answer)
                    <div class="answer">
                        <input type="radio" class="answer_radio answer_{{ $answer->id }}" value="{{ $answer->id }}" data-question={{ $item->id }} name="answers[{{ $item->id }}]">
                        <div class="box-icon">
                            <img src="{{ web_asset('public/app/icon/question-check.png') }}" class="question-check" />
                            <img src="{{ web_asset('public/app/icon/question-error.png') }}" class="question-error" />
                            <img src="{{ web_asset('public/app/icon/question-success.png') }}" class="question-success" />
                        </div>
                        <div class="answer-text content_text">
                            @if(!empty($answer->image))
                                <div class="box_image">
                                    <img src="{{ web_asset($answer->image) }}">
                                </div>
                            @endif
                                {!! $answer->answer !!}
                        </div>
                    </div>
                @endforeach
            </div>
            @if(!empty($item->interpret))
                <div class="explain-answer box_interpret_{{ $item->id }} content_text">
                    <div class="title">Giải thích</div>
                    <div class="content">{!! $item->interpret !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>