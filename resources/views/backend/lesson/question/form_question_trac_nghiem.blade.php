@if(isset($edit) && $edit)
<div class="form-group row">
	<div class="col-sm-12">Gợi ý chung</div>
	<div class="col-sm-12">
		<div class="box_content_t">
			<textarea name="explain_tn_global" class="col-sm-12">{{ $question->explain_before }}</textarea>
			<div class="box_media">
            	@include('backend.lesson.question.options.action',['show_format_content'=>true])
          	</div>
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-sm-12">Giải thích chung</div>
	<div class="col-sm-12">
		<div class="box_content_t">
			<textarea name="interpret_tn_global" class="col-sm-12">{{ $question->interpret_all }}</textarea>
			<div class="box_media">
            	@include('backend.lesson.question.options.action',['show_format_content'=>true])
          	</div>
		</div>
	</div>
</div>
@foreach($question->childs as $question_child)
@include('backend.lesson.question.trac_nghiem.trac_nghiem_box',['count'=>$question_child->id,'edit'=>$edit])
@endforeach
<div class="form-group row box_add_btn">
	<div class="col-sm-12">
		<button type="button" class="btn btn-primary add_question" data-count="{{ count($question->childs) }}">Thêm câu hỏi</button>
	</div>
</div>
@else
<div class="form-group row">
	<div class="col-sm-12">Gợi ý chung</div>
	<div class="col-sm-12">
		<div class="box_content_t">
			<textarea name="explain_tn_global" class="col-sm-12"></textarea>
			<div class="box_media">
            	@include('backend.lesson.question.options.action',['show_format_content'=>true])
          	</div>
		</div>
	</div>
</div>
<div class="form-group row">
	<div class="col-sm-12">Giải thích chung</div>
	<div class="col-sm-12">
		<div class="box_content_t">
			<textarea name="interpret_tn_global" class="col-sm-12"></textarea>
			<div class="box_media">
            	@include('backend.lesson.question.options.action',['show_format_content'=>true])
          	</div>
		</div>
	</div>
</div>
@include('backend.lesson.question.trac_nghiem.trac_nghiem_box',['count'=>1])

<div class="form-group row box_add_btn">
	<div class="col-sm-12">
		<button type="button" class="btn btn-primary add_question" data-count="1">Thêm câu hỏi</button>
	</div>
</div>
@endif

