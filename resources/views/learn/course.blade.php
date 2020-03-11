@extends('layout')
@push('css')
   <link href="{{ web_asset('public/css/course-learn.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ web_asset('public/css/bootstrap-rating.css') }}" rel="stylesheet" type="text/css">
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
                   <li class="active"><span> {{ $var['course']->name }}</span></li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <section id="course_learn" class="clearfix">
       <input type="hidden" name="course_id" value="{{ $var['course']->id }}"> 
       <div class="container">
          <div class="row">             
              <h1 class="course_title">{{ $var['course']->name }}</h1>
             <div class="box_left col-lg-9 col-md-9 col-sm-8 col-xs-12">                
                <div class="box_head">
                    <div class="title">Đã học {{ $var['total_user_learn'] }}/{{ $var['total_question'] }} câu</div>
                    <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70"
                            aria-valuemin="0" aria-valuemax="100" style="width:{{ $var['total_question'] > 0 ? ($var['total_user_learn']/$var['total_question'])*100 : 0 }}%">                              
                            </div>
                    </div>

                    <div class="btn-offer">
                        <a class="offer-course do_new "
                           href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BAI_MOI]) }}"
                           title="Làm bài mới">
                            <img src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                            <div class="title">
                                <p class="content">Làm tập mới</p>
                            </div>
                        </a>
                        <a class="offer-course do_old  {{ $var['total_user_learn'] == false ? 'no_action' : '' }} "
                           href="{{ $var['total_user_learn'] == 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_CU]) }}"
                           title="Ôn tập câu cũ">
                            <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                            <div class="title">
                                <p class="content">Ôn câu cũ</p>
                            </div>
                        </a>
                        <a class="offer-course do_false  {{ $var['user_learn_error'] == 0 ? 'no_action' : '' }}"
                           href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_SAI]) }}">
                            <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                            <div class="title">
                                <p class="content" >Làm câu sai</p>
                            </div>
                        </a>
                        <a class="offer-course do_bookmark {{ $var['user_learn_bookmark'] == 0 ? 'no_action' : '' }}"
                           href="{{ $var['user_learn_bookmark'] == 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BOOKMARK]) }}"
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
                            <div class="topic_progress">Tiến độ</div>
                    </div>
                    <div class="body">
                        @foreach($var['lessons'] as $lesson)
                                <div class="title_body"><strong>
                                    @if($lesson->type == \App\Models\Lesson::EXAM)
                                        <a class="exam-front" onclick="reportExam(`{{$lesson->name}}`, `{{str_slug($lesson->name)}}`,`{{$lesson->description}}`,`{{$lesson->exam->total_question}}`,
                                                `{{$lesson->exam->repeat_time}}`, `{{$lesson->exam->min_score}}`, `{{$lesson->exam->minutes}}`, `{{$lesson->exam->lesson_id ?? ''}}`, `{{$lesson->userExam->turn ?? 0}}`)" >
                                            {{ $lesson->name }}
                                        </a>
                                    @else
                                        @if($lesson->level == \App\Models\Lesson::LEVEL_1)
                                            <a href="{{route('user.lambaitap.detailLesson',['title'=>str_slug($lesson->name), 'id'=>$lesson->id])}}"> {{ $lesson->name }} </a>
                                        @else
                                            <a href="{{route('course.learn.level2',['title'=>str_slug($lesson->name),'course_id' =>$lesson->course_id, 'lesson_id'=>$lesson->id])}}"> {{ $lesson->name }} </a>
                                        @endif
                                    @endif
                                    </strong>
                                </div>
                                @if(isset($lesson->childs))
                                    @foreach($lesson->childs as $lesson_child)
                                        @if($lesson_child->level == \App\Models\Lesson::LEVEL_1)
                                            @if($lesson_child->is_exercise == \App\Models\Lesson::IS_EXERCISE)
                                                <div class="item-exercise">
                                                    @if($lesson_child->type == \App\Models\Lesson::LESSON)
                                                        <a href="#" onclick="reportLesson(`{{ $lesson_child->id }}`)" class="name ly_thuyet">{{ $lesson_child->name }}</a>
                                                        <div class="topic_progress">
                                                            @if($lesson_child->turn_right > 1){
                                                                <img src="{{ web_asset('public/images/course/icon/icon_check.png') }}">
                                                            @else
                                                                @if(isset($lesson_child->userLearnPass)) {{ number_format($lesson_child->userLearnPass) }} @else 0 @endif/{{ number_format($lesson_child->countQuestion) }}
                                                            @endif
                                                        </div>
                                                    @else
                                                        <a class="exam-front" onclick="reportExam(`{{$lesson_child->name}}`, `{{str_slug($lesson_child->name)}}`,`{{$lesson_child->description}}`,`{{$lesson_child->exam->total_question}}`,
                                                                `{{$lesson_child->exam->repeat_time}}`, `{{$lesson_child->exam->min_score}}`, `{{$lesson_child->exam->minutes}}`, `{{$lesson_child->exam->lesson_id ?? ''}}`, `{{$lesson_child->userExam->turn ?? 0}}`)" >
                                                            {{ $lesson_child->name }}
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="item-exercise">
                                                    <a href="{{ route('user.lambaitap.lythuyet',['id'=>$lesson_child->id]) }}" class="name bai_tap">{{ $lesson_child->name }}</a>
                                                    <div class="topic_progress">
                                                        @if($lesson_child->lesson_ly_thuyet_pass)
                                                            <img src="{{ web_asset('public/images/course/icon/icon_check.png') }}">
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
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
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav('myNav')">&times;</a>
            <p class="title" data-lesson="name">Bài học</p>
            <div class="overlay-content row">
                <div class="total total-question">

                    <div class="title">
                    <p style="min-height: 70px;">Tổng số câu hỏi</p>
                    <p data-lesson="total-question">100</p>
                    </div>
                    <i class="fa fa-circle circle" aria-hidden="true" style=" color: #2bd6fe;"></i>
                </div>
                <div class="total total-question-did">
                    <div class="title">
                        <p style="min-height: 70px;">Số câu đã làm</p>
                        <p data-lesson="question-did">10/<span style="font-size: 15px;">100</span></p>
                    </div>
                    <i class="fa fa-circle circle" aria-hidden="true" style=" color: #fa7a1d;"></i>
                </div>
                <div class="total total-question-correct">
                    <div class="title">
                        <p style="min-height: 70px;">Số câu trả lời đúng</p>
                        <p data-lesson="question-correct">100</p>
                    </div>
                    <i class="fa fa-circle circle" aria-hidden="true" style=" color: #fce747;"></i>
                </div>
            </div>
            <div class="overlay-footer row footer-1">

                <a class="offer-course do-new" onclick="recommendationLesson(`{{str_slug($var['course']->name)}}`, `{{$var['course']->id}}`,`{{\App\Models\Question::LEARN_LAM_BAI_TAP}}`)"  title="Làm bài tập">
                    <img src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                    <div class="title ">
                        <p>Làm bài</p>
                        <p class="content">Làm bài tập</p>
                    </div>
                </a>

                <a class="offer-course did-1" onclick="recommendationLesson(`{{str_slug($var['course']->name)}}`, `{{$var['course']->id}}`,`{{\App\Models\Question::LEARN_LAM_CAU_CU}}`)"   title="Ôn tập câu cũ">
                    <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                    <div class="title">
                        <p>Đề xuất</p>
                        <p class="content">Ôn tập câu cũ</p>
                    </div>
                </a>
                <a class="offer-course do-false-1" onclick="recommendationLesson(`{{str_slug($var['course']->name)}}`, `{{$var['course']->id}}`,`{{\App\Models\Question::LEARN_LAM_CAU_SAI}}`)"  title="Làm lại câu sai">
                    <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                    <div class="title">
                        <p>Đề xuất</p>
                        <p class="content">Làm lại câu sai</p>
                    </div>
                </a>
                <a class="offer-course  do-bookmark-1"  onclick="recommendationLesson(`{{str_slug($var['course']->name)}}`, `{{$var['course']->id}}`,`{{\App\Models\Question::LEARN_LAM_BOOKMARK}}`)" title="Làm câu bookmark">
                    <img src="{{ web_asset('public/images/course/icon/icon_mark.png') }}">
                    <div class="title">
                        <p>Đề xuất</p>
                        <p class="content">Làm câu bookmark</p>
                    </div>
                </a>
            </div>
      </div>

      <div id="exam-modal" class="overlay" style="overflow-y:scroll">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav('exam-modal')">&times;</a>
            <p class="title" >Kiểm tra: <span data-exam="name"></span></p>
            <div class="overlay-content row">
                <div class="description ">
                    <p data-exam="des"></p>
                </div>
            </div>
          <div class="overlay-content row">
              <div class="total total-question">
                  <div class="title">
                      <p>Số câu</p>
                      <p data-exam="number_question"></p>
                  </div>
                  <i class="fa fa-circle circle" aria-hidden="true" style=" color: #2bd6fe;"></i>
              </div>
              <div class="total total-question-did">
                  <div class="title">
                      <p>Thời gian (Phút)</p>
                      <p data-exam="minutes"></p>
                  </div>
                  <i class="fa fa-circle circle" aria-hidden="true" style=" color: #fa7a1d;"></i>
              </div>
              <div class="total total-question-correct">
                  <div class="title">
                      <p>Số lần làm lại</p>
                      <p data-exam="time_repeat"></p>
                  </div>
                  <i class="fa fa-circle circle" aria-hidden="true" style=" color: #fce747;"></i>
              </div>
              <div class="total min-score">
                  <div class="title">
                      <p>Điểm tối thiểu</p>
                      <p data-exam="min_score"></p>
                  </div>
                  <i class="fa fa-circle circle" aria-hidden="true" style=" color: #7BCDAB;"></i>
              </div>
          </div>

            <div class="overlay-footer row footer-1">
                <a class="offer-course did-1"  onclick="closeNav('exam-modal')">
                    <div style="text-align: left">
                        <p></p>
                        <p class="content" >Để sau</p>
                    </div>
                </a>
                <a class="offer-course do-false-1" title="Làm lại câu sai" id="data-exam-href" data-exam="href">
                    <div style="text-align: left">
                        <p></p>
                        <p class="content" >Làm ngay</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
@stop
@push('js')
<script src='{{ web_asset('public/js/detail/bootstrap-rating.min.js') }}' type='text/javascript'></script>
<script src='{{ web_asset('public/js/learn/course_learn.js') }}' type='text/javascript'></script>

<script>
        function closeNav(id) {
          document.getElementById(id).style.height = "0%";
        }
</script>
             
@endpush