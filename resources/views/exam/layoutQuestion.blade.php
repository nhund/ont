@extends('layoutCourse')
@push('css')
<link href="{{ web_asset('public/css/course-learn.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
        #box-wrapper{
            background: #f2f3f5;
        }
    </style>
@endpush
@section('content')
    <div class="hoclythuyet type_flash_card type_do_new">
        @include('exam.lam_bai_moi')
        <input type="hidden" name="status_stop" value="{{$var['userExam']->status_stop ?? \App\Models\ExamUser::ACTIVE}}">
        <input type="hidden" name="still_time" value="{{$var['userExam']->still_time}}">
        <input type="hidden" name="until_number" value="{{$var['userExam']->until_number}}">
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
                                        <div class="time-exam text-center">
                                            <div class="text-score">
                                                 <span class="text-uppercase">
                                                    Thời gian
                                                </span>
                                            </div>
                                            <div class="time-score">
                                                <span class="count-down">00:00</span>
                                            </div>
                                        </div>
                                        <div class="action-exam">
                                            <span style="color: black">Bạn còn 2 lần dừng lại</span>
                                            <button class="btn text-uppercase stop" onclick="pauseExam(`{{$var['lesson']->id}}`)">
                                                @if($var['userExam'] && $var['userExam']->status_stop === \App\Models\ExamUser::INACTIVE)
                                                    <i class="fa fa-play" aria-hidden="true"></i> Tiếp tục
                                                @else
                                                    <i class="fa fa-pause"></i> Tạm dừng
                                                @endif
                                            </button>
                                            <a href="{{route('exam.start', ['title' =>$var['lesson']->name, 'id' =>$var['lesson']->id ])}}" class="btn text-uppercase replay"><i class="fa fa-repeat"></i> làm lại</a>
                                        </div>
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
                    </div>
                </div>
            </div>
        </section>
    </div>
@stop
@push('js')
<script type="text/javascript">
 const urlSubmitQuestion = '/api/exam/question/{question}';
 const getExplain = '{{ route('user.lambaitap.getExplain') }}';
 const book_mark_url = '{{ route('user.question.bookMark') }}';
</script>
<script src="{{ asset('/public/admintrator/assets/js/bootstrap-notify.min.js?ver=1') }}"></script>
<script src='{{ web_asset('public/js/exam/exam.js') }}' type='text/javascript'></script>
<script>
    let countInterval;

    function  pauseExam(examId){
        const status = $('input[name=status_stop]').val();
        const url = status === 'Inactive' ? `/api/exam/${examId}/restart` : `/api/exam/${examId}/stop`;

        $.ajax({
           headers: {
               'X-CSRF-Token': $('meta[name=csrf-token]').attr("content"),
               'Authorization': localStorage.getItem('access_token'),
           },
           type   : "POST",
           url    : url ,
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

               if (userExam.status_stop === 'Inactive') {
                   clearInterval(countInterval);
                   $('.stop').html('<i class="fa fa-play" aria-hidden="true"></i> Tiếp tục')
               } else {
                   clearInterval(countInterval);
                   countDown(userExam.still_time)
                   $('.stop').html(' <i class="fa fa-pause"></i> Tạm dừng')
               }
           }
        });
    }

    function countDown(timeLeft) {
        let countDownDate = new Date(timeLeft);

        // Update the count down every 1 second
        countInterval = setInterval(function() {
            // Get today's date and time
            let now = new Date().getTime();
            // Find the distance between now and the count down date
            let distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            if (hours > 0){
                $('.count-down').html(custom(hours) + ":" + custom(minutes) + ":" + custom(seconds))
            } else {
                $('.count-down').html(custom(minutes) + ":" + custom(seconds));
            }
            
            function custom(number) {
                return number > 9 ? number : '0'+number;
            }

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(countInterval);
                $('.count-down').html('<span style="color: red">Hết thời gian</span>');
            }
        }, 1000);
    }
    let timeLeft = $('input[name=still_time]').val();
    countDown(timeLeft);

    $('.question_type').hide();
    let until_number =  parseInt($('input[name=until_number]').val());
    $('.question_type.question_stt_' + until_number).show();
    let count_question_current = $('.hoclythuyet .course_process .count_question_done');
    count_question_current.text(until_number - 1);

</script>
@endpush