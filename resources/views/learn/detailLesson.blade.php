@extends('layout')
@push('css')
   <link href="{{ web_asset('public/css/course-learn.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ web_asset('public/css/bootstrap-rating.css') }}" rel="stylesheet" type="text/css">
    <style>
        .border-lesson{
            border:0.09em solid;
            border-radius: 5px;
            display: flex;
            margin: 0;
        }
        .border-lesson .title{
            font-weight: bold;
        }
        .border-lesson .content{
            background: #f5f7f999;
            line-height: 1.9em;
        }
        .detail-lesson{
            margin: 10px 0;
        }
        .exercise-lesson .title, .exercise-lesson .score{
            color: #259bfe;
        }
        .theory-lesson .title, .theory-lesson .score{
            color: #fa8b00;
        }
        .exam-lesson .title, .exam-lesson .score{
            color: #fbbc06
        }

        .exercise-lesson{
            border-color: #259bfe2e;
        }
        .theory-lesson{
            border-color: #fa8b0030;
        }
        .exam-lesson{
            border-color: #fcdb4963
        }
        .exercise-lesson  .score{
           background: #259bfe2e;
        }
        .theory-lesson  .score{
            background: #fa8b0030;
        }
        .exam-lesson  .score{
            background: #fcdb4963;
        }

        .border-lesson .score{
            display: flex;
            align-items: center;
            padding: 10px;
        }
        .border-lesson .score span{
          font-size: 26px;
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
              <div class="box_left col-lg-9 col-md-9 col-sm-8 col-xs-12">
                  <h1 class="course_title">{{ $var['lessons']->name}}</h1>
              </div>
             <div class="box_left col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <div class="box_head">
                    <div class="title">Đã học {{$var['total_user_learn']}}/{{$var['total_question']}} câu</div>
                    <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70"
                            aria-valuemin="0" aria-valuemax="100" style="width: {{ $var['total_question'] > 0 ? ($var['total_user_learn']/$var['total_question'])*100 : 0 }}%" >
                            </div>
                    </div>

                    <div class="btn-offer">
                        <a class="offer-course do_new "  href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BAI_MOI, 'lesson_id' => $var['lessons']->id]) }}"
                           title="Làm bài mới">
                            <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                            <div class="title">
                                <p class="content">Làm tập mới</p>
                            </div>
                        </a>
                        <a class="offer-course do_old "
                           href="{{ 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_CU, 'lesson_id' => $var['lessons']->id]) }}"
                           title="Ôn tập câu cũ">
                            <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                            <div class="title">
                                <p class="content">Ôn câu cũ</p>
                            </div>
                        </a>
                        <a class="offer-course do_false "
                           href="{{ 0 ? 'javascript:void(0)' :  route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_SAI, 'lesson_id' => $var['lessons']->id]) }}">
                            <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                            <div class="title">
                                <p class="content" onclick="openNav()">Làm câu sai</p>
                            </div>
                        </a>
                        <a class="offer-course do_bookmark "
                           href="{{ 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BOOKMARK, 'lesson_id' => $var['lessons']->id]) }}"
                           title="Làm câu bookmark">
                            <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/icon_mark.png') }}">
                            <div class="title">
                                <p class="content">Bookmark</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="box_content">
                    <div class="body row">
                        @foreach($var['subLessons'] as $subLesson)
                            @if($subLesson->type == \App\Models\Lesson::LESSON && $subLesson->is_exercise == \App\Models\Lesson::IS_EXERCISE)
                                <div class="col-md-12 detail-lesson">
                                    <div class="border-lesson theory-lesson row">
                                        <div class="col-md-9 content">
                                            <div class="title">Bài tập</div>
                                            <div><a href="{{ route('user.lambaitap.question',['id'=>$subLesson->id,'title'=>str_slug($subLesson->name),'type'=>\App\Models\Question::LEARN_LAM_BAI_TAP, 'lesson_id' => $var['lessons']->id]) }}" class="name ly_thuyet">{{$subLesson->name}}</a></div>
                                        </div>
                                        <div  class="col-md-3 score"><span>{{$subLesson->userLearnPass}}</span>/{{$subLesson->countQuestion}} câu</div>
                                    </div>
                                </div>
                            @endif

                            @if($subLesson->type == \App\Models\Lesson::LESSON && $subLesson->is_exercise == \App\Models\Lesson::IS_DOC)
                                    <div class="col-md-12 detail-lesson">
                                        <div class="border-lesson exercise-lesson row">
                                            <div class="col-md-9 content">
                                                <div class="title">Lý thuyết</div>
                                                <div><a href="{{ route('user.lambaitap.lythuyet',['id'=>$subLesson->id, 'lesson_id' => $var['lessons']->id]) }}" class="name bai_tap">{{$subLesson->name}}</a></div>
                                            </div>
                                            <div  class="col-md-3 score">{{$subLesson->lesson_ly_thuyet_pass ? '100' : '0'}}%</div>
                                        </div>
                                    </div>
                            @endif
                            @if($subLesson->type == \App\Models\Lesson::EXAM)
                                    <div class="col-md-12 detail-lesson">
                                        <div class="border-lesson exam-lesson row">
                                            <div class="col-md-9 content">
                                                <div class="title">Kiểm tra</div>
                                                <div>{{$subLesson->name}}</div>
                                            </div>
                                            <div class="col-md-3 score"><span>120</span>/200 câu</div>
                                        </div>
                                    </div>
                            @endif
                        @endforeach



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
                    <a href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BAI_MOI, 'lesson_id' => $var['lessons']->id]) }}" title="Làm bài mới">
                        <img src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                    </a>
                    <p>Làm bài mới</p>
                </div>
                <div class="method do_old">
                    <a href="{{ 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_CU, 'lesson_id' => $var['lessons']->id]) }}" title="Ôn tập câu cũ">
                        <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                    </a>
                    <p>Ôn tập câu cũ</p>
                </div>
                <div class="method do_false">
                        <a href="{{ 0 ? 'javascript:void(0)' :  route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_SAI, 'lesson_id' => $var['lessons']->id]) }}" title="Làm lại câu sai">
                            <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                        </a>
                        <p>Làm lại câu sai</p>
                </div>
                <div class="method do_bookmark}">
                        <a href="{{ 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BOOKMARK, 'lesson_id' => $var['lessons']->id]) }}" title="Làm câu bookmark">
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