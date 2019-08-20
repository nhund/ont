<!doctype html>
<html lang="en">
   <meta http-equiv="content-type" content="text/html;charset=utf-8" />
   <head>      
      <link rel="shortcut icon" href="{{ web_asset('public/favicon.ico') }}">
      <meta charset="utf-8" />
      <!--[if IE]>
      <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
      <![endif]-->
      <meta name="google-site-verification" content="oM1miW7aZL3QENXwhykwcV6LM6RzOzvpgjb7K2BbAy4" />
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
      
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131344708-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-131344708-1');
      </script>
      

      @stack('css')
   </head>
   <body class="hideresponsive">      
      <button type="button" class="navbar-toggle collapsed" id="trigger-mobile">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <div id="box-wrapper">
         @include('header')
         <nav class="navbar-main navbar navbar-default cl-pri">
            <!-- MENU MAIN -->
            <div class="container nav-wrapper">
               <div class="row">                  
                  @include('menu')
               </div>
            </div>
         </nav>
         <main>
            @yield('content')                                   
         </main>
         @include('footer')
         {{-- <div class="hotline-mobile hidden-lg">
            <a href="tel:Hỗ trợ: 0938559501">
               <svg class="svg-next-icon svg-next-icon-size-40" style="fill:#50ad4e">
                  <use xmlns:xlink="https://www.w3.org/1999/xlink" xlink:href="#icon-phone-header"></use>
               </svg>
            </a>
         </div> --}}
      </div>
      @include('menu_mobile')
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
      <script type="text/javascript">
         onthi_ez_tracking.init();
      </script>   
      {{-- <script src="{{ web_asset('public/js/option_selection.js') }}"></script> --}}
      <script src="{{ web_asset('public/js/imagesloaded.pkgd.min.js') }}"></script>
      <script async src="{{ web_asset('public/js/bootstrap.min.js') }}"></script>
      <script src="{{ web_asset('public/js/owl.carousel_v2.js') }}"></script>
      <script async src="{{ web_asset('public/js/velocity.js') }}"></script>
      
      <script src='{{ web_asset('public/js/script.js') }}' type='text/javascript'></script>
      <script src='{{ web_asset('public/js/main.js') }}' type='text/javascript'></script>
      <script src='{{ web_asset('public/js/no_coppy.js') }}' type='text/javascript'></script>
      <script src="{{ web_asset('public/js/sweetalert.min.js') }}"></script>
      
      @if(Auth::check())            
            @include('include.firebase')
      @endif
      @if(!Auth::check())
        <script src='{{ web_asset('public/js/login/login.js') }}' type='text/javascript'></script>
      @endif
      @if (Session::has('sweet_alert.alert'))            
            <script>
                swal({!! Session::pull('sweet_alert.alert') !!});
            </script>
      @endif
      <div id="fb-root"></div>
      <!-- Load Facebook SDK for JavaScript --> 
   <script>
      window.fbAsyncInit = function() {
         FB.init({
            appId            : '584814145322201',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v2.12'
         });
      };
      (function(d, s, id) {
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) return;
         js = d.createElement(s); js.id = id;
         js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
         fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      @stack('js')
      {{-- <script>
         function hide_float_right() {
         	$('.float-ck').css('left','-' + $('.float-ck').width() + 'px');
         	$('.float-ck').find('.show_qc').show();
         	$('.float-ck').find('.hide_qc').hide();
         	Nobita.setCookiePopup('close',7,'banner-left');
         }
         function show_float_right() {
         	$('.float-ck').css('left','0');
         	$('.float-ck').find('.show_qc').hide();
         	$('.float-ck').find('.hide_qc').show();
         	Nobita.setCookiePopup('open',7,'banner-left');
         }
         var checkCookieBannerLeft = function (name) {
         	var username = Nobita.getCookiePopup(name);
         	if (username != "" && username == 'close') {
         		hide_float_right();
         		setTimeout(function(){
         			$('.float-ck').css('opacity','1');
         		},1000);
         	} else {
         		show_float_right();
         		setTimeout(function(){
         			$('.float-ck').css('opacity','1');
         		},1000);
         	}
         }
         $(document).ready(function(){
         	setTimeout(function(){
         		checkCookieBannerLeft('banner-left');
         	},500);
         });
      </script> --}}      
      <div class="back-to-top">
         <a href="javascript:void(0);">
            <svg class="svg-next-icon svg-next-icon-size-30" style="fill:#50ad4e">
               <use xlink:href="#icon-scrollUp-bottom"></use>
            </svg>
         </a>
      </div>
   </body>   
</html>