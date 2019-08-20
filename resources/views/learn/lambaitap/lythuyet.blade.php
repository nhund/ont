@extends('layoutCourse')
@push('css')
<link href="{{ web_asset('public/css/course-learn.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
<div class="hoclythuyet">        
    <div class="header-navigate clearfix mb15">
        <div class="container">
         <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5 head_course head_lythuyet">
           <ol class="breadcrumb breadcrumb-arrow">
            <li><a href="{{ route('courseList') }}" target="_self">Khóa học</a></li>
            <li>/</li>
            <li><a title="{{ $var['course']->name }}" href="{{ route('course.learn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id]) }}" target="_self">{{ str_limit($var['course']->name,20) }}</a></li>                                            
            <li>/</li>
            <li class="active"><span>{{ $var['lesson']->name }} / Lý thuyết</span></li>
        </ol>
        <div class="close_course">
            <a href="{{ route('course.learn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id]) }}" class="fa fa-close"></a>   
        </div>
    </div>
</div>
</div>
</div>
<section id="hoclythuyet" class="clearfix">
    <div class="container">
        <div class="row">                   
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                {{-- <h1>{{ $var['lesson']->name }}</h1> --}}
                {{-- <div class="video">
                    {!! $var['lesson']->video !!}
                </div> --}}
                <div class="des">
                    {!! $var['lesson']->description !!}                    
                    @if(!empty($var['lesson']->audio))
                    <p>Audio :</p>
                    <div class="mediPlayer">
                        <audio class="listen" preload="none" data-size="60" src="{{ web_asset('public/'.$var['lesson']->audio) }}"></audio>
                    </div>
                    @endif
                </div>
                <div class="next">
                    <form action="{{ $var['child'] }}">
                                {{-- <input type="hidden" name="type" value="" >
                                <input type="hidden" name="type" value="" >
                                <input type="hidden" name="type" value="" > --}}
                        <button class="btn btn_submit_doc" data-id="{{ $var['lesson']->id }}">Đã hoàn thành</button>
                    </form>
                </div>                    
            </div>    
        </div>               
    </div>
</section>  
    </div>  
    @stop
    @push('js')
    <script type="text/javascript">
       var submit_doc = '{{ route('user.lambaitap.lyThuyetSubmit') }}';
   </script> 
   <script src='{{ web_asset('public/js/learn/course_question.js') }}' type='text/javascript'></script>     
   @endpush