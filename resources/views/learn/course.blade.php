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
                            @if($var['user_learn_error']  > 0)                            
                                <a class="offer-course do_false" href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_SAI]) }}">
                                    <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                                    <div class="title">
                                        <p>Đề xuất</p>
                                        <p class="content">Làm lại câu sai</p>
                                    </div>
                                </a>
                            @else
                                @if(($var['total_user_learn']) == (int)$var['total_question'] && $var['total_user_learn'] > 0)
                                    <a class="offer-course do_old" href="{{ $var['total_user_learn'] == 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_CU]) }}" title="Ôn tập câu cũ">
                                    <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                                    <div class="title">
                                        <p>Đề xuất</p>
                                        <p class="content">Ôn tập câu cũ</p>
                                    </div>
                                    </a>
                               {{-- @else
                                    <a class="offer-course" href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BAI_MOI]) }}">
                                        <img src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                                        <div class="title">
                                            <p>Đề xuất</p>
                                            <p class="content">Làm bài mới</p>
                                        </div>
                                    </a>--}}
                                @endif

                            @endif

                                {{--<div class="course-learn-other" onclick="openNav()">
                                    Học kiểu khác
                                </div>--}}
                                <a class="offer-course do_new " href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BAI_MOI]) }}" title="Làm bài mới">
                                <img src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                                <div class="title">
                                    <p class="content">Làm bài mới</p>
                                </div>
                                </a>


                                <a class="offer-course do_old {{ $var['show_on_tap'] == false ? 'no_action' : '' }}" href="{{ $var['total_user_learn'] == 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_CU]) }}" title="Ôn tập câu cũ">
                                    <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                                    <div class="title">
                                        <p class="content">ôn tập câu cũ</p>
                                    </div>
                                </a>
                    </div>
                    <div  class="btn-offer block-tow">

                        <a class="offer-course do_false {{ $var['user_learn_error'] == 0 ? 'no_action' : '' }}" href="{{ $var['user_learn_error'] == 0 ? 'javascript:void(0)' :  route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_SAI]) }}" title="Làm lại câu sai">
                            <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                            <div class="title">
                                <p class="content">Làm lại câu sai</p>
                            </div>
                        </a>

                        <a class="offer-course do_bookmark {{ $var['user_learn_bookmark'] == 0 ? 'no_action' : '' }}" href="{{ $var['user_learn_bookmark'] == 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BOOKMARK]) }}" title="Làm câu bookmark">
                            <img src="{{ web_asset('public/images/course/icon/icon_mark.png') }}">
                            <div class="title">
                                <p class="content">Làm câu bookmark</p>
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
                    <div class="body">
                        @foreach($var['lessons'] as $lesson)
                                <div class="title_body">
                                    {{ $lesson->name }}
                                </div>                                
                                @if(isset($lesson->childs))
                                    @foreach($lesson->childs as $lesson_child)

                                        @if($lesson_child->is_exercise == \App\Models\Lesson::IS_EXERCISE)
                                            <div class="item-exercise">
                                            <a href="{{ route('user.lambaitap.question',['id'=>$lesson_child->id,'title'=>str_slug($lesson_child->name),'type'=>\App\Models\Question::LEARN_LAM_BAI_TAP]) }}" class="name ly_thuyet">{{ $lesson_child->name }}</a>
                                                <div class="count_learn">
                                                    <p>
                                                        @if(isset($lesson_child->userLearn->count))
                                                            {{ number_format($lesson_child->userLearn->count) }}
                                                        @else 
                                                            0
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="topic_progress">
                                                    @if(isset($lesson_child->userLearnPass)) {{ number_format($lesson_child->userLearnPass) }} @else 0 @endif/{{ number_format($lesson_child->countQuestion) }}
                                                </div>
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
          {{-- <div class="row course_footer">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-3 item">
                            <div class="btn-offer do_new" title="Làm bài tập mới">
                                    <a class="offer-course" href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>'lam-bai-moi']) }}">
                                        <img src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                                        <div class="title">
                                            <p>Đề xuất</p>
                                            <p class="content">Làm bài tập mới</p>
                                        </div>
                                    </a>                                       
                            </div> 
                    </div>
                    <div class="col-md-3 item">
                            <div class="btn-offer do_old {{ $var['total_user_learn'] == 0 ? 'no_action' : '' }}" title="Ôn tập câu cũ">
                                    <a class="offer-course" href="{{ $var['total_user_learn'] == 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>'lam-cau-cu']) }}">
                                            <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                                        <div class="title">
                                            <p>Đề xuất</p>
                                            <p class="content">Ôn tập câu cũ</p>
                                        </div>
                                    </a>                                       
                            </div> 
                    </div>
                    <div class="col-md-3 item">
                            <div class="btn-offer do_false {{ $var['user_learn_error'] == 0 ? 'no_action' : '' }}" title="Làm câu sai">
                                    <a class="offer-course" href="{{ $var['user_learn_error'] == 0 ? 'javascript:void(0)' :  route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>'lam-cau-sai']) }}">
                                            <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                                        <div class="title">
                                            <p>Đề xuất</p>
                                            <p class="content">Làm lại câu sai</p>
                                        </div>
                                    </a>                                       
                            </div> 
                    </div>
                    <div class="col-md-3 item">
                            <div class="btn-offer do_book_mark {{ $var['user_learn_bookmark'] == 0 ? 'no_action' : '' }}" title="làm câu bookmark">
                                    <a class="offer-course" href="{{ $var['user_learn_bookmark'] == 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>'lam-bookmark']) }}">
                                            <img src="{{ web_asset('public/images/course/icon/icon_mark.png') }}">
                                        <div class="title">
                                            <p>Đề xuất</p>
                                            <p class="content">làm câu bookmark</p>
                                        </div>
                                    </a>                                       
                            </div> 
                    </div>
                <div>    
          </div> --}}
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
                <div class="method do_old {{ $var['show_on_tap'] == false ? 'no_action' : '' }} ">
                    <a href="{{ $var['total_user_learn'] == 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_CU]) }}" title="Ôn tập câu cũ">
                        <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                    </a>
                    <p>Ôn tập câu cũ</p>
                </div>
                <div class="method do_false {{ $var['user_learn_error'] == 0 ? 'no_action' : '' }}">
                        <a href="{{ $var['user_learn_error'] == 0 ? 'javascript:void(0)' :  route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_SAI]) }}" title="Làm lại câu sai">
                            <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                        </a>
                        <p>Làm lại câu sai</p>
                </div>
                <div class="method do_bookmark {{ $var['user_learn_bookmark'] == 0 ? 'no_action' : '' }}">
                        <a href="{{ $var['user_learn_bookmark'] == 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BOOKMARK]) }}" title="Làm câu bookmark">
                            <img src="{{ web_asset('public/images/course/icon/icon_mark.png') }}">
                        </a>
                        <p>Làm câu bookmark</p>
                </div>
            </div>
            <div class="overlay-footer">
                @if($var['user_learn_error']  > 9) 
                    <a class="offer-course do_false" href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_SAI]) }}" title="Làm lại câu sai">
                        <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                        <div class="title">
                            <p>Đề xuất</p>
                            <p class="content">Làm lại câu sai</p>
                        </div>
                    </a>
                @else
                    @if(($var['total_user_learn']) == (int)$var['total_question'])
                        <a class="offer-course do_old" href="{{ $var['total_user_learn'] == 0 ? 'javascript:void(0)' : route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_CU]) }}" title="Ôn tập câu cũ">
                                    <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
                                    <div class="title">
                                        <p>Đề xuất</p>
                                        <p class="content">Ôn tập câu cũ</p>
                                    </div>
                                    </a>
                    @else
                    <a class="offer-course" href="{{ route('course.courseTypeLearn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id,'type'=>\App\Models\Question::LEARN_LAM_BAI_MOI]) }}" title="Làm bài mới">
                            <img src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                            <div class="title-p">
                                <p>Đề xuất</p>
                                <p class="content">Làm bài mới</p>
                            </div>
                    </a>
                    @endif
                @endif    
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