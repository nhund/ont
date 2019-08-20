@extends('backend.layout')
@section('title', 'Dashboard')
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div id="panel-advancedoptions">
                    <div class="panel panel-default" data-widget-editbutton="false">
                        <div class="panel-heading">
                            <h2>Thêm ảnh</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <form method="POST" action="{{ route('admin.slider.update') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $var['slider']->id }}">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tiêu đề</label>
                                            <div class="col-sm-8">
                                            <input type="text" name="title" value="{{ $var['slider']->title }}" placeholder="Tiêu đề" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Mô tả ngắn</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="des" value="{{ $var['slider']->des }}" placeholder="Mô tả ngắn" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Url</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="url" value="{{ $var['slider']->url }}" placeholder="Url khi click vào ảnh (Không bắt buộc)" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Ảnh đại diện (kích thước chuẩn 1600 x 630 px )</label>
                                            <div class="col-sm-3">
                                                <div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 200px; height: 200px;">
                                                        <img class="preview_img" @if(empty($var['slider']->img)) style="display: none" @endif src="{{ asset($var['slider']->img) }}">
                                                    </div>
                                                    <div>
                                                        <input id="ckfinder-input-1" name="avatar" value="{{ $var['slider']->img }}" type="text" style="display: none" class="form-control">
                                                        <button id="ckfinder-popup-1" type="button" class="btn btn-info">Chọn ảnh</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group pb0">
                                            <label for="" class="control-label col-sm-2">Trạng thái</label>
                                            <div class="col-sm-2 tabular-border">
                                                <select class="form-control" name="status">
                                                    <option @if($var['slider']->status == 1) selected @endif value="1">Hiển thị</option>
                                                    <option @if($var['slider']->status == 0) selected @endif  value="0">Ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <input type="submit" class="btn-primary btn" value="Save">
                                                    <button class="btn-default btn">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            </div>

        </div>
    </div>
@stop
@push('js')
    <script src="{{ asset('public/admintrator/assets/plugins/ckfinder/ckfinder.js') }}"></script>
    {{-- <script src="{{ asset('public/admintrator/assets/plugins/form-ckeditor/ckeditor.js') }}"></script> --}}
    <script src="{{ asset('/public/plugin/ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript">
            $(document).ready(function() {
                var button1 = document.getElementById( 'ckfinder-popup-1' );
                button1.onclick = function(e) {
                    e.preventDefault();
                    selectFileWithCKFinder( 'ckfinder-input-1' );
                };
                function selectFileWithCKFinder( elementId ) {
                    CKFinder.popup( {
                        chooseFiles: true,
                        width: 800,
                        height: 600,
                        onInit: function( finder ) {
                            finder.on( 'files:choose', function( evt ) {
                                var file = evt.data.files.first();
                                var output = document.getElementById( elementId );
                                output.value = file.getUrl();
                                $('.preview_img').attr('src',file.getUrl());
                                $('.preview_img').show();
                            } );

                            finder.on( 'file:choose:resizedImage', function( evt ) {
                                var output = document.getElementById( elementId );
                                output.value = evt.data.resizedUrl;
                            } );
                        }
                    } );
                }

                // $('.supplier_select').select2();
                CKEDITOR.config.filebrowserImageUploadUrl = '{!! route('admin.about.index').'?_token='.csrf_token() !!}';
                if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
                    CKEDITOR.tools.enableHtml5Elements( document );

                // The trick to keep the editor in the sample quite small
                // unless user specified own height.
                CKEDITOR.config.height = 300;
                CKEDITOR.config.width = 'auto';

                var initSample = ( function() {
                    var wysiwygareaAvailable = isWysiwygareaAvailable(),
                        isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );

                    return function() {
                        var editorElement = CKEDITOR.document.getById( 'editor' );

                        // var editorElement = $( '.editor' );

                        // :(((
                        if ( isBBCodeBuiltIn ) {
                            editorElement.setHtml(
                            );
                        }

                        // Depending on the wysiwygarea plugin availability initialize classic or inline editor.
                        if ( wysiwygareaAvailable ) {
                            //CKEDITOR.replace( 'editor' );
                            CKEDITOR.replace( 'editor', {
                                filebrowserBrowseUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/ckfinder.html') }}',
                                filebrowserImageBrowseUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/ckfinder.html?type=Images') }}',
                                filebrowserFlashBrowseUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/ckfinder.html?type=Flash') }}',
                                filebrowserUploadUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
                                filebrowserImageUploadUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
                                filebrowserFlashUploadUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
                            } );
                        } else {
                            editorElement.setAttribute( 'contenteditable', 'true' );
                            //editorElement2.setAttribute( 'contenteditable', 'true' );
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
            });

    </script>
@endpush