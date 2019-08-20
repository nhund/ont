@extends('layout')

@section('title', 'onthiez')
@section('description', 'onthiez')
@section('keywords', 'onthiez')

@push('css')

    <link href="{{ asset('css/posts/animate.css') }}" rel="stylesheet" type="text/css">
    <style>
        .error_404{
            text-align: center;
        }
        #tear {
            transition: opacity 1s ease-in-out;
        }

        .counter {
            margin-top: 1rem;
        }

        .back_home {
            color: #fff;
            background-color: #ff7102;
            border: 1px solid transparent;
            border-radius: 500px;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin: 1rem 0;
            padding: 20px 56px;
            text-decoration: none;
            transition-duration: 0.3s;
            transition-property: background-color;
            text-transform: uppercase;
            display: inline-block;
        }

        .back_home:hover {
            cursor: pointer;
            background-color: #ffffff;
            color: #ff7102;
        }
    </style>
@endpush
@section('facebook_meta')
    <meta property="og:url"         content="{{ route('home') }}" />
    <meta property="og:type"        content="article" />
    <meta property="og:title"       content="111" />
    <meta property="og:description" content="22" />
    <meta property="og:image"       content="" />
    <meta property="og:image:alt"   content="" />
@stop
@section('content')
    <div class="container error_404">
        <div>
            <h1>404 Error</h1>
            <p>Địa chỉ không tồn tại</p>
            <svg width="128" height="128" xmlns="">
                <path d="M64,9.64C1.69,9.64,0.21,79.5,0.21,93.33c0,13.83,28.56,25.03,63.79,25.03 c35.24,0,63.79-11.21,63.79-25.03C127.79,79.5,126.32,9.64,64,9.64z" fill="#fcc21b"/>
                <g fill="#2a2a39">
                    <path d="M42.21,62.3c-4.49,0.04-8.17-4.27-8.22-9.62c-0.05-5.37,3.55-9.75,8.04-9.79 c4.48-0.04,8.17,4.27,8.22,9.64C50.3,57.88,46.7,62.25,42.21,62.3z"/>
                    <path d="M86.32,62.3c4.48-0.01,8.11-4.36,8.1-9.71c-0.01-5.37-3.66-9.7-8.14-9.69 c-4.49,0.01-8.13,4.36-8.12,9.73C78.18,57.98,81.83,62.31,86.32,62.3z"/>
                </g>
                <path d="M95.26,95.77c-0.75,0-1.5-0.28-2.08-0.84c-15.27-14.69-43.08-14.69-58.35,0 c-1.19,1.15-3.09,1.11-4.24-0.08c-1.15-1.19-1.11-3.09,0.08-4.24c17.45-16.79,49.23-16.79,66.67,0c1.19,1.15,1.23,3.05,0.08,4.24 C96.83,95.47,96.04,95.77,95.26,95.77z" fill="#2a2a39"/>
                <path d="M105.64,84.1c-1.55-2.5-3.31-7.87-3.57-9.57c-0.46-2.94-1.7-8.28-2.6-12.74 c-0.24-1.21-0.23-2.88,1.29-2.96c1.21-0.04,3.12,0.69,4.24,1.07c3.29,1.12,6.74,3.04,9.6,4.97c5.22,3.57,8.75,9.3,8.05,15.78 c-0.53,4.78-5.02,7.94-9.08,7.75C110.65,88.26,107.09,86.42,105.64,84.1z" fill="#f1f2f3"/>
                <path id="tear" d="M105.64,84.1c-1.55-2.5-3.31-7.87-3.57-9.57c-0.46-2.94-1.7-8.28-2.6-12.74 c-0.24-1.21-0.23-2.88,1.29-2.96c1.21-0.04,3.12,0.69,4.24,1.07c3.29,1.12,6.74,3.04,9.6,4.97c5.22,3.57,8.75,9.3,8.05,15.78 c-0.53,4.78-5.02,7.94-9.08,7.75C110.65,88.26,107.09,86.42,105.64,84.1z" fill="#2a2a39"/>
            </svg>
            <p>Bạn sẽ quay trở lại trang chủ sau: </p>
            <p class="counter"></p>
            <a href="{{ route('home') }}" class="back_home">Quay lại trang chủ</a>

        </div>
    </div>
@stop
@push('scripts')
    <script type="text/javascript" src="{{ asset('plugin/jquery.waypoints.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var counter = document.querySelector('.counter');
            var tear = document.getElementById('tear');
            var tear2 = document.getElementById('tear2');
            var secondsRemaining = 15;
            var tearIsWhite = true;
            setInterval(function () {
                if (secondsRemaining < 0) return;
                if(secondsRemaining == 0)
                {
                    //window.location.href = '{{ route('home') }}';
                }
                counter.textContent = secondsRemaining + ' seconds';
                secondsRemaining--;
                tearIsWhite ? tear.style.opacity = 1 : tear.style.opacity = 0;
                tearIsWhite = !tearIsWhite;
            }, 1000);
        });
    </script>
@endpush


