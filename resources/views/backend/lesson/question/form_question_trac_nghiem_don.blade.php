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
	@include('backend.lesson.question.trac_nghiem_don.trac_nghiem_box',['edit'=>$edit])
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
	@include('backend.lesson.question.trac_nghiem_don.trac_nghiem_box',['count'=>1])
@endif


