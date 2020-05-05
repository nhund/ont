@extends('backend.layout')
@section('title', $page_title)
@push('css')
    <link href="{{asset('/public/admintrator/assets/css/animate.min.css')}}" type="text/css" rel="stylesheet">
@endpush
@push('js')

@endpush
@section('content')
    @include('backend.include.breadcrumb',['var'=>$breadcrumb])
    <div class="container-fluid">
        <div class="row">
            @include('include.backend.box_left')
            <div class="col-md-9">
                <div class="panel panel-gray">
                    <div class="panel-body mailbox-panel">
                        <ol class="breadcrumb">
                            @if ($lesson['lv1'])
                                <li><a href="{{ route('lesson.detail', ['id' => $lesson['lv1']]) }}">{{ $course_lesson[$lesson['lv1']]['name'] }}</a></li>
                                <li><a href="{{ route('lesson.detail', ['id' => $lesson['lv2'] ? $lesson['lv2'] : $lesson['id']]) }}">{{ $lesson['lv2']?$course_lesson[$lesson['lv2']]['name']:$course_lesson[$lesson['id']]['name'] }}</a></li>
                                @if ($lesson['lv2'] && $lesson['lv2'] != $lesson['id'])
                                    <li class="active"><a href="{{ route('lesson.detail', ['id' => $lesson['id']]) }}">{{ $lesson['name'] }}</a></li>
                                @endif
                            @else
                                <li class="active"><a href="{{ route('lesson.detail', ['id' => $lesson['id']]) }}">{{ $lesson['name'] }}</a></li>
                            @endif
                        </ol>
                        <div class="panel-footer detail-footer">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2>
                                        <ul class="nav ">
                                            <li class="add-question">
                                                <a href="{{route('exam.detail', ['id' => $lesson->id])}}"  class="btn btn-default"><< Quay lại</a>
                                            </li>
                                        </ul>
                                    </h2>
                                    <div class="pull-right editBtn">
                                        <a class="btn btn-success left10" title="Xóa" data-toggle="modal" href="#update-part-exam">Cập nhật thông tin</a>
                                        <button class="btn btn-primary" title="Sửa" data-toggle="modal" href="#editCourse">Sửa</button>
                                        <a class="btn btn-danger left10" title="Xóa" data-toggle="modal" href="#delLesson">Xoá</a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div class="active" id="tab-add-question">
                                            @include('backend.exam.add_question')
                                            @if ($lesson['description'])
                                                <div class="pdes">
                                                    {!! $lesson['description'] !!}
                                                    <p>Audio :</p>
                                                    @if(!empty($lesson['audio']))
                                                        <div class="mediPlayer">
                                                            <audio class="listen" preload="none" data-size="60" src="{{ web_asset('public/'.$lesson['audio']) }}"></audio>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                            @if(!$lesson['is_exercise'])
                                                <div class="text-center form-group add-lesson-des">
                                                    <button type="button" class="btn btn-primary" onclick="handleLessonForm()"><i class="fa fa-plus"></i> &nbsp;&nbsp;Thêm nội dung</button>
                                                </div>
                                                @include('backend.lesson.list')
                                            @else
                                                @include('backend.lesson.detail_ex')
                                            @endif

                                            @if ($lesson['is_exercise'])
                                                @include('backend.lesson.information')
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('include.backend.detail_modal')
    @include('include.backend.lesson_modal')

@endsection
@push('js')
{{-- <script src="{{ asset('public/admintrator/assets/plugins/form-ckeditor/ckeditor.js') }}"></script> --}}
<script src="{{ asset('/public/admintrator/assets/js/bootstrap-notify.min.js?ver=1') }}"></script>
<script src="{{ asset('/public/plugin/ckeditor/ckeditor.js') }}?v={{ time() }}"></script>
<script type="text/javascript">
    $('.nav-tabs a').click(function () {
            if ($(this).hasClass('tabDescription')) {
                $('.editBtn').show();
            } else {
                $('.editBtn').hide();
            }
        });
    if($('#editor').length > 0)
    {
        if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
        CKEDITOR.tools.enableHtml5Elements( document );

        // The trick to keep the editor in the sample quite small
        // unless user specified own height.
        CKEDITOR.config.height = 300;
        CKEDITOR.config.width = 'auto';
        //CKEDITOR.config.extraPlugins += (CKEDITOR.config.extraPlugins.length == 0 ? '' : ',') + 'ckeditor_wiris';
        //CKEDITOR.instances['editor'].setData(textarea);

        var initSample = ( function() {
            var wysiwygareaAvailable = isWysiwygareaAvailable(),
                isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );

            return function() {
                var editorElement = CKEDITOR.document.getById( 'editor' );

                // :(((
                if ( isBBCodeBuiltIn ) {
                    editorElement.setHtml(

                    );
                }

                // Depending on the wysiwygarea plugin availability initialize classic or inline editor.
                if ( wysiwygareaAvailable ) {
                    CKEDITOR.replace( 'editor' ,{

                        filebrowserUploadUrl: '{{ route('admin.import.imageCkeditor') }}?_token={{ csrf_token() }}&course_id={{ $lesson['course_id'] }}',
                    });
                } else {
                    editorElement.setAttribute( 'contenteditable', 'true' );
                    CKEDITOR.inline( 'editor' );

                    // TODO we can consider displaying some info box that
                    // without wysiwygarea the classic editor may not work.
                }
            };

            function isWysiwygareaAvailable() {
                // If in development mode, then the wysiwygarea must be available.
                // Split REV into two strings so builder does not replace it :D.
                if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
                    return true;
                }

                return !!CKEDITOR.plugins.get( 'wysiwygarea' );
            }
        } )();
        initSample();
    }

    @if(!$lesson['is_exercise'])
        $(document).ready(function() {
            $('.supplier_select').select2();

        });
    @endif

    @if(request()->has('key_search'))
        $('.common-question').removeClass('active');
        $('.a-add-question').click();
        $('.add-question').addClass('active');
    @endif

</script>

@endpush