@extends('layoutCourse')
@push('css')
<link href="{{ web_asset('public/css/course-learn.css') }}" rel="stylesheet" type="text/css">
@endpush
@section('content')
<div class="hoclythuyet type_flash_card {{ isset($var['type']) ? $var['type'] : '' }} type_do_new">
    <audio preload="metadata" id="false-answer" style="display: none">
        <source src="{{ web_asset('/public/file/audio/False_Answer.wav') }}" type="audio/wav">
    </audio>
    <audio preload="metadata" id="correct-answer" style="display: none">
        <source src="{{ web_asset('/public/file/audio/Correct_Answer.wav') }}" type="audio/wav">
    </audio>
  @if(isset($var['type']) && $var['type'] == \App\Models\Question::LEARN_LAM_BOOKMARK)
      @include('learn.lambaitap.question_header.lam_bookmark')
  @endif  
  @if(isset($var['type']) && $var['type'] == \App\Models\Question::LEARN_LAM_CAU_CU)
      @include('learn.lambaitap.question_header.lam_cau_cu')
  @endif 
  @if(isset($var['type']) && $var['type'] == \App\Models\Question::LEARN_LAM_CAU_SAI)
      @include('learn.lambaitap.question_header.lam_cau_sai')
  @endif 
  @if(isset($var['type']) && $var['type'] == \App\Models\Question::LEARN_LAM_BAI_MOI)
      @include('learn.lambaitap.question_header.lam_bai_moi')
  @endif
  @if(isset($var['type']) && $var['type'] == \App\Models\Question::LEARN_LAM_BAI_TAP)
      @include('learn.lambaitap.question_header.lam_bai_moi')
  @endif

<section id="hoclythuyet" class="clearfix flash_card">
  <div class="container">
   <div class="row">                   
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5 box_do_learn">
      <input type="hidden" name="count_question" value="{{ $var['count_question'] }}">
     @foreach($var['questions'] as $key => $question)
     <div class="question_type question_stt_{{ $key + 1 }}" data-key="{{ $key + 1 }}">
      @if($question->type == \App\Models\Question::TYPE_DIEN_TU)                            
        @include('learn.lambaitap.baitapDienTu')  
      @endif
      @if($question->type == \App\Models\Question::TYPE_FLASH_SINGLE)
        @include('learn.lambaitap.flashCard')  
      @endif
      @if($question->type == \App\Models\Question::TYPE_FLASH_MUTI)
        @include('learn.lambaitap.flashCardChuoi')  
      @endif
      @if($question->type == \App\Models\Question::TYPE_TRAC_NGHIEM)
        @include('learn.lambaitap.baitapTracNghiem')  
      @endif
      @if($question->type == \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN)
        @include('learn.lambaitap.baitapDienTuDoanVan')  
      @endif
      @if($question->type == \App\Models\Question::TYPE_TRAC_NGHIEM_DON)
        @include('learn.lambaitap.baitapTracNghiemDon')
      @endif
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
 var submit_flashcard = '{{ route('user.lambaitap.questionSubmit') }}';
 var getExplain = '{{ route('user.lambaitap.getExplain') }}';
 var book_mark_url = '{{ route('user.question.bookMark') }}';

 const lessonId =`{{$var['lesson']->id ??''}}`;
 let  urlRecommendation = window.location.pathname+'?continue&lesson_id='+lessonId;

</script>
<script src='{{ web_asset('public/js/learn/course_question.js') }}' type='text/javascript'></script>
{{-- <script src="{{ web_asset('/public/admintrator/assets/js/player.js') }}"></script>     --}} 
<script>
    $(document).ready(function () {
      // $('.mediPlayer').mediaPlayer();
        $('.btn_continue').on('click',function () {
            if(!$(this).hasClass('finish')){
                location.href = urlRecommendation;

            }
        })
    });
</script>        
@endpush