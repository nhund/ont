@if(isset($edit) && $edit)
	<div id="question{{ $question_child->id }}" class="box_question_d">
		<div class="@if(isset($data['feedback_question']) && $data['feedback_question'] == $question_child->id ) border_feedback @endif" style="position: relative;float: left; margin-bottom: 10px; width: 98%; background-color: #fefefe; border-style: solid; border-color: #CCCCCC; border-width: 1px; padding:2px;">
			<div class="column first">
				<span id=questionLabel>
					Câu hỏi:     	
				</span>			
			</div>
			<div class="column">
				<a href='javascript:;' class="delete_question" data-id="{{ $question_child->id }}" data-type="{{ \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN }}">
					<img src="{{ web_asset('public/images/Delete.gif') }}" border=0 align=right style="margin:3px">
				</a>
				<br>
				<div>
					<nobr>
						<textarea name="txtDirections[{{ $count }}]" id="directions{{ $count }}" cols=80 rows=3 style="display:none; valign-text:top; width:95%;" class=directions>{!! $question_child->question !!}</textarea>
						{{-- <img id=formatDirections1 src="/images/buttons/editor.png" border=0 style="display:none; padding-left: 3px; padding-right:10px;"> --}}
					</nobr>
				</div>

				<span id="spanQuestion{{ $question_child->id }}">
					<textarea data-id="{{ $question_child->id }}"  name="question_dt[{{ $question_child->id }}]" id="txtQuestion{{ $question_child->id }}" cols=50 rows=15 style="width: 100%; height:200px;" class=question_dt>{!! $question_child->question !!}</textarea>
				</span>
			</div>
			<div class="column first">
				<span id=explanationLabel>
					Gợi ý:    	
				</span>
			</div>
			<div class="column">
				<nobr>
					<div class="box_content_t">
						<textarea name="explanation[{{ $question_child->id }}]" id="explanationID1" cols=80 rows=2 style="valign-text:top; width: 95%;" class=explanation>{!! $question_child->explain_before !!}</textarea>	
						<div class="box_media">                
				          @include('backend.lesson.question.options.action',['show_format_content'=>true])          
				        </div>
					</div>		
					<div style="margin-top:5px">Giải thích
						<div class="box_content_t">
						<textarea name="interpret_dv[{{ $question_child->id }}]" class="col-sm-12 form-control explain" placeholder="Giải thích câu hỏi">{!! $question_child->interpret !!}</textarea>
						<div class="box_media">                            
							@include('backend.lesson.question.options.action',['show_format_content'=>true])
						</div>
						</div>
					</div>			
					{{-- <img id=formatExplanation1 src="/images/buttons/editor.png" border=0 style="padding-left: 3px; padding-right:10px;"  onclick="generateTinyMCEforExplanation('{{ $question_child->id }} ')"> --}}
				</nobr>
			</div>
		</div>
		<br>
	</div>
@else
<div id="question{{ $count }}" class="box_question_d">
	<div style="position: relative;float: left; margin-bottom: 10px; width: 98%; background-color: #fefefe; border-style: solid; border-color: #CCCCCC; border-width: 1px; padding:2px;">
		<div class="column first">
			<span id=questionLabel>
				Câu hỏi:     	
			</span>			
		</div>
		<div class="column">
			<a href='javascript:;' class="delete_question" data-id="" data-type="{{ \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN }}">
				<img src="{{ web_asset('public/images/Delete.gif') }}" border=0 align=right style="margin:3px">
			</a>
			<br>
			<div>
				<nobr>
					<textarea name="txtDirections[{{ $count }}]" id="directions{{ $count }}" cols=80 rows=3 style="display:none; valign-text:top; width:95%;" class=directions></textarea>
					{{-- <img id=formatDirections1 src="/images/buttons/editor.png" border=0 style="display:none; padding-left: 3px; padding-right:10px;"> --}}
				</nobr>
			</div>

			<span id="spanQuestion{{ $count }}">
				<textarea data-id="{{ $count }}"  name="question_dt[{{ $count }}]" id="txtQuestion{{ $count }}" cols=50 rows=15 style="width: 100%; height:200px;" class=question_dt></textarea>
			</span>
		</div>
		<div class="column first">
			<span id=explanationLabel>
				Gợi ý:    	
			</span>
		</div>
		<div class="column">
			<nobr>
				<div class="box_content_t">
					<textarea name="explanation[{{ $count }}]" id="explanationID1" cols=80 rows=2 style="valign-text:top; width: 95%;" class=explanation></textarea>
					<div class="box_media">                 
			          @include('backend.lesson.question.options.action',['show_format_content'=>true])          
			        </div>
				</div>
				<div style="margin-top:5px">Giải thích
					<div class="box_content_t">
						<textarea name="interpret_dv[{{ $count }}]" class="col-sm-12 form-control explain" placeholder="Giải thích câu hỏi"></textarea>
						<div class="box_media">                            
							@include('backend.lesson.question.options.action',['show_format_content'=>true])
						</div>
					</div>
				</div>
				{{-- <img id=formatExplanation1 src="/images/buttons/editor.png" border=0 style="padding-left: 3px; padding-right:10px;"  onclick="generateTinyMCEforExplanation('{{ $count }}')"> --}}
			</nobr>
		</div>
	</div>
	<br>
</div>
@endif
