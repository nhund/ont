<form class="form_dien_tu_doan_van question_type question_stt_{{ $key + 1  }}" data-stt="{{ $key + 1 }}">
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
    <div class="question_com content_text">
        {!! $question['content'] !!}
    </div>
    @if(!empty($question['explain_before']))
        <div class="sugess_all">
            <div class="title">
                Gợi ý
            </div>
            <div class="content content_text">
                {!! $question['explain_before'] !!}
            </div>
        </div>
    @endif
    @foreach ($question['childs'] as $item)
        @include('app.question_item.dien_tu_doan_van_item')
    @endforeach

</form>