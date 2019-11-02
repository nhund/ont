<div id="question-app-trac-nghiem">
    <div class="title">
        {!! $item->question !!}
    </div>
    <div class="list-action">

    </div>
    <div class="content">
        {{-- <div class="question_all">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
        </div> --}}
        <div class="sugess_all">
            <div class="title">
                Gợi ý
            </div>
            <div class="content">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
            </div>
        </div>
        <div class="box-answer">
            <div class="title">
                Trả lời
            </div>
            <div class="list-answer">
                @foreach ($item->answers as $answer)
                    <div class="answer">
                        <div class="box-icon">
                            <img src="{{ web_asset('public/app/icon/question-check.png') }}" class="question-check" />
                            <img src="{{ web_asset('public/app/icon/question-error.png') }}" class="question-error" />
                            <img src="{{ web_asset('public/app/icon/question-success.png') }}" class="question-success" />
                        </div>
                        <div class="answer-text">
                                {!! $answer->answer !!}
                        </div>                    
                    </div>
                @endforeach                                
            </div>
            <div class="explain-answer">
                <div class="title">Giải thích</div>
                <div class="content">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since</div>
            </div>
        </div>
    </div>
</div>