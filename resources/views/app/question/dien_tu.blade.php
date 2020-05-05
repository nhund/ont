<form class="form_dien_tu question_type question_stt_{{ $key + 1  }}" data-stt="{{ $key + 1 }}">
    <input type="hidden" name="question_id" value="{{ $question->id }}" >
    <input type="hidden" name="type" value="lam-bai-tap" >
    <input type="hidden" name="question_type" value="{{ $question->type }}" >
    <div class="stt">
        Câu {{ $key_plus + $key + 1 }}.
    </div>
    <div class="list-action">
        <div class="icon icon-comment">
            <img src="{{ web_asset('public/app/icon/question-comt.png') }}" />
        </div>
        <div class="icon icon-sugess">
            <img src="{{ web_asset('public/app/icon/question-sugess.png') }}" />
        </div>
        <div class="icon icon-report">
            <img src="{{ web_asset('public/app/icon/question-rp.png') }}" />
        </div>
        <div class="icon icon-bookmark">
            <img src="{{ web_asset('public/app/icon/question-bookmark.png') }}" />
        </div>
    </div>
    @if(!empty($question->audio_question))
        <audio data-audio controls preload="metadata" style="width: 100%;">
            <source data-size="60" src="{{ web_asset($question->audio_question) }}" type="audio/mpeg">
        </audio>
    @endif
    @if(!empty($question->img_before))
        <div class="box_image">
            <img src="{{$question->img_before}}">
        </div>
    @endif
    <div class="question_com content_text">
        {!! $question['content'] !!}
    </div>
    <div class="sugess_all">
        <div class="title">
            Gợi ý
        </div>
        <div class="content content_text">
            {!! $question['explain_before'] !!}
        </div>
    </div>
    @foreach ($question['childs'] as $item)
        @include('app.question_item.dien_tu_item')
    @endforeach
    {{-- <input type="button" value="submit" name="submit" /> --}}
</form>
