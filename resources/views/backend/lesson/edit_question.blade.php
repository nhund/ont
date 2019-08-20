@extends('backend.layout')
@section('title', 'Cập nhật câu hỏi')
@push('css')
<link href="{{asset('/public/admintrator/assets/css/animate.min.css')}}" type="text/css" rel="stylesheet">
<link href="{{asset('/public/admintrator/assets/css/question.css')}}?v={{ time() }}" type="text/css" rel="stylesheet">
@endpush
@push('js')
<script>
    var upload_audio = '{{ route('admin.import.audio') }}';
    var upload_image = '{{ route('admin.import.image') }}';
    // var upload_image = '{{ route('exercise.upload') }}';
    var question_add = '{{ route('admin.question.add') }}';
    var question_get_temlate_flc_chuoi = '{{ route('admin.question.getTemplateFlashCard') }}';
    var question_get_temlate_trac_nghiem = '{{ route('admin.question.getTemplateTracNghiem') }}';
    var edit_question_route = '{{ route('admin.question.edit') }}';
    var edit_question_route_save = '{{ route('admin.question.editSave') }}';
    var question_get_temlate_dien_tu_dv = '{{ route('admin.question.getTemplateDienTuDoanvan') }}';
    var question_get_temlate_dien_tu = '{{ route('admin.question.getTemplateDienTu') }}';
    var question_delete = '{{ route('admin.question.delete') }}';
</script>
<script src="{{ asset('/public/admintrator/assets/js/question.js') }}?v={{ time() }}"></script>  
<script src="{{ asset('/public/admintrator/assets/js/bootstrap-notify.min.js') }}"></script>
{{-- <script src="{{ asset('/public/admintrator/assets/plugins/form-ckeditor/ckeditor.js') }}"></script> --}}
<script src="{{ asset('/public/plugin/ckeditor/ckeditor.js') }}"></script>
@include('backend.lesson.question.options.js')
@endpush
@section('content')
@include('backend.include.breadcrumb')
<div class="container-fluid">
    <div class="row">
        {{-- @include('include.backend.box_left') --}}
        <div class="col-md-9">
            <div class="panel panel-gray">
                <div class="panel-body mailbox-panel">
                    <ol class="breadcrumb">

                    </ol>
                    <div class="panel-footer detail-footer">
                        <div class="panel panel-default">
                            <div class="panel-heading">

                            </div>
                            <div class="panel-body">
                                <div class="editQuestion addQuestionModal">
                                    @include('backend.lesson.question.box_edit_question');
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.lesson.question.popup.popup_image')
@include('backend.lesson.editor.editor',['course_id'=>$question['course_id']])
@include('backend.lesson.question.popup.popup_audio')
@endsection