@if(isset($edit) && $edit)
	{{-- cap nhật --}}
	@if($type == 'child')
		<div class="box_question_flash_chuoi box_question_d 1 @if(isset($data['feedback_question']) && $data['feedback_question'] == $card_child_child->id ) border_feedback @endif">
			<div class="delete_question" title="Xóa câu hỏi" data-id="{{ $card_child_child->id }}" data-type="card-muti">
		      <i class="fa fa-remove" style="font-size:24px;color:red"></i>
		    </div>
			<div class="form-group row ">
			<div class="col-sm-12">Nội dung mặt trước</div>
			<div class="col-sm-12 input_question">
				<div class="box_content box_content_t">
					<textarea name="question_child[{{ $count }}][{{ $count_child }}]" class="col-sm-12" placeholder="Nội dung mặt trước">{{ $card_child_child->question }}</textarea>
					<div class="box_media">  
						<div class="box_audio @if(!empty($card_child_child->audio_question)) show @endif">
							<div class="mediPlayer">
								<audio class="listen" preload="none" data-size="50" src="{{ web_asset($card_child_child->audio_question) }}"></audio>
							</div>
							<input type="hidden" name="audio_card_question_child[{{ $count }}][{{ $count_child }}]" class="input_audio" value="{{ $card_child_child->audio_question }}">
						</div>                  
						@include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-12">Nội dung mặt sau</div>
			<div class="col-sm-12 input_question">
				<div class="box_content box_content_t">
					<textarea name="card_question_after_child[{{ $count }}][{{ $count_child }}]" class="col-sm-12" placeholder="Nội dung mặt sau">{{ $card_child_child->question_after }}</textarea>
					<div class="box_media">  
						<div class="box_audio @if(!empty($card_child_child->audio_question_after)) show @endif">
							<div class="mediPlayer">
								<audio class="listen" preload="none" data-size="50" src="{{ web_asset($card_child_child->audio_question_after) }}"></audio>
							</div>
							<input type="hidden" name="audio_card_question_after_child[{{ $count }}][{{ $count_child }}]" class="input_audio" value="{{ $card_child_child->audio_question_after }}">
						</div>                  
						@include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 flash_card_item">
			<div class="form-group row img_item">
				<div class="image_box" style="@if(!empty($card_child_child->img_before)) display:block; @endif">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
						<img class="img_before_child img_before_child_{{ $count }}_{{ $count_child }} @if(!empty($card_child_child->img_before)) show @endif" src="{{ asset($card_child_child->img_before) }}">
						<input type="hidden" name="img_before_child[{{ $count }}][{{ $count_child }}]" class="input_img_before_{{ $count }}_{{ $count_child }}" value="{{ $card_child_child->img_before }}">
				</div>
				<input class="upload_flash_card" type="file" name="image_flash" title=" "/>
				{{-- <button class="flash_img_upload btn_img_before_{{ $count }}_{{ $count_child }}" style="font-size:24px" data-postion="before" data-type="child" data-count="{{ $count }}_{{ $count_child }}">Tải ảnh <i class="fa fa-upload"></i></button> --}}
				
				<div class="col-sm-1">Gợi ý</div>
				<div class="col-sm-12">
					<div class="box_content box_content_t">
						<textarea name="explain_before_child[{{ $count }}][{{ $count_child }}]" class="col-sm-12">{{ $card_child_child->explain_before }}</textarea>
						<div class="box_media">  								                
								@include('backend.lesson.question.options.action',['show_format_content'=>true])
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row img_item">
				<div class="image_box" style="@if(!empty($card_child_child->img_after)) display:block; @endif">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
						<img class="img_after_child img_after_child_{{ $count }}_{{ $count_child }} @if(!empty($card_child_child->img_after)) show @endif"  src="{{ asset($card_child_child->img_after) }}">
						<input type="hidden" name="img_after_child[{{ $count }}][{{ $count_child }}]" class="input_img_after_{{ $count }}_{{ $count_child }}" value="{{ $card_child_child->img_after }}">
				</div>
				<input class="upload_flash_card" type="file" name="image_flash" title=" "/>
				{{-- <button class="flash_img_upload btn_img_after_{{ $count }}_{{ $count_child }}" style="font-size:24px" data-postion="after" data-type="child" data-count="{{ $count }}_{{ $count_child }}">Tải ảnh <i class="fa fa-upload"></i></button> --}}
				
				<div class="col-sm-1">Gợi ý</div>
				<div class="col-sm-12">
					<div class="box_content box_content_t">
						<textarea name="explain_after_child[{{ $count }}][{{ $count_child }}]" class="col-sm-12">{{ $card_child_child->explain_after }}</textarea>				
						<div class="box_media">  								                
								@include('backend.lesson.question.options.action',['show_format_content'=>true])
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>

	@else
		<div class="">	
			<div class="form-group row">
				<div class="col-sm-12">Nội dung mặt trước</div>
				<div class="col-sm-12 input_question">
					<div class="box_content box_content_t">
						<textarea name="card_question[{{ $count }}]" class="col-sm-12" placeholder="Nội dung mặt trước">{{ $child_cards->question }}</textarea>
						<div class="box_media">  
							<div class="box_audio @if(!empty($child_cards->audio_question)) show @endif">
								<div class="mediPlayer">
									<audio class="listen" preload="none" data-size="50" src="{{ web_asset($child_cards->audio_question) }}"></audio>
								</div>
								<input type="hidden" name="audio_card_question[{{ $count }}]" class="input_audio" value="{{ $child_cards->audio_question }}">
							</div>                  
							@include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-12">Nội dung mặt sau</div>
				<div class="col-sm-12 input_question">
					<div class="box_content box_content_t">
						<textarea name="card_question_after[{{ $count }}]" class="col-sm-12" placeholder="Nội dung mặt sau">{{ $child_cards->question_after }}</textarea>
						<div class="box_media">  
							<div class="box_audio @if(!empty($child_cards->audio_question_after)) show @endif">
								<div class="mediPlayer">
									<audio class="listen" preload="none" data-size="50" src="{{ web_asset($child_cards->audio_question_after) }}"></audio>
								</div>
								<input type="hidden" name="audio_card_question_after[{{ $count }}]" class="input_audio" value="{{ $child_cards->audio_question_after }}">
							</div>                  
							@include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-sm-12 flash_card_item">
				<div class="form-group row img_item">
					<div class="image_box" style="@if(!empty($child_cards->img_before)) display:block; @endif">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
						<img class="img_flash img_before img_before_{{ $count }} @if(!empty($child_cards->img_before)) show @endif" src="{{ asset($child_cards->img_before) }}">
						<input type="hidden" name="card_img_before[{{ $count }}]" class="input_img_before_{{ $count }}" value="{{ $child_cards->img_before }}">
					</div>
					<input class="upload_flash_card" type="file" name="image_flash" title=" "/>
					{{-- <button class="flash_img_upload btn_img_before_{{ $count }}" data-postion="before" data-type="parent" data-count="{{ $count }}" style="font-size:24px">Tải ảnh <i class="fa fa-upload"></i></button> --}}
					
					<div class="col-sm-1">Gợi ý</div>
					<div class="col-sm-12">
						<div class="box_content box_content_t">
							<textarea name="card_explain[{{ $count }}][before]" class="col-sm-12">{{ $child_cards->explain_before }}</textarea>
							<div class="box_media">  								                
								@include('backend.lesson.question.options.action',['show_format_content'=>true])
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row img_item">
					<div class="image_box" style="@if(!empty($child_cards->img_after)) display:block; @endif">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
						<img class="img_flash img_after img_after_{{ $count }} @if(!empty($child_cards->img_after)) show @endif" src="{{ asset($child_cards->img_after) }}">
						<input type="hidden" name="card_img_after[{{ $count }}]" class="input_img_after_{{ $count }}" value="{{ $child_cards->img_after }}">
					</div>
					<input class="upload_flash_card" type="file" name="image_flash" title=" "/>
					{{-- <button class="flash_img_upload btn_img_after_{{ $count }}"  data-postion="after" data-type="parent" data-count="{{ $count }}" style="font-size:24px">Tải ảnh <i class="fa fa-upload"></i></button> --}}
					
					<div class="col-sm-1">Gợi ý</div>
					<div class="col-sm-12">
						<div class="box_content box_content_t">
							<textarea name="card_explain[{{ $count }}][after]" class="col-sm-12">{{ $child_cards->explain_after }}</textarea>
							<div class="box_media">  								                
								@include('backend.lesson.question.options.action',['show_format_content'=>true])
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif
@else 
{{-- Thêm mới --}}
	@if($type == 'child')
		{{-- template giao diện con --}}
		<div class="box_question_flash_chuoi box_question_d">
			<div class="delete_question" title="Xóa câu hỏi" data-id="">
		      <i class="fa fa-remove" style="font-size:24px;color:red"></i>
		    </div>
			<div class="form-group row">
				<div class="col-sm-12">Nội dung mặt trước</div>
				<div class="col-sm-12 input_question">
					<div class="box_content box_content_t">
						<textarea name="question_child[{{ $count }}][{{ $count_child }}]" class="col-sm-12" placeholder="Nội dung mặt trước"></textarea>
						<div class="box_media">  
							<div class="box_audio">
								<div class="mediPlayer">
									<audio class="listen" preload="none" data-size="50" src=""></audio>
								</div>
								<input type="hidden" name="audio_card_question_child[{{ $count }}][{{ $count_child }}]" class="input_audio">
							</div>                  
							@include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-12">Nội dung mặt sau</div>
				<div class="col-sm-12 input_question">
					<div class="box_content box_content_t">
						<textarea name="card_question_after_child[{{ $count }}][{{ $count_child }}]" class="col-sm-12" placeholder="Nội dung mặt sau"></textarea>
						<div class="box_media">  
							<div class="box_audio">
								<div class="mediPlayer">
									<audio class="listen" preload="none" data-size="50" src=""></audio>
								</div>
								<input type="hidden" name="audio_card_question_after_child[{{ $count }}][{{ $count_child }}]" class="input_audio">
							</div>                  
							@include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
						</div>
					</div>
				</div>
			</div>	
			<div class="col-sm-12 flash_card_item">
				<div class="form-group row img_item">
					<div class="image_box">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
						<img class="img_before_child img_before_child_{{ $count }}_{{ $count_child }} " src="">
						<input type="hidden" name="img_before_child[{{ $count }}][{{ $count_child }}]" class="input_img_before_{{ $count }}_{{ $count_child }}">
					</div>
					<input class="upload_flash_card" type="file" name="image_flash" title=" "/>
					{{-- <button onclick="showImageUploadFlashCard(this)" class="flash_img_upload btn_img_before_{{ $count }}_{{ $count_child }}" style="font-size:24px" data-postion="before" data-type="child" data-count="{{ $count }}_{{ $count_child }}">Tải ảnh <i class="fa fa-upload"></i></button>
					 --}}
					<div class="col-sm-1">Gợi ý</div>
					<div class="col-sm-12">
						<div class="box_content box_content_t">
							<textarea name="explain_before_child[{{ $count }}][{{ $count_child }}]" class="col-sm-12"></textarea>
							<div class="box_media">  								                
								@include('backend.lesson.question.options.action',['show_format_content'=>true])
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row img_item">
					<div class="image_box">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
						<img class="img_after_child img_after_child_{{ $count }}_{{ $count_child }}"  src="">
						<input type="hidden" name="img_after_child[{{ $count }}][{{ $count_child }}]" class="input_img_after_{{ $count }}_{{ $count_child }}">
					</div>
					<input class="upload_flash_card" type="file" name="image_flash" title=" "/>
					{{-- <button onclick="showImageUploadFlashCard(this)" class="flash_img_upload btn_img_after_{{ $count }}_{{ $count_child }}" style="font-size:24px" data-postion="after" data-type="child" data-count="{{ $count }}_{{ $count_child }}">Tải ảnh <i class="fa fa-upload"></i></button> --}}
					
					<div class="col-sm-1">Gợi ý</div>
					<div class="col-sm-12">
						<div class="box_content box_content_t">
							<textarea name="explain_after_child[{{ $count }}][{{ $count_child }}]" class="col-sm-12"></textarea>
							<div class="box_media">  								                
								@include('backend.lesson.question.options.action',['show_format_content'=>true])
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="">	
			<div class="form-group row">
				<div class="col-sm-12">Nội dung mặt trước</div>
				<div class="col-sm-12 input_question">
					<div class="box_content box_content_t">
						<textarea name="card_question[{{ $count }}]" class="col-sm-12" placeholder="Nội dung mặt trước"></textarea>
						<div class="box_media">  
							<div class="box_audio">
								<div class="mediPlayer">
									<audio class="listen" preload="none" data-size="50" src=""></audio>
								</div>
								<p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
								<input type="hidden" name="audio_card_question[{{ $count }}]" class="input_audio">
							</div>                  
							@include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
						</div>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-12">Nội dung mặt sau</div>
				<div class="col-sm-12 input_question">
					<div class="box_content box_content_t">
						<textarea name="card_question_after[{{ $count }}]" class="col-sm-12" placeholder="Nội dung mặt sau"></textarea>
						<div class="box_media">  
							<div class="box_audio">
								<div class="mediPlayer">
									<audio class="listen" preload="none" data-size="50" src=""></audio>
								</div>
								<p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
								<input type="hidden" name="audio_card_question_after[{{ $count }}]" class="input_audio">
							</div>                  
							@include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 flash_card_item">
				<div class="form-group row img_item">
					<div class="image_box">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
						<img class="img_flash img_before img_before_{{ $count }}" src="">
						<input type="hidden" name="card_img_before[{{ $count }}]" class="input_img_before_{{ $count }}">
					</div>
					<input class="upload_flash_card" type="file" name="image_flash" title=" "/>
					{{-- <button onclick="showImageUploadFlashCard(this)" class="flash_img_upload btn_img_before_{{ $count }}" data-postion="before" data-type="parent" data-count="{{ $count }}" style="font-size:24px">Tải ảnh <i class="fa fa-upload"></i></button> --}}
					
					<div class="col-sm-1">Gợi ý</div>
					<div class="col-sm-12">
						<div class="box_content box_content_t">
							<textarea name="card_explain[{{ $count }}][before]" class="col-sm-12"></textarea>
							<div class="box_media">  
								{{-- <div class="box_audio">
									<div class="mediPlayer">
										<audio class="listen" preload="none" data-size="50" src=""></audio>
									</div>
									<input type="hidden" name="audio_card_explain[{{ $count }}][before]" class="input_audio">
								</div> --}}                  
								@include('backend.lesson.question.options.action',['show_format_content'=>true])
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row img_item">
					<div class="image_box">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
						<img class="img_flash img_after img_after_{{ $count }}" src="">
						<input type="hidden" name="card_img_after[{{ $count }}]" class="input_img_after_{{ $count }}">
					</div>
					<input class="upload_flash_card" type="file" name="image_flash" title=" "/>
					{{-- <button onclick="showImageUploadFlashCard(this)" class="flash_img_upload btn_img_after_{{ $count }}"  data-postion="after" data-type="parent" data-count="{{ $count }}" style="font-size:24px">Tải ảnh <i class="fa fa-upload"></i></button> --}}
					
					<div class="col-sm-1">Gợi ý</div>
					<div class="col-sm-12">
						<div class="box_content box_content_t">
							<textarea name="card_explain[{{ $count }}][after]" class="col-sm-12"></textarea>
							<div class="box_media">  
								{{-- <div class="box_audio">
									<div class="mediPlayer">
										<audio class="listen" preload="none" data-size="50" src=""></audio>
									</div>
									<input type="hidden" name="audio_card_explain[{{ $count }}][after]" class="input_audio">
								</div> --}}                  
								@include('backend.lesson.question.options.action',['show_format_content'=>true])
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif
@endif
