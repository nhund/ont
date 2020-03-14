@if(isset($edit) && $edit)
	@include('backend.lesson.question.trac_nghiem_don.trac_nghiem_box',['edit'=>$edit])
@else
	@include('backend.lesson.question.trac_nghiem_don.trac_nghiem_box',['count'=>1])
@endif


