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
                        <span>80 : 08</span>
                   </div>
                </div>
                <div class="action-exam">
                    <span style="color: black">Bạn còn 2 lần dừng lại</span>
                    <button class="btn text-uppercase stop"><i class="fa fa-pause"></i> tạm dừng</button>
                    <button class="btn text-uppercase stop"><i class="fa fa-play" aria-hidden="true"></i> tạm dừng</button>
                    <button class="btn text-uppercase replay"><i class="fa fa-repeat"></i> làm lại</button>
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
<script src='{{ web_asset('public/js/exam/exam.js') }}' type='text/javascript'></script>
{{-- <script src="{{ web_asset('/public/admintrator/assets/js/player.js') }}"></script>     --}}
<script>
    $(document).ready(function () {
      // $('.mediPlayer').mediaPlayer();
  });
</script>
@endpush