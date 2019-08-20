@if($course->and_date > 0 &&  $course->and_date < time())
  <div class="process_title end_date flexbox-content text-left">
    Đã hết hạn
  </div>
@else
  @if($course->status == \App\Models\UserCourse::STATUS_APPROVAL)
    <div class="process_title end_date flexbox-content text-left">
      Chờ phê duyệt
    </div>
  @else 
    <div class="process_title flexbox-content text-left">
      @if(isset($course->process_percent))
        Tiến độ học : <span class="learn_percent">{{ $course->process_percent }}%</span>
      @endif      
    </div>
    <div class="sugges_learn flexbox-content text-right">
      @if($course->user_question_log_true == $course->question_count && $course->question_count > 0)
        <a class="offer-course do_old" href="{{ route('course.courseTypeLearn',['title'=>str_slug($course->course->name),'id'=>$course->course->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_CU]) }}">
          <img src="{{ web_asset('public/images/course/icon/icon_cau_cu.png') }}">
          <div class="title">
            <p>Đề xuất</p>
            <p class="content">Ôn tập câu cũ</p>
          </div>
        </a>
      @else 
        @if($course->user_learn_error > 9)
                <a class="offer-course do_false" href="{{ route('course.courseTypeLearn',['title'=>str_slug($course->course->name),'id'=>$course->course->id,'type'=>\App\Models\Question::LEARN_LAM_CAU_SAI]) }}">
                  <img src="{{ web_asset('public/images/course/icon/icon_cau_sai.png') }}">
                  <div class="title">
                    <p>Đề xuất</p>
                    <p class="content">Làm lại câu sai</p>
                  </div>
                </a>
                @else
                  <a class="offer-course do_new" href="{{ route('course.courseTypeLearn',['title'=>str_slug($course->course->name),'id'=>$course->course->id,'type'=>'lam-bai-moi']) }}">
                    <img src="{{ web_asset('public/images/course/icon/icon_bt_moi.png') }}">
                    <div class="title">
                      <p>Đề xuất</p>
                      <p class="content">Làm bài mới</p>
                    </div>
                  </a>
            @endif 
      @endif      
    </div>     
  @endif 

@endif  
