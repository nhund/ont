@if(isset($edit) && $edit)
{{-- edit --}}
    <div class="form-group row image_box">
        <div class="col-sm-12">Ảnh</div>
        <div class="col-sm-12 image_list">                                    
            <div class="form-group row img_item">
                <div class="media_box">
                    <div class="image_box" style="@if(!empty($question->img_before)) display:block; @endif">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
                        <img class="img_before" src="{{ web_asset($question->img_before) }}">    
                        <input type="hidden" name="img_card_before" class="input_img_before" value="{{ $question->img_before }}">
                    </div>                    
                    <input class="upload_flash_card" type="file" name="image_flash" title=" "/>
                    {{-- <button class="flash_img_upload btn_img_before" data-postion="before" data-type="flash_card" data-count="1" style="font-size:24px">Tải ảnh <i class="fa fa-upload"></i></button> --}}
                    
                    {{-- <label id="#img_before"> <i class="fa fa-upload"></i> tải lên ảnh
                        <input type="file" name="upImage" id="img_before" class="upImage" data-type="img_before">
                    </label>  --}}
                </div>

                <div class="col-sm-12">
                    <div class="col-sm-1">Gợi ý</div>
                    <div class="box_content_t">
                        <textarea rows="3" name="explain[before]" class="col-sm-12">{{ $question->explain_before }}</textarea>
                        <div class="box_media">  
                            {{-- <div class="box_audio">
                                <div class="mediPlayer">
                                    <audio class="listen" preload="none" data-size="60" src=""></audio>
                                </div>
                            <input type="hidden" name="audio_explain_before" class="input_audio">
                            </div> --}}                  
                            @include('backend.lesson.question.options.action',['show_format_content'=>true])
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row img_item">
                <div class="media_box">
                    <div class="image_box" style="@if(!empty($question->img_after)) display:block; @endif">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
                        <img class="img_after" src="{{ web_asset($question->img_after) }}">
                        <input type="hidden" name="img_card_after" class="input_img_after" value="{{ $question->img_after }}">
                    </div>
                    <input class="upload_flash_card" type="file" name="image_flash" title=" "/>
                    {{-- <button class="flash_img_upload btn_img_after" data-postion="after" data-type="flash_card" data-count="1" style="font-size:24px">Tải ảnh <i class="fa fa-upload"></i></button> --}}
                    
                    {{-- <label id="#img_after"> <i class="fa fa-upload"></i> tải lên ảnh                    
                        <input type="file" name="upImage" id="img_after" class="upImage" data-type="img_after">
                    </label>  --}}
                    
                </div>                    
                <div class="col-sm-12">
                    <div class="col-sm-1">Gợi ý</div>
                    <div class="box_content_t">
                        <textarea rows="3" name="explain[after]" class="col-sm-12">{{ $question->explain_after }}</textarea>
                        <div class="box_media">  
                            {{-- <div class="box_audio">
                                <div class="mediPlayer">
                                    <audio class="listen" preload="none" data-size="60" src=""></audio>
                                </div>
                            <input type="hidden" name="audio_explain_after" class="input_audio">
                            </div> --}}                  
                            @include('backend.lesson.question.options.action',['show_format_content'=>true])
                        </div>
                    </div>
                </div>
            </div>                                    
        </div>
        <input type="hidden" name="img_before" value="">
        <input type="hidden" name="img_after" value="">
    </div>
    <div class="form-group row">
            <div class="col-sm-12">Nội dung mặt trước</div>
            <div class="col-sm-12">
                <div class="box_content_t">
                    <textarea rows="4" name="question_card" class="col-sm-10 sub_question" placeholder="Nội dung mặt trước">{{ $question->question }}</textarea>
                    <div class="box_media">  
                        <div class="box_audio @if(!empty($question->audio_question)) show @endif">
                          <div class="mediPlayer">
                            <audio class="listen" preload="none" data-size="60" src="{{ web_asset($question->audio_question) }}"></audio>
                        </div>
                        <p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
                        <input type="hidden" name="audio_question" class="input_audio" value="{{ $question->audio_question }}">
                    </div>                  
                    @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
                </div>
            </div>
        </div>
    </div>
        <div class="form-group row">
            <div class="col-sm-12">Nội dung mặt sau</div>
            <div class="col-sm-12">
                <div class="box_content_t">
                    <textarea rows="4" name="question_after_card" class="col-sm-10 sub_question" placeholder="Nội dung mặt sau">{{ $question->question_after }}</textarea>
                    <div class="box_media">  
                        <div class="box_audio @if(!empty($question->audio_question_after)) show @endif">
                          <div class="mediPlayer">
                            <audio class="listen" preload="none" data-size="60" src="{{ web_asset($question->audio_question_after) }}"></audio>
                        </div>
                        <p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
                        <input type="hidden" name="audio_question_after" class="input_audio" value="{{ $question->audio_question_after }}">
                    </div>                  
                    @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
                </div>
            </div>
        </div>
    </div>
@else 
{{-- tao moi --}}
    <div class="form-group row image_box">
        <div class="col-sm-12">Ảnh</div>
        <div class="col-sm-12 image_list">                                    
            <div class="form-group row img_item">
                <div class="media_box">
                    <div class="image_box">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
                        <img class="img_before" src="">    
                        <input type="hidden" name="img_card_before" class="input_img_before" value="">
                    </div>
                    <input class="upload_flash_card" type="file" name="image_flash" title=" "/>

                    {{-- <button class="flash_img_upload btn_img_before" data-postion="before" data-type="flash_card" data-count="1" style="font-size:24px">Tải ảnh <i class="fa fa-upload"></i></button> --}}
                    
                    {{-- <label id="#img_before"> <i class="fa fa-upload"></i> tải lên ảnh
                        <input type="file" name="upImage" id="img_before" class="upImage" data-type="img_before">
                    </label>  --}}
                </div>

                <div class="col-sm-12">
                    <div class="col-sm-1">Gợi ý</div>
                    <div class="box_content_t">
                        <textarea rows="3" name="explain[before]" class="col-sm-12 conten_textarea"></textarea>
                        <div class="box_media">  
                            {{-- <div class="box_audio">
                                <div class="mediPlayer">
                                    <audio class="listen" preload="none" data-size="60" src=""></audio>
                                </div>
                            <input type="hidden" name="audio_explain_before" class="input_audio">
                            </div> --}}                  
                            @include('backend.lesson.question.options.action',['show_format_content'=>true])
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row img_item">
                <div class="media_box">
                    <div class="image_box">
                        <i class="fa fa-remove delete_image" title="Xóa ảnh"></i>
                        <img class="img_after" src="">    
                        <input type="hidden" name="img_card_after" class="input_img_after" value="">
                    </div>
                    <input class="upload_flash_card" type="file" name="image_flash" title=" "/>
                    {{-- <button class="flash_img_upload btn_img_after" data-postion="after" data-type="flash_card" data-count="1" style="font-size:24px">Tải ảnh <i class="fa fa-upload"></i></button> --}}
                    
                    {{-- <label id="#img_after"> <i class="fa fa-upload"></i> tải lên ảnh                    
                        <input type="file" name="upImage" id="img_after" class="upImage" data-type="img_after">
                    </label>  --}}
                    
                </div>                    
                <div class="col-sm-12">
                    <div class="col-sm-1">Gợi ý</div>
                    <div class="box_content_t">
                        <textarea rows="3" name="explain[after]" class="col-sm-12"></textarea>
                        <div class="box_media">  
                            {{-- <div class="box_audio">
                                <div class="mediPlayer">
                                    <audio class="listen" preload="none" data-size="60" src=""></audio>
                                </div>
                            <input type="hidden" name="audio_explain_after" class="input_audio">
                            </div> --}}                  
                            @include('backend.lesson.question.options.action',['show_format_content'=>true])
                        </div>
                    </div>
                </div>
            </div>                                    
        </div>
        <input type="hidden" name="img_before" value="">
        <input type="hidden" name="img_after" value="">
    </div>
    <div class="form-group row">
        <div class="col-sm-12">Nội dung mặt trước</div>
        <div class="col-sm-12">
            <div class="box_content_t">
                <textarea rows="4" name="question_card" class="col-sm-10 sub_question" placeholder="Nội dung mặt trước"></textarea>
                <div class="box_media">  
                    <div class="box_audio">
                        <div class="mediPlayer">
                            <audio class="listen" preload="none" data-size="60" src=""></audio>
                        </div>
                        <p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
                        <input type="hidden" name="audio_question_card" class="input_audio">
                    </div>                  
                    @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
                </div>
            </div>
        </div>                                
    </div>
    <div class="form-group row">
        <div class="col-sm-12">Nội dung mặt sau</div>
        <div class="col-sm-12">
            <div class="box_content_t">
                <textarea rows="4" name="question_after_card" class="col-sm-10 sub_question" placeholder="Nội dung mặt sau"></textarea>
                <div class="box_media">  
                    <div class="box_audio">
                        <div class="mediPlayer">
                            <audio class="listen" preload="none" data-size="60" src=""></audio>
                        </div>
                        <p class="delete" title="Xóa audio" onclick="deleteAudio(this)">Xóa</p>
                    <input type="hidden" name="audio_question_card_after" class="input_audio">
                    </div>                  
                    @include('backend.lesson.question.options.action',['show_format_content'=>true,'show_audio'=>true])
                </div>
            </div>
            
        </div>
    </div>
@endif