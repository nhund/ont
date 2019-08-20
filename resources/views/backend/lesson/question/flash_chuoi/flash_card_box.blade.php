@if(isset($edit) && $edit)
	@foreach($question->child_cards as $child_cards)
		<div class="col-sm-12 flash_card_list box_question_d" data-count="{{ $child_cards->id }}" >
			<div class="delete_question" title="Xóa câu hỏi" data-id="{{ $child_cards->id }}" data-type="card-muti">
		      <i class="fa fa-remove" style="font-size:24px;color:red"></i>
		    </div>
			<div class="flas_card_parent @if(isset($data['feedback_question']) && $data['feedback_question'] == $child_cards->id ) border_feedback @endif">		
				@include('backend.lesson.question.flash_chuoi.flash_card_item',['count'=>$child_cards->id,'type'=>'parent','count_child'=>count($child_cards->child),'edit'=>$edit])		
			</div>
			<div class="flah_card_child">
				@if(isset($child_cards->child) && count($child_cards->child) > 0)
					@foreach($child_cards->child as $card_child_child)
						@include('backend.lesson.question.flash_chuoi.flash_card_item',['count'=>$child_cards->id,'type'=>'child','count_child'=>$card_child_child->id,'edit'=>$edit])
					@endforeach
				@endif
			</div>
			<div class="col-sm-12">
				<button type="button" class="btn btn-primary add_flash_card_child" data-count="{{ $child_cards->id }}" data-countchild = "1000000">Thêm flash card con</button>
			</div>
		</div>
	@endforeach
@else
	<div class="col-sm-12 flash_card_list box_question_d" data-count="{{ $count }}">
		<div class="delete_question" title="Xóa câu hỏi" data-id="">
			<i class="fa fa-remove" style="font-size:24px;color:red"></i>
		</div>
		<div class="flas_card_parent">		
			@include('backend.lesson.question.flash_chuoi.flash_card_item',['count'=>$count,'type'=>'parent','count_child'=>1])		
		</div>
		<div class="flah_card_child">
			
		</div>
		<div class="col-sm-12">
			<button type="button" class="btn btn-primary add_flash_card_child" data-count="{{ $count }}" data-countchild = "1">Thêm flash card con</button>
		</div>
	</div>
@endif
