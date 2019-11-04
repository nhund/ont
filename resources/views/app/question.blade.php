<!doctype html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <link rel="shortcut icon" href="{{ web_asset('public/favicon.ico') }}">
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=0" name="viewport">
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
    <![endif]-->
    <title>

    </title>
    <!---------------- CSS ----------------->
    <link href='{{ web_asset('public/app/css/question.css') }}' rel='stylesheet' type='text/css'  media='all'  />
</head>
<body>

<div id="app">
    @if($question['type'] == \App\Models\Question::TYPE_TRAC_NGHIEM)
        <form class="form_trac_nghiem">
            <input type="hidden" name="question_id" value="{{ $question->id }}" >
            <input type="hidden" name="type" value="lam-bai-tap" >  
            @foreach ($question['childs'] as $item)
                @include('app.trac_nghiem')
            @endforeach        
        </form>
    @endif
        @if($question['type'] == \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN)
            <form class="form_dien_tu_doan_van">
                <div class="list-action">
                    <div class="icon active icon-comment">
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
                @foreach ($question['childs'] as $item)
                    @include('app.dien_tu_doan_van')
                @endforeach

            </form>
        @endif
        @if($question['type'] == \App\Models\Question::TYPE_DIEN_TU)
            <form class="form_dien_tu">
                <div class="list-action">
                    <div class="icon active icon-comment">
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
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting
                </div>
                <div class="sugess_all">
                    <div class="title">
                        Gợi ý
                    </div>
                    <div class="content">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since
                    </div>
                </div>
                <input type="hidden" name="question_id" value="{{ $question->id }}" >
                <input type="hidden" name="type" value="lam-bai-tap" >
                @foreach ($question['childs'] as $item)
                    @include('app.dien_tu')
                @endforeach
            </form>
        @endif
</div>
<!---------------- Javascript ----------------->
<script>
    var base_url = '{{ URL::to('/') }}';
</script>
<script src='{{ web_asset('public/js/jquery-1.12.4.min.js') }}' type='text/javascript'></script>
<script src='{{ web_asset('public/app/js/question.js') }}' type='text/javascript'></script>

</body>
</html>