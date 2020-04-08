<div class="question-app-dien-tu">
    <div class="content content_text">
        {!! $item->question_display !!}
    </div>
    @if(!empty($item->interpret))
        <div class="explain box_interpret_{{ $item->id  }}">
            <div class="title">Giải thích</div>
            <div class="content content_text">
                {!! $item->interpret  !!}
            </div>
        </div>
    @endif
</div>