<form class="form_trac_nghiem question_type question_stt_{{ $key + 1  }}" data-stt="{{ $key + 1 }}">
    <input type="hidden" name="question_id" value="{{ $question->id }}" >
    <input type="hidden" name="type" value="lam-bai-tap" >
    <input type="hidden" name="question_type" value="{{ $question->type }}" >
    <div class="stt">
        Câu {{ $key + 1 }}.
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
    <div class="question_com">
        {!! $question['content'] !!}
    </div>

    @foreach ($question['childs'] as $item)
        @include('app.question_item.trac_nghiem_item')
    @endforeach
</form>