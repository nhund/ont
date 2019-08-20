<div class="header-navigate clearfix mb15">
    <div class="container">
     <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5 head_course head_flash_Card">
       <div class="lesson_name do_new">
        <img src="{{ web_asset('public/images/course/icon/icon_bookmark_48.png') }}"> 
        <div class="name">   
          <div class="box_head">            
            <div class="title">Làm câu bookmark</div>
            <div class="course_process">Đã làm <span class="count_question_done">0</span>/<span class="total_question">{{ count($var['questions']) }}</span></div>
          </div>                                                         
          <div class="progress">
           <div class="progress-bar" role="progressbar" aria-valuenow="70"
           aria-valuemin="0" aria-valuemax="100" style="width:0%">
           <span class="sr-only"></span>
         </div>
       </div>
     </div>
   </div>
   <div class="close_course">
    <a href="{{ route('course.learn',['title'=>str_slug($var['course']->name),'id'=>$var['course']->id]) }}" class="fa fa-close"></a>   
  </div>
</div>
</div>
</div>
</div>
