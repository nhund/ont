@if(isset($edit) && $edit)
<div class="col-sm-6 box_answer answer_1">
	@include('backend.lesson.question.trac_nghiem.trac_nghiem_item',['count'=>$count,'templateType'=>'ok','edit'=>$edit])
	@foreach($question_child->answers_errors as $question_error) 
		@include('backend.lesson.question.trac_nghiem.trac_nghiem_item',['count'=>$count,'count_child'=>$question_error->id,'templateType'=>'error','edit'=>$edit]) 
	@endforeach
</div>
@else 
<div class="col-sm-6 box_answer answer_1">
	@include('backend.lesson.question.trac_nghiem.trac_nghiem_item',['count'=>$count,'templateType'=>'ok']) 
	@include('backend.lesson.question.trac_nghiem.trac_nghiem_item',['count'=>$count,'count_child'=>1,'templateType'=>'error']) 
</div>
@endif