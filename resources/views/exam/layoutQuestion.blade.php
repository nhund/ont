@extends('layoutCourse')
@push('css')
    <link href="{{ web_asset('public/css/course-learn.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
        #box-wrapper {
            background: #f2f3f5;
        }
        .box_do_learn{
            position: relative;
        }
        .overlay{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
            opacity: 1;
            background-color: #fcfaf2; /*dim the background*/
            display: none;
        }
        .overlay-show{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pause-exam :hover{
            color: #35c818 !important;
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <div class="hoclythuyet type_flash_card type_do_new">
        @include('exam.lam_bai_moi')
        <input type="hidden" name="status_stop" value="{{$var['userExam']->status_stop ?? \App\Models\ExamUser::ACTIVE}}">
        <input type="hidden" name="still_time" value="{{$var['userExam']->still_time}}">
        <input type="hidden" name="until_number" value="{{$var['userExam']->until_number}}">
        <input type="hidden" name="totalQuestion" value="{{$var['totalQuestion']}}">
        <input type="hidden" name="time_stop" value="{{$var['exam']->stop_time}}">
        <input type="hidden" name="time_stopped" value="{{$var['userExam']->turn_stop}}">
        <input type="hidden" name="lesson_id" value="{{$var['lesson']->id}}">

        @if(!$var['finish'])
            <section id="hoclythuyet" class="clearfix flash_card">
                <div class="container container-exam">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5 box_do_learn">
                            <input type="hidden" name="count_question" value="{{ count($var['questions']) }}">
                            @foreach($var['questions'] as $key => $question)
                                <div class="question_type question_stt_{{ $key + 1 }}" data-key="{{ $key + 1 }}">
                                    <div class="row">
                                        <div class="col-md-10">
                                            @if($question->type == \App\Models\Question::TYPE_DIEN_TU)
                                                @include('exam.baitapDienTu')
                                            @endif
                                            @if($question->type == \App\Models\Question::TYPE_TRAC_NGHIEM)
                                                @include('exam.baitapTracNghiem')
                                            @endif
                                            @if($question->type == \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN)
                                                @include('exam.baitapDienTuDoanVan')
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <div class="time-exam text-center row">
                                                <div class="text-score">
                                                     <span class="text-uppercase">
                                                        Thời gian
                                                    </span>
                                                </div>
                                                <div class="time-score">
                                                    <span class="count-down">00:00</span>
                                                </div>
                                            </div>
                                            <div class="action-exam row">
                                                <span style="color: black">Còn <span class="time-stop"></span> lần dừng lại</span>
                                                <button class="btn text-uppercase stop" onclick="pauseExam(`{{$var['lesson']->id}}`)">
                                                    @if($var['userExam'] && $var['userExam']->status_stop === \App\Models\ExamUser::INACTIVE)
                                                        <i class="fa fa-play" aria-hidden="true"></i> Tiếp tục
                                                    @else
                                                        <i class="fa fa-pause"></i> Tạm dừng
                                                    @endif
                                                </button>
                                                <a href="{{route('exam.finish', ['title' =>str_slug($var['lesson']->name), 'id' =>$var['lesson']->id ])}}" class="btn text-uppercase replay"><i class="fa fa-arrows"></i> Nộp bài</a>
                                            </div>
                                            <div class="row result-exam" id="result-exam"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @include('learn.feedback.popup_feedback')
                            <div class="question_type box_finish question_stt_{{ count($var['questions']) + 1 }}" data-key="{{ count($var['questions']) + 1 }}">
                                @if(isset($var['parentLesson']))
                                    <a href="{{ route('user.lambaitap.detailLesson',['title'=>str_slug($var['parentLesson']->name ?? ''),'id'=> $var['parentLesson']->id]) }}" class="btn btn_finish">Hoàn thành</a>
                                @else
                                    <a href="{{ route('course.learn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id]) }}" class="btn btn_finish">Hoàn thành</a>
                                @endif
                            </div>
                            <div class="overlay pause-exam"> <a onclick="pauseExam(`{{$var['lesson']->id}}`)"><i class="fa fa-play fa-4x"></i></a></div>
                        </div>

                    </div>
                </div>
            </section>
        @else
            <section id="hoclythuyet" style="background: #35365e; min-height: 100vh;" class="clearfix flash_card">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-offset-2 col-lg-8 col-md-8 col-sm-8 col-xs-8 pd5 box_do_learn"
                             style="background: #35365e">
                            <div class="ket-qua">
                                <div class="congratulation {{$var['userExam']->score >= $var['exam']->min_score ? 'passed' : ''}}">
                                    @if($var['userExam']->score >= $var['exam']->min_score)
                                        <P class="title"><strong>Chúc mừng bạn</strong></P>
                                        <P class="title"><strong>ĐÃ VƯỢT QUA BÀI KIỂM TRA</strong></P>
                                    @else
                                        <P class="title"><strong>Bạn <span class="score-text">không</span> vượt qua bài kiểm tra</strong></P>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6 score-1">
                                            <h1><strong class="score">{{$var['userExam']->score}}</strong></h1>
                                        </div>
                                        <div class="col-md-6 title-score">
                                            <h2><span class="score-text"><strong>Điểm</strong></span></h2>
                                            <span><strong class="minute-1">{{ $var['userExam']->doing_time}}  Phút</strong></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="competition ">
                                    <table class="table">
                                        <tbody>
                                        @foreach($var['ranks'] as $key => $rank)
                                            <tr>
                                                <td>{{$key + 1}}</td>
                                                <td style="text-align: left"><img width="28" src="{{$rank->user->avatar_full ?? asset(env('APP_URL').'public/images/avatar-default.png')}}">&nbsp;
                                                    <span>{{$rank->user->name_full ?? 'Ẩn danh'}}</span>
                                                </td>
                                                <td>{{$rank->highest_score}} Điểm</td>
                                                <td>{{$rank->doing_time}} Phút</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="review-result">
                                    <a  href="{{ route('course.learn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id]) }}" class="btn-default btn" >Thoát</a> <a href="{{route('exam.result', ['title' => str_slug($var['lesson']->name), 'id'=>$var['lesson']->id ])}}" class="btn btn-orange">Xem lại bài thi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

    </div>
@stop
@push('js')
    <script type="text/javascript">
        const urlSubmitQuestion = '/api/exam/question/{question}';
        const getExplain        = '{{ route('user.lambaitap.getExplain') }}';
        const book_mark_url     = '{{ route('user.question.bookMark') }}';
    </script>
    <script src="{{ asset('/public/admintrator/assets/js/bootstrap-notify.min.js?ver=1') }}"></script>
    <script src='{{ web_asset('public/js/exam/exam.js') }}' type='text/javascript'></script>
    <script>
        let countInterval;
        let resultExam;

        function pauseExam(examId) {
            const status = $('input[name=status_stop]').val();
            const url    = status === 'Inactive' ? `/api/exam/${examId}/restart` : `/api/exam/${examId}/stop`;

            $.ajax({
                       headers: {
                   'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content"),
                   'Authorization': localStorage.getItem('access_token'),
               },
               type   : "POST",
               url    : url,
               data   : {},
               success: function (result) {
                   if (result.code !== 200) {
                       $.notify({
                            icon   : 'fa fa-warning',
                            title  : 'Lỗi! ',
                            message: result.message
                        }, {
                            element  : 'body',
                            type     : "danger",
                            placement: {
                                from : "top",
                                align: "center"
                            },
                            z_index  : 9999,
                            delay    : 3000,
                            timer    : 1000,
                        });
                       return false;
                   }

                   let userExam = result.data;
                   $('input[name=status_stop]').val(userExam.status_stop);
                   stopTime(userExam.turn_stop);
                   if (userExam.status_stop === 'Inactive') {
                       clearInterval(countInterval);
                       $('.pause-exam').addClass('overlay-show');
                       $('.stop').html('<i class="fa fa-play" aria-hidden="true"></i> Tiếp tục')
                   } else {
                       clearInterval(countInterval);
                       countDown(userExam.still_time)
                       $('.stop').html(' <i class="fa fa-pause"></i> Tạm dừng');
                       $('.pause-exam').removeClass('overlay-show');
                   }
               }
           });
        }

        function countDown(timeLeft) {

            const status = $('input[name=status_stop]').val();
            if (status === 'Inactive') {
                $('.pause-exam').addClass('overlay-show');
                $('.count-down').html('<span style="color: red">Đang tạm dừng</span>');
                return false;
            }
            let countDownDate = new Date(timeLeft);

            console.log(timeLeft, countDownDate, 99999999999999)
            // Update the count down every 1 second
            countInterval = setInterval(function () {
                // Get today's date and time
                let now      = new Date().getTime();
                // Find the distance between now and the count down date
                let distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                let hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                if (hours > 0) {
                    $('.count-down').html(custom(hours) + ":" + custom(minutes) + ":" + custom(seconds))
                } else {
                    $('.count-down').html(custom(minutes) + ":" + custom(seconds));
                }

                function custom(number) {
                    return number > 9 ? number : '0' + number;
                }

                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(countInterval);
                    $('.count-down').html('<span style="color: red">Hết fff thời gian</span>');
                }
            }, 1000);
        }

        function stopTime(stoppedTime){
            const stopTime = parseInt($('input[name=time_stop]').val());
            const $stopTime  = $('.time-stop');
            console.log(stopTime, stoppedTime)
            $stopTime.html(stopTime- stoppedTime)
        }

        function intiExam(){
            countDown($('input[name=still_time]').val());
            stopTime(parseInt($('input[name=time_stopped]').val()));
            $('.question_type').hide();
            let until_number = parseInt($('input[name=until_number]').val());
            $('.question_type.question_stt_' + until_number).show();
            $('.hoclythuyet .course_process .count_question_done').text(until_number - 1);

            const exam_id = $('input[name=lesson_id]').val();
            $.ajax({
               headers: {
                   'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content"),
                   'Authorization': localStorage.getItem('access_token'),
               },
               type   : "GET",
               url    : `/api/exam/${exam_id}/result`,
               data   : {},
               success: function (result) {
                   if (result.code === 200 && result.data) {
                       showAnswers(resultExam = result.data);
                   }
               }
            });
        }
        intiExam();

    </script>
@endpush
