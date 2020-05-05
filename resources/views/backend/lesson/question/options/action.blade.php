<div class="phd">
        <div class="dropdown">
            <img class="dropdown-toggle" data-toggle="dropdown" src="{{ asset('public/images/course/icon/option-create-question-01.png') }}" style="" type="button" aria-expanded="false">                
            <ul class="dropdown-menu">
                @if(isset($add_answer_error) && $add_answer_error && isset($add_answer_error_count))
                    <li class="add_answer_error" data-count="{{ $add_answer_error_count }}">Thêm câu trả lời sai</li>
                @endif
                @if(isset($delete_anwser) && $delete_anwser)
                    <li class="delete_anwser" onclick="deleteAnwser(this)">Xóa câu hỏi</li>
                @endif
                @if(isset($show_image) && $show_image)
                    <li class="popup_upload add_upload_image" data-type="1" onclick="showImageUpload(this)">Thêm ảnh</li>
                @endif
                @if(isset($show_explain) && $show_explain)
                    <li class="add_explain">Thêm gợi ý</li>
                @endif
                {{-- <li class="popup_upload" data-type="content">Thêm ảnh</li> --}}
                @if(isset($show_audio) && $show_audio)
                    <li class="popup_upload_audio" onclick="showAudioUpload(this)">Thêm audio</li>
                @endif
                @if(isset($show_format_content) && $show_format_content)
                    <li class="format_content" onclick="ShowFormatContent(this)" data-type="content">Định dạng nội dung</li>
                @endif
            </ul>
        </div>
    </div>