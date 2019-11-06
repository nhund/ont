<div class="question-app-dien-tu">
    <div class="question-item">
        <div class="head">
            <div class="title">
                Câu hỏi 1 2222222222222222
            </div>
            <div class="sugess">
                <img src="{{ web_asset('public/app/icon/question-sugess.png') }}" />
            </div>
        </div>
        <div class="content">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text
        </div>
        <div class="sugess_item">
            <div class="title">
                Gợi ý
            </div>
            <div class="content">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since
            </div>
        </div>
        <div class="answer">
            <div class="title">Trả lời</div>
            <div class="answer-input">
                <div class="box-icon">
                    <img src="{{ web_asset('public/app/icon/question-error.png') }}" class="question-error" />
                    <img src="{{ web_asset('public/app/icon/question-success.png') }}" class="question-success" />
                </div>
                <input type="text" class="input_answer" data-question="{{ $item->id }}" placeholder="Nhập câu trả lời" name="answers[{{ $item->id }}]" />
            </div>

        </div>
    </div>
</div>