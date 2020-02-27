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
    <link href='{{ asset('public/app/css/question.css'). '?v='.time() }}' rel='stylesheet' type='text/css'  media='all'  />
</head>
<body>

<div id="app">
    <script>
        var count_question = '{{ count($questions) }}';
    </script>
    @foreach($questions as $key => $question)
        @if($question['type'] == \App\Models\Question::TYPE_TRAC_NGHIEM)
            @include('app.question.trac_nghiem')
        @endif
        @if($question['type'] == \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN)
            @include('app.question.dien_tu_doan_van')
        @endif
        @if($question['type'] == \App\Models\Question::TYPE_DIEN_TU)
            @include('app.question.dien_tu')
        @endif
    @endforeach
</div>
<!---------------- Javascript ----------------->
<script>
    var base_url = '{{ URL::to('/') }}';
</script>
<script src='{{ asset('public/js/jquery-1.12.4.min.js'). '?v='.time() }}' type='text/javascript'></script>
@if($type == 'exercise')
    <script src='{{ asset('public/app/js/question.js'). '?v='.time() }}' type='text/javascript'></script>
@else
    <script src='{{ asset('public/app/js/exam.js'). '?v='.time() }}' type='text/javascript'></script>
@endif
</body>
</html>