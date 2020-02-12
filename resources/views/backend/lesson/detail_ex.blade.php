@push('js')
<script>
    var upload_audio = '{{ route('admin.import.audio') }}';
    var upload_image = '{{ route('admin.import.image') }}';
    // var upload_image = '{{ route('exercise.upload') }}';
    var question_add = '{{ route('admin.question.add') }}';
    var question_get_temlate_flc_chuoi = '{{ route('admin.question.getTemplateFlashCard') }}';
    var question_get_temlate_trac_nghiem = '{{ route('admin.question.getTemplateTracNghiem') }}';
    var question_get_temlate_dien_tu = '{{ route('admin.question.getTemplateDienTu') }}';
    var question_get_temlate_dien_tu_dv = '{{ route('admin.question.getTemplateDienTuDoanvan') }}';
    var edit_question_route = '{{ route('admin.question.edit') }}';
    var edit_question_route_save = '{{ route('admin.question.editSave') }}';
</script>
<script src="{{ asset('/public/admintrator/assets/js/question.js') }}?v={{ time() }}"></script>    
@endpush
@push('css')
    <link href="{{asset('/public/admintrator/assets/css/question.css')}}?v={{ time() }}" type="text/css" rel="stylesheet">
@endpush
<button class="btn btn-primary btn_add_question">Tạo câu hỏi</button>
<button class="btn btn-success" data-toggle="modal" data-target="#importQuestion"><i class="fa fa-file-excel-o"></i>Thêm câu hỏi từ excel</button>
<a class="btn btn-orange" href="{{ route('admin.export.question',['id'=>$lesson['id'], 'part' => $part->id?? '']) }}"><i class="fa fa-download"></i>Export excel</a>
<div class="editQuestion addQuestionModal">
    {{-- @include('backend.lesson.question.box_edit_question') --}}
</div>
@include('backend.lesson.question.box_add_question')

@include('backend.lesson.question.popup.popup_image')

@include('backend.lesson.import.import_excel')

@include('backend.lesson.editor.editor',['course_id'=>$lesson['course_id']])
@include('backend.lesson.question.popup.popup_audio')
