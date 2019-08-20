<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="Anhmt">
    <meta name="title" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" href="{{ web_asset('public/favicon.ico') }}">
    <meta name="apple-touch-fullscreen" content="yes">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,700' rel='stylesheet' type='text/css'>
    <link href="{{ asset('/public/admintrator/assets/fonts/font-awesome/css/font-awesome.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('/public/admintrator/assets/css/styles.css') }}?v={{ time() }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('/public/admintrator/assets/plugins/jstree/dist/themes/avalon/style.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('/public/admintrator/assets/plugins/codeprettifier/prettify.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('/public/admintrator/assets/plugins/iCheck/skins/minimal/blue.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('/public/admintrator/assets/plugins/form-select2/select2.css')}}" type="text/css" rel="stylesheet">

    <link href="{{ asset('/public/admintrator/assets/css/admin.css')}}?v={{ time() }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('public/css/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/public/admintrator/assets/plugins/toastr/toastr.min.css')}}?ver={{ time() }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('/public/admintrator/assets/css/admin.css')}}?ver={{ time() }}" type="text/css" rel="stylesheet">
    @stack('css')
</head>
<body class="infobar-offcanvas sidebar-collapsed breadcrumb-top">
    @include('include.backend.header')

    <div id="wrapper">
        <div id="layout-static">
            <div class="static-sidebar-wrapper sidebar-default">
                <div class="static-sidebar">
                    @include('include.backend.menu')
                </div>
            </div>
            <div class="static-content-wrapper">
                <div class="static-content">
                    <div class="page-content">
                         @yield('content')
                    </div>
                </div>
                @include('include.backend.footer')
            </div>
        </div>
    </div>
          

    <script src="{{ asset('/public/admintrator/assets/js/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ web_asset('public/js/tracking.js') }}"></script>   
    <script src="{{ asset('/public/admintrator/assets/js/jqueryui-1.9.2.min.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/codeprettifier/prettify.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/bootstrap-switch/bootstrap-switch.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/js/enquire.min.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/js/application.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/powerwidgets/js/powerwidgets.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/form-jasnyupload/fileinput.min.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/form-select2/select2.min.js') }}"></script>
    <script src="{{ asset('public/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/js/player.js') }}"></script>


    <script type="text/javascript" src="{{ asset('public/admintrator/assets/plugins/form-ckeditor/plugins/ckeditor_wiris/integration/WIRISplugins.js?viewer=image') }}"></script>
    <script type="text/javascript" src="{{ web_asset('public/admintrator/assets/plugins/form-ckeditor/plugins/ckeditor_wiris/core/display.js') }}"></script>
    <script type="text/javascript" src="{{ web_asset('public/admintrator/assets/plugins/form-ckeditor/plugins/ckeditor_wiris/wirisplugin-generic.js') }}"></script>
    
    <script type="text/javascript"
        src="{{ asset('public/plugin/ckeditor/plugins/mathjax/MathJax.js?config=TeX-AMS-MML_SVG.js') }}">
    </script>
    <script type="text/x-mathjax-config;executed=true">
        MathJax.Hub.Config({
              tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
            });
    </script>  
    @if (Session::has('sweet_alert.alert'))            
        <script>
            swal({!! Session::pull('sweet_alert.alert') !!});
        </script>
    @endif
    @if(Auth::check())                    
        @include('include.firebase')            
    @endif
    @stack('js')
    <script src="{{ asset('/public/admintrator/assets/js/admin.js') }}?ver={{ time() }}"></script>
</body>

</html>
