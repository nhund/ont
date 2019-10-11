<!doctype html>
<html lang="en">
   <meta http-equiv="content-type" content="text/html;charset=utf-8" />
   <head>
      <link rel="shortcut icon" href="{{ web_asset('public/favicon.ico') }}">
      <meta charset="utf-8" />
      <!--[if IE]>
      <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
      <![endif]-->
      <title>
         {{ isset($data_all['about']->title) ? $data_all['about']->title : '' }}
      </title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta content='width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=0' name='viewport' />
      <link rel="canonical" href="{{ route('home') }}" />
      <meta property="og:type" content="website" />
      <meta property="og:title" content="{{ isset($data_all['about']->title) ? $data_all['about']->title : '' }}" />
      <meta property="og:image" content="{{ isset($data_all['about']->logo) ? web_asset($data_all['about']->logo) : '' }}" />
      <meta property="og:image" content="#" />
      <meta property="og:url" content="{{ route('home') }}" />
      <meta property="og:site_name" content="{{ isset($data_all['about']->title) ? $data_all['about']->title : '' }}" /> 
      <!---------------- CSS ----------------->
      <link href='{{ web_asset('public/css/bootstrap.css') }}' rel='stylesheet' type='text/css'  media='all'  />
      <link href='{{ web_asset('public/css/font-awesome.min.css') }}' rel='stylesheet' type='text/css'  media='all'  />
      <link href='{{ web_asset('public/css/styles.css') }}' rel='stylesheet' type='text/css'  media='all'  />      
      <link href="{{ web_asset('public/css/sweetalert.css') }}" rel="stylesheet" type="text/css">
      <link href="{{ web_asset('public/css/toastr.min.css') }}" rel="stylesheet" type="text/css">
      @stack('css')
   </head>
   <body class="hideresponsive">
      <div id="box-wrapper">
         <main>
            @yield('content')                                   
         </main>         
      </div>      
      @if(!Auth::check())
        <script>
            var route_login = '{{ route('login') }}';
            var route_register = '{{ route('register') }}';
        </script>
        @include('include.login')
        @include('include.register')
      @endif

      <!---------------- Javascript ----------------->
      <script>
          var base_url = '{{ URL::to('/') }}';
      </script>

      <script src='{{ web_asset('public/js/jquery-1.12.4.min.js') }}' type='text/javascript'></script>      
      <script src="{{ web_asset('public/js/tracking.js') }}"></script>   
      <script src="{{ web_asset('public/js/bootstrap.min.js') }}" type="text/javascript"></script>
      <script src="{{ web_asset('public/js/sweetalert.min.js') }}"></script>
      <script src="{{ web_asset('public/js/toastr.min.js') }}"></script>
      {{--<script src='{{ web_asset('public/js/no_coppy.js') }}' type='text/javascript'></script>--}}
      <script type="text/javascript" src="{{ asset('public/admintrator/assets/plugins/form-ckeditor/plugins/ckeditor_wiris/integration/WIRISplugins.js?viewer=image') }}"></script>
      <script type="text/javascript" src="{{ web_asset('public/admintrator/assets/plugins/form-ckeditor/plugins/ckeditor_wiris/core/display.js') }}"></script>
      <script type="text/javascript" src="{{ web_asset('public/admintrator/assets/plugins/form-ckeditor/plugins/ckeditor_wiris/wirisplugin-generic.js') }}"></script>
      <script type="text/javascript" async
        src="{{ asset('public/plugin/ckeditor/plugins/mathjax/MathJax.js?config=TeX-AMS-MML_SVG.js') }}">
      </script>
      <script type="text/x-mathjax-config;executed=true">
          MathJax.Hub.Config({
                tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]},
                processEscapes: true
              });
      </script>  
      <script src="{{ web_asset('/public/admintrator/assets/js/player.js') }}"></script> 
      <script>
      $(document).ready(function () {
        if( $('.mediPlayer').length ) 
        {
          $('.mediPlayer').mediaPlayer();  
        }        
    });
  </script>     
     @if(Auth::check())            
            @include('include.firebase')
      @endif     
      @if (Session::has('sweet_alert.alert'))            
            <script>
                swal({!! Session::pull('sweet_alert.alert') !!});
            </script>
        @endif
      @stack('js')
          
      <div class="back-to-top">
         <a href="javascript:void(0);">
            <svg class="svg-next-icon svg-next-icon-size-30" style="fill:#50ad4e">
               <use xlink:href="#icon-scrollUp-bottom"></use>
            </svg>
         </a>
      </div>
   </body>   
</html>