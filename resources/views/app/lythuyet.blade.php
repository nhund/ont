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
    <link href='{{ secure_asset('public/app/css/ly_thuyet.css'). '?v='.time() }}' rel='stylesheet' type='text/css'  media='all'  />
</head>
<body>

<div id="app">
{{--    <script>--}}
{{--        var count_question = '{{ count($questions) }}';--}}
{{--    </script>--}}
    <div class="ly_thuyet">
        @if(isset($lesson->description))
            {!! $lesson->description !!}
        @endif
    </div>
</div>
<!---------------- Javascript ----------------->
<script>
    var base_url = '{{ URL::to('/') }}';
</script>
<script src='{{ secure_asset('public/js/jquery-1.12.4.min.js'). '?v='.time() }}' type='text/javascript'></script>
<script src='{{ secure_asset('public/app/js/ly_thuyet.js'). '?v='.time() }}' type='text/javascript'></script>

</body>
</html>
