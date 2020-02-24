<div class="dientu_chuoi_box dien_tu_doan_van pause-exam">
    <form class="form_dien_tu_dien_tu_doan_van">
        <input type="hidden" name="id" value="{{ $question->id }}" >
        <input type="hidden" name="exam_id" value="{{ $var['lesson']->id }}" >
        <input type="hidden" name="until_number" value="{{ $key + 2 }}">

        <div id="format_content_{{ $question->id }}" style="display: none"></div>
        <div class="head_content">
            <div class="audio_box">

            </div>
            @if(!empty($question->img_before))
            <div class="box_image">
                <img src="{{ web_asset('public/'.$question->img_before) }}">
            </div>
            @endif
            @if(!empty($question->content))
            <div class="box_des">
                {!! $question->content !!}
            </div>
            @endif
    </div>
    <div class="content_question">
        @if(isset($question))
        <div class="list_question">
            @foreach ($question->childs as $subKey => $question_child)
            <div class="question_item question_id_{{ $question_child->id }}">
                <div class="question">
                    {!! $question_child->question_display !!}
                </div>
            </div>
            @endforeach
        </div>
            @if(count($var['questions']) - 2 >= $key)
                <div class="submit_question">
                    <button class="btn btn_next" data-type="{{$var['questions'][$key + 1]->type}}" data-stt="{{$key + 1}}">Làm tiếp</button>
                    <a style="display: none" href="{{route('exam.question', ['title' => str_slug($var['lesson']->name), 'id'=>$var['lesson']->id ])}}" class="btn btn_finish">Hoàn thành</a>
                </div>
            @endif
        @endif
    </div>
</form>
</div>