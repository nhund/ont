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
                    <div class="title">Đã học {{ $var['passLesson'] }}/{{ $var['totalLesson'] }} bài tập </div>
                    <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="70"
                            aria-valuemin="0" aria-valuemax="100" style="width:{{ $var['totalLesson'] > 0 ? ($var['passLesson']/$var['totalLesson'])*100 : 0 }}%">
                            </div>
                    </div>

                    <div class="btn-offer">
                        <a class="offer-course do_new " data-button="newLesson"
                           href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BAI_MOI]) }}"
                           title="Làm bài mới">
                            <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                            <div class="title">
                                <p class="content">Bài tập mới</p>
                            </div>
                        </a>
                        <a class="offer-course do_old" data-button="didLesson"
                           href="{{route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_CU]) }}"
                           title="Ôn tập câu cũ">
                            <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                            <div class="title">
                                <p class="content">Ôn câu cũ</p>
                            </div>
                        </a>
                        <a class="offer-course do_false" data-button="wrongQuestion"
                           href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_SAI]) }}">
                            <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                            <div class="title">
                                <p class="content" >Làm câu sai</p>
                            </div>
                        </a>
                        <a class="offer-course do_bookmark" data-button="bookmark"
                           href="{{route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BOOKMARK]) }}"
                           title="Làm câu bookmark">
                            <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/icon_mark.png') }}">
                            <div class="title">
                                <p class="content">Bookmark</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="box_content">
                    <div class="head">
                            <div class="topic">Chương trình</div>
                            <div class="topic_progress">Tiến độ</div>
                    </div>
                    <div class="body">
                        @foreach($var['lessons'] as $lesson)
                                <div class="title_body">
                                    @if($lesson->type == \App\Models\Lesson::EXAM)
                                        <a style="width: 92%; display: flex" class="exam-front name" onclick="reportExam(`{{$lesson->id}}`, `{{str_slug($lesson->name)}}`)" ><strong>{{ $lesson->name }}</strong></a>
                                        @if( $lesson->userExam && $lesson->exam->min_score <= $lesson->userExam->highest_score)
                                            <div class="topic_progress">
                                                <img src="{{ web_asset('public/images/course/icon/icon_check.png') }}">
                                            </div>
                                        @endif
                                    @else
                                        @if($lesson->level == \App\Models\Lesson::LEVEL_1)
                                            <strong><a href="{{route('user.lambaitap.detailLesson',['title'=>str_slug($lesson->name), 'id'=>$lesson->id])}}"> {{ $lesson->name }} </a></strong>

                                        @else
                                            <strong><a href="{{route('course.learn.level2',['title'=>str_slug($lesson->name),'course_id' =>$lesson->course_id, 'lesson_id'=>$lesson->id])}}"> {{ $lesson->name }} </a> </strong>
                                        @endif
                                    @endif
                                </div>
                                @if(isset($lesson->childs))
                                    @foreach($lesson->childs as $lesson_child)
                                        @if($lesson_child->level == \App\Models\Lesson::LEVEL_1)
                                            @if($lesson_child->is_exercise == \App\Models\Lesson::IS_EXERCISE)
                                                <div class="item-exercise">
                                                    @if($lesson_child->type == \App\Models\Lesson::LESSON)
                                                        <a href="#" onclick="reportLesson(`{{ $lesson_child->id }}`)" class="name ly_thuyet">{{ $lesson_child->name }}</a>
                                                        <div class="topic_progress">
                                                            @if($lesson_child->userLearn && $lesson_child->userLearn->turn_right > 0)
                                                                <img src="{{ web_asset('public/images/course/icon/icon_check.png') }}">
                                                            @else
                                                               {{$lesson_child->turn_right}} @if(isset($lesson_child->userLearnPass)) {{ number_format($lesson_child->userLearnPass) }} @else 0 @endif/{{ number_format($lesson_child->countQuestion) }}
                                                            @endif
                                                        </div>
                                                    @else
                                                        <a class="exam-front name" onclick="reportExam(`{{$lesson_child->id}}`, `{{str_slug($lesson_child->name)}}`)" >
                                                            {{ $lesson_child->name }}
                                                        </a>
                                                        @if($lesson_child->userExam && $lesson_child->exam->min_score <= $lesson_child->userExam->highest_score)
                                                            <div class="topic_progress">
                                                                <img src="{{ web_asset('public/images/course/icon/icon_check.png') }}">
                                                            </div>
                                                        @endif
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
           <p class="title" ><span data-lesson="name"></span></p>
           <div class="overlay-content row">
               <div class="description"  style="color: white">
                   <h3 data-lesson="des"></h3>
               </div>
           </div>
            <div class="overlay-content">
                <div class="total total-question col-xs-4 col-lg-3 col-md-3 col-sm-3">

                    <div class="title">
                    <p style="min-height: 70px;">Tổng số câu hỏi</p>
                    <p data-lesson="total-question"></p>
                    </div>
                    <i class="fa fa-circle circle" aria-hidden="true" style=" color: #2bd6fe;"></i>
                </div>
                <div class="total total-question-did col-xs-4 col-lg-3 col-md-3 col-sm-3">
                    <div class="title">
                        <p style="min-height: 70px;">Số câu đã làm</p>
                        <p data-lesson="question-did">10/<span style="font-size: 15px;"></span></p>
                    </div>
                    <i class="fa fa-circle circle" aria-hidden="true" style=" color: #fa7a1d;"></i>
                </div>
                <div class="total total-question-correct col-xs-4 col-lg-3 col-md-3 col-sm-3">
                    <div class="title">
                        <p style="min-height: 70px;">Trả lời chính xác</p>
                        <p data-lesson="question-correct"></p>
                    </div>
                    <i class="fa fa-circle circle" aria-hidden="true" style=" color: #fce747;"></i>
                </div>
            </div>
            <div class="overlay-footer footer-1">
                <a class="offer-course do-new col-xs-3 col-lg-2 col-md-2 col-sm-2" onclick="recommendationLesson(`{{str_slug($var['course']->name)}}`, `{{$var['course']->id}}`,`{{\App\Models\Question::LEARN_LAM_BAI_MOI}}`)"  title="Làm bài tập">
                    <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/sub_new.png') }}">
                    <div class="title ">
                        <p class="content">Làm bài mới</p>
                        <p data-sub-lesson="new"></p>
                    </div>
                </a>

                <a class="offer-course did-1 col-xs-3 col-lg-2 col-md-2 col-sm-2" onclick="recommendationLesson(`{{str_slug($var['course']->name)}}`, `{{$var['course']->id}}`,`{{\App\Models\Question::LEARN_LAM_CAU_CU}}`)"   title="Ôn tập câu cũ">
                    <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/sub_old.png') }}">
                    <div class="title">
                        <p class="content">Ôn tập câu cũ</p>
                        <p data-sub-lesson="old"></p>
                    </div>
                </a>

                <a class="offer-course do-false-1 col-xs-3 col-lg-2 col-md-2 col-sm-2" onclick="recommendationLesson(`{{str_slug($var['course']->name)}}`, `{{$var['course']->id}}`,`{{\App\Models\Question::LEARN_LAM_CAU_SAI}}`)"  title="Làm lại câu sai">
                    <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/sub_wrong.png') }}">
                    <div class="title">
                        <p class="content">Làm lại câu sai</p>
                        <p data-sub-lesson="wrong"></p>
                    </div>
                </a>

                <a class="offer-course  do-bookmark-1 col-xs-3 col-lg-2 col-md-2 col-sm-2"  onclick="recommendationLesson(`{{str_slug($var['course']->name)}}`, `{{$var['course']->id}}`,`{{\App\Models\Question::LEARN_LAM_BOOKMARK}}`)" title="Làm câu bookmark">
                    <img class="hidden-xs" src="{{ web_asset('public/images/course/icon/sub_bookmark.png') }}">
                    <div class="title">
                        <p class="content">Câu bookmark</p>
                        <p data-sub-lesson="bookmark"></p>
                    </div>
                </a>
            </div>
      </div>

      <div id="exam-modal" class="overlay" style="overflow-y:scroll">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav('exam-modal')">&times;</a>
            <p class="title" ><span data-exam="name"></span></p>
            <div class="overlay-content row">
                <div class="description" style="color: white">
                    <h3 data-exam="des"></h3>
                </div>
            </div>
          <div class="overlay-content">
              <div class="total total-question col-xs-3 col-lg-2 col-md-2 col-sm-3">
                  <div class="title">
                      <p>Tổng số câu</p>
                      <p data-exam="number_question"></p>
                  </div>
                  <i class="fa fa-circle circle" aria-hidden="true" style=" color: #2bd6fe;"></i>
              </div>
              <div class="total total-question-did col-xs-3 col-lg-2 col-md-2 col-sm-3">
                  <div class="title">
                      <p>Thời gian</p>
                      <p data-exam="minutes"></p>
                  </div>
                  <i class="fa fa-circle circle" aria-hidden="true" style=" color: #fa7a1d;"></i>
              </div>
              <div class="total total-question-correct col-xs-3 col-lg-2 col-md-2 col-sm-3">
                  <div class="title">
                      <p>Lượt làm lại</p>
                      <p data-exam="time_repeat"></p>
                  </div>
                  <i class="fa fa-circle circle" aria-hidden="true" style=" color: #fce747;"></i>
              </div>
              <div class="total min-score col-xs-3 col-lg-2 col-md-2 col-sm-3">
                  <div class="title">
                      <p>Điểm tối thiểu</p>
                      <p data-exam="min_score"></p>
                  </div>
                  <i class="fa fa-circle circle" aria-hidden="true" style=" color: #7BCDAB;"></i>
              </div>
          </div>

            <div class="overlay-footer footer-1">
                <a class="offer-course did-1 col-xs-4 col-lg-2 col-md-2 col-sm-2"  onclick="closeNav('exam-modal')">
                    <div style="text-align: left">
                        <p></p>
                        <p class="content" >Để sau</p>
                    </div>
                </a>
                <a class="offer-course do-false-1 col-xs-4 col-lg-2 col-md-2 col-sm-2" title="làm bài" id="data-exam-href" data-exam="href">
                    <div style="text-align: left">
                        <p></p>
                        <p class="content" >Làm ngay</p>
                    </div>
                </a>
                <a class="offer-course do-new col-xs-4 col-lg-2 col-md-2 col-sm-2" title="Bảng xếp hạng" id="data-exam-href" data-ranking="href">
                    <div style="text-align: left">
                        <p></p>
                        <p class="content" >Bảng xếp hạng</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
@stop
@push('js')
<script src='{{ web_asset('public/js/detail/bootstrap-rating.min.js') }}' type='text/javascript'></script>
<script src='{{ web_asset('public/js/learn/course_learn.js') }}' type='text/javascript'></script>

<script >
    function closeNav(id) {
          document.getElementById(id).style.height = "0%";
        }

        $(document).ready(function() {
            const courseId = $('input[name=course_id]').val();
            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name=csrf-token]').attr("content"),
                    'Authorization': localStorage.getItem('access_token'),
                },
                type: "GET",
                url: `/api/me/courses/${courseId}/fourSuggest`,
                success: function (data) {
                    if(data.code == 200){
                        $('[data-button]').each(function (i, ele) {
                            const type  = $(ele).data('button');
                            const noAction = data.data[type];
                            if(!noAction){
                                $(ele).addClass('no_action')
                            }
                        })
                    }
                }
            });
        });
</script>
             
@endpush