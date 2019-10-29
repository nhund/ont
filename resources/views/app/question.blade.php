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
        @include('app.trac_nghiem')
    @endif
</div>
<!---------------- Javascript ----------------->
<script>
    var base_url = '{{ URL::to('/') }}';
</script>
<script src='{{ web_asset('public/js/jquery-1.12.4.min.js') }}' type='text/javascript'></script>


</body>
</html>