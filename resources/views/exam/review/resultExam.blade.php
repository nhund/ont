@extends('layoutCourse')
@push('css')
    <link href="{{ web_asset('public/css/course-learn.css') }}" rel="stylesheet" type="text/css">
    <style type="text/css">
        #box-wrapper {
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
        <input type="hidden" name="totalQuestion" value="{{$var['totalQuestion']}}">
        <input type="hidden" name="time_stop" value="{{$var['exam']->stop_time}}">
        <input type="hidden" name="time_stopped" value="{{$var['userExam']->turn_stop}}">
        <input type="hidden" name="lesson_id" value="{{$var['lesson']->id}}">
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
                                                @include('exam.review.baitapDienTu')
                                            @endif
                                            @if($question->type == \App\Models\Question::TYPE_TRAC_NGHIEM)
                                                @include('exam.review.baitapTracNghiem')
                                            @endif
                                            @if($question->type == \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN)
                                                @include('exam.review.baitapDienTuDoanVan')
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
                                            </div>
                                            <div class="row result-exam" id="result-exam"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
        const getExplain        = '{{ route('user.lambaitap.getExplain') }}';
        const book_mark_url     = '{{ route('user.question.bookMark') }}';
        let   reviewResults      = [];
    </script>
    <script src="{{ asset('/public/admintrator/assets/js/bootstrap-notify.min.js?ver=1') }}"></script>
    <script src='{{ web_asset('public/js/exam/reviewExam.js') }}' type='text/javascript'></script>
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
                   stopTime(userExam.turn_stop)
                   if (userExam.status_stop === 'Inactive') {
                       clearInterval(countInterval);
                       $('.pause-exam').css({'background-color': '#2d2e4d', 'opacity': 0.95, 'color':'#2d2e4d !important'});
                       $('.stop').html('<i class="fa fa-play" aria-hidden="true"></i> Tiếp tục')
                   } else {
                       clearInterval(countInterval);
                       $('.stop').html(' <i class="fa fa-pause"></i> Tạm dừng')
                       $('.pause-exam').removeAttr('style');
                   }
               }
           });
        }

        function stopTime(stoppedTime){
            const stopTime = parseInt($('input[name=time_stop]').val());
            const $stopTime  = $('.time-stop');
            console.log(stopTime, stoppedTime)
            $stopTime.html(stopTime- stoppedTime)
        }

        function intiExam(){

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

        function getResult() {
            const examId = $('input[name=lesson_id]').val();
            const url =  `/api/exam/${examId}/result-sort` ;
            $.ajax({
               headers: {
                   'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content"),
                   'Authorization': localStorage.getItem('access_token'),
               },
               type   : "GET",
               url    : url,
               data   : {},
               success: function (result) {
                   if (result.code === 200){
                       reviewResults = result.data;
                       reviewResult(reviewResults[0], 1);
                       checkButton($('[data-stt=0]'));
                   }
               }
           })
        }

        intiExam();
        getResult();

    </script>
@endpush
