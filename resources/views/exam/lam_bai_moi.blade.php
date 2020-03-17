
@if($var['finish'])
    <div class="header-navigate clearfix mb15" style="background-color: #F87B54">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5 head_course head_flash_Card">
                    <div class="lesson_name do_new">
                        <img src="{{ web_asset('public/images/course/icon/icon-exam.png') }}">
                        <div class="name">
                            <div class="box_head">
                                <div title="{{ $var['lesson']->name }}" class="title">{{ $var['lesson']->name }}</div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                     aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="close_course">
                        @if($var['lesson']->level == \App\Models\Lesson::LEVEL_2)
                            <a style="background-color: #eb5757" href="{{ route('course.learn',['title'=>str_slug($var['course']->name),'course_id'=> $var['course']->id, 'lesson_id'=>$var['lesson']->id]) }}" class="fa fa-close"></a>
                        @else
                            <a style="background-color: #eb5757" href="{{ route('course.learn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id]) }}" class="fa fa-close"></a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="header-navigate clearfix mb15" style="background-color: #F87B54">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5 head_course head_flash_Card">
                    <div class="lesson_name do_new">
                        <img src="{{ web_asset('public/images/course/icon/icon-exam.png') }}">
                        <div class="name">
                            <div class="box_head">
                                <div title="{{ $var['lesson']->name }}" class="title">{{ $var['lesson']->name }}</div>
                                <div class="course_process">Đã làm
                                    <span class="count_question_done">0</span>/<span class="total_question">{{ count($var['questions']) }}</span>
                                </div>
                            </div>
                            <div class="progress" style="background: #eb5757">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70"
                                     aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="close_course">
                        @if($var['lesson']->level == \App\Models\Lesson::LEVEL_2)
                            <a style="background-color: #eb5757" href="{{ route('course.learn',['title'=>str_slug($var['course']->name),'course_id'=> $var['course']->id, 'lesson_id'=>$var['lesson']->id]) }}" class="fa fa-close"></a>
                        @else
                            <a style="background-color: #eb5757" href="{{ route('course.learn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id]) }}" class="fa fa-close"></a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
