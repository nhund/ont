@extends('layout')
@push('css')
   <link href="{{ web_asset('public/css/course-learn.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ web_asset('public/css/bootstrap-rating.css') }}" rel="stylesheet" type="text/css">
    <style>
        .border-lesson{
            border:0.09em solid;
            border-radius: 5px;
            padding: 8px;
        }
        .border-lesson .title{
            font-weight: bold;
        }
        .detail-lesson{
            margin: 10px 0;
        }
        .exercise-lesson .title{
            color: #259bfe;
        }
        .theory-lesson .title{
            color: #fa8b00;
        }
        .exam-lesson .title{
            color: #fbbc06
        }

        .exercise-lesson{
            border-color: #259bfe;
        }
        .theory-lesson{
            border-color: #fa8b00;
        }
        .exam-lesson{
            border-color: #fbbc06
        }
    </style>
@endpush
@section('content')
    <div class="header-navigate clearfix mb15">
       <div class="container">
          <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                <ol class="breadcrumb breadcrumb-arrow">
                   <li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
                   <li><i class="fa fa-angle-right"></i></li>
                   <li><a href="{{ route('courseList') }}" target="_self">Khóa học</a></li>
                   <li><i class="fa fa-angle-right"></i></li>
                   <li class="active"><span> {{ $var['course']->name ?? '' }}</span></li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <section id="course_learn" class="clearfix">
       <input type="hidden" name="course_id" value="{{ $var['course']->id ?? ''}}">
       <div class="container">
          <div class="row">             
              <h1 class="course_title">{{ $var['course']->name ?? '' }}</h1>
             <div class="box_left col-lg-9 col-md-9 col-sm-8 col-xs-12">                
                <div class="box_head">
                    <div class="title">Đã học 2 câu</div>
                    <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70"
                            aria-valuemin="0" aria-valuemax="100" >
                            </div>
                    </div>

                    <div class="btn-offer">
                        <a class="offer-course do_new " onclick="openNav()"
                           title="Làm bài mới">
                            <img src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                            <div class="title">
                                <p class="content">Làm tập mới</p>
                            </div>
                        </a>
                        <a class="offer-course do_old "
                           href=""
                           title="Ôn tập câu cũ">
                            <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                            <div class="title">
                                <p class="content">Ôn câu cũ</p>
                            </div>
                        </a>
                        <a class="offer-course do_false "
                           href="">
                            <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                            <div class="title">
                                <p class="content" onclick="openNav()">Làm câu sai</p>
                            </div>
                        </a>
                        <a class="offer-course do_bookmark "
                           href=""
                           title="Làm câu bookmark">
                            <img src="{{ web_asset('public/images/course/icon/icon_mark.png') }}">
                            <div class="title">
                                <p class="content">Bookmark</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="box_content">
                    <div class="head">
                            <div class="topic">Giáo trình</div>
                            <div class="count_learn">Lượt học</div>
                            <div class="topic_progress">Tiến độ</div>
                    </div>
                    <div class="body row">
                        <div class="col-md-12 detail-lesson">
                            <div class="border-lesson exercise-lesson col-md-12">
                                <div class="col-md-9">
                                    <div class="title">Bài tập</div>
                                    <div> CHƯƠNG 3: Một số nội dung cơ bản của Luật dân sự </div>
                                </div>
                                <div  class="col-md-3"><span>120</span>/200 câu</div>
                            </div>
                        </div>
                        <div class="col-md-12 detail-lesson">
                            <div class="border-lesson theory-lesson col-md-12">
                                <div class="col-md-9">
                                    <div class="title">Bài tập</div>
                                    <div> CHƯƠNG 3: Một số nội dung cơ bản của Luật dân sự </div>
                                </div>
                                <div  class="col-md-3"><span>120</span>/200 câu</div>
                            </div>
                        </div>
                        <div class="col-md-12 detail-lesson">
                            <div class="border-lesson exam-lesson col-md-12">
                                <div class="col-md-9">
                                    <div class="title">Bài tập</div>
                                    <div> CHƯƠNG 3: Một số nội dung cơ bản của Luật dân sự </div>
                                </div>
                                <div class="col-md-3"><span>120</span>/200 câu</div>
                            </div>
                        </div>
                    </div>    
                </div>
             </div>
             <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 pd5 pr-none-destop box-filter">
                @include('learn.course_info')
             </div>
          </div>


       </div>


       <div id="myNav" class="overlay">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <p class="title">Chọn phương thức học</p>
            <div class="overlay-content">
                <div class="method do_new">
                    <a href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BAI_MOI]) }}" title="Làm bài mới">
                        <img src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                    </a>
                    <p>Làm bài mới</p>
                </div>
                <div class="method do_old">
                    <a href="{{ 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_CU]) }}" title="Ôn tập câu cũ">
                        <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                    </a>
                    <p>Ôn tập câu cũ</p>
                </div>
                <div class="method do_false">
                        <a href="{{ 0 ? 'javascript:void(0)' :  route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_SAI]) }}" title="Làm lại câu sai">
                            <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                        </a>
                        <p>Làm lại câu sai</p>
                </div>
                <div class="method do_bookmark}">
                        <a href="{{ 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BOOKMARK]) }}" title="Làm câu bookmark">
                            <img src="{{ web_asset('public/images/course/icon/icon_mark.png') }}">
                        </a>
                        <p>Làm câu bookmark</p>
                </div>
            </div>
      </div>
    </section>    
@stop
@push('js')
<script src='{{ web_asset('public/js/detail/bootstrap-rating.min.js') }}' type='text/javascript'></script>
<script src='{{ web_asset('public/js/learn/course_learn.js') }}' type='text/javascript'></script>

<script>
        function openNav() {
          document.getElementById("myNav").style.height = "100%";
        }
        
        function closeNav() {
          document.getElementById("myNav").style.height = "0%";
        }
</script>
             
@endpush