@if(isset($edit) && $edit)
	<div class="box_flash_card_muti">
		<div class="form-group row flash_card_box">
			<div class="col-sm-12">Flash card</div>
			@include('backend.lesson.question.flash_chuoi.flash_card_box',['count'=>1,'type'=>'parent','edit'=>$edit])		
			<div class="form-group row box_add_btn">
				<div class="col-sm-12">
					<button type="button" class="btn btn-primary add_flash_card" data-count="{{ count($question->child_cards) }}">Thêm flash card</button>
				</div> 
			</div>
		</div>	
	</div>
@else 
	<div class="box_flash_card_muti">
		<div class="form-group row flash_card_box">
			<div class="col-sm-12">Flash card</div>
			@include('backend.lesson.question.flash_chuoi.flash_card_box',['count'=>1,'type'=>'parent'])		
			<div class="form-group row box_add_btn">
				<div class="col-sm-12">
					<button type="button" class="btn btn-primary add_flash_card" data-count="1">Thêm flash card</button>
				</div> 
			</div>
		</div>	
	</div>
@endif
