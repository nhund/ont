<div class="question-app-dien-tu">
    <div class="question-item">
        <div class="head">
            <div class="title">
                {!! $item->question !!}
                @if(!empty($item->img_before))
                    <div class="box_image">
                        <img src="{{ web_asset($item->img_before) }}">
                    </div>
                @endif
            </div>
            <div class="clearfix"></div>
            @if(!empty($item->audio_question))
                    <audio data-audio controls preload="metadata" style="width: 100%;">
                        <source data-size="60" src="{{ web_asset($item->audio_question) }}" type="audio/mpeg">
                    </audio>
            @endif
            <div class="sugess">
                <img src="{{ web_asset('public/app/icon/question-sugess.png') }}" />
            </div>
        </div>
        <div class="content content_text">
            {!! $item->content !!}
        </div>
        <div class="sugess_item">
            <div class="title">
                Gợi ý
            </div>
            <div class="content content_text">
                {!! $item->explain_before !!}
            </div>
        </div>
        <div class="answer">
            <div class="title">Trả lời</div>
            <div class="answer-input">
                <div class="box-icon">
                    <img src="{{ web_asset('public/app/icon/question-error.png') }}" class="question-error" />
                    <img src="{{ web_asset('public/app/icon/question-success.png') }}" class="question-success" />
                </div>
                <input type="text" class="input_answer input_question_{{ $item->id }}" data-question="{{ $item->id }}" placeholder="Nhập câu trả lời" name="answers[{{ $item->id }}]" />
                <div class="result">
                    <span>Đáp án :</span>
                    <span class="result_text"></span>
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
</div>