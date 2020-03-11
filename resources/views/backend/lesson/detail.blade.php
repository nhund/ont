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
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab-des" data-toggle="tab" class="tabDescription">
                                                    <span class="tabDes">@if ($lesson['is_exercise']) Câu hỏi @else Nội dung @endif</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </h2>
                                    @if (!$lesson['is_exercise'])  <h2><a href="{{ route('admin.userLesson.report.detail', ['lesson' => $lesson->id]) }}">&nbsp; Tiến độ bài học</a></h2>@endif

                                    <div class="pull-right editBtn">
                                        @if (!$lesson['is_exercise'])
                                                <button class="btn btn-primary" title="Sửa" @if (!$lesson['is_exercise'])
                                                onclick="handleLessonForm()" @else  @endif
                                                ><i class="fa fa-pencil-square-o"></i></button>
                                        @endif
                                        @if ($lesson['is_exercise'])
                                            <button class="btn btn-primary" title="Sửa" data-toggle="modal" href="#editCourse"><i class="fa fa-pencil-square-o"></i></button>
                                        @endif
                                        <a class="btn btn-danger left10" title="Xóa" data-toggle="modal" href="#delLesson">Xoá</a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-des">
                                            <div class="change-lesson-des" style="display: none">
                                                <div class="text-center form-group">
                                                    <button type="button" class="btn btn-primary" onclick="saveDesLesson()"><i class="fa fa-save"></i> &nbsp;&nbsp;Lưu</button>
                                                    <button type="button" class="btn btn-danger left10" onclick="handleLessonForm()">Hủy</button>
                                                </div>
                                                @if(!$lesson['is_exercise'])
                                                <form id="editDesLesson" action="{{ route('lesson.handle') }}" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="id" value="{{ $lesson['id'] }}">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-6">Tên</div>
                                                            <div class="col-sm-6">Status</div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" placeholder="#Lesson name" name="lname" value="{{ $lesson['name'] }}">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select class="form-control" name="status">
                                                                <option value="1" @if ($lesson['status'] == 1) selected="selected" @endif>Public</option>
                                                                <option value="2" @if ($lesson['status'] == 2) selected="selected" @endif>Private</option>
                                                                <option value="3" @if ($lesson['status'] == 3) selected="selected" @endif>Deleted</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <div class="col-sm-6">Link Video</div>
                                                            <div class="col-sm-6">File audio</div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" placeholder="#Link video" name="video" value="{{ $lesson['video'] }}">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input type="file" name="audio">
                                                            @if(!empty($lesson['audio']))
                                                                <div class="mediPlayer">
                                                                    <audio class="listen" preload="none" data-size="60" src="{{ web_asset('public/'.$lesson['audio']) }}"></audio>
                                                                </div>
                                                                @push('js')
                                                                    <script>
                                                                        $(document).ready(function () {
                                                                          $('.mediPlayer').mediaPlayer();
                                                                      });
                                                                    </script>
                                                                @endpush
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row col-sm-12">Nội dung</div>
                                                    <div class="col-sm-12 row">
                                                        <textarea name="description" cols="80" rows="20" id="editor" class="ckeditor1">{{ $lesson['description'] or '' }}</textarea>
                                                    </div>
                                                </form>
                                                @endif
                                            </div>

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
                                        <div class="tab-pane" id="tab-comment">
                                            <p>Bình luận</p>
                                        </div>
                                        <div class="tab-pane" id="tab-rate">
                                            <p>Đánh giá</p>
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
</script>

@endpush