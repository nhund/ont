@extends('backend.layout')
@section('title', 'Thêm bài viết')
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div id="panel-advancedoptions">
                    <div class="panel panel-default" data-widget-editbutton="false">
                        <div class="panel-heading">
                            <h2>Thêm bài viết</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('admin.post.save') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tiêu đề</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="name" autocomplete="off" placeholder="Tiêu đề" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Nội dung</label>
                                            <div class="col-sm-8">
                                                <textarea class="note-codable form-control" id="editor" name="content"></textarea>
                                            </div>
                                        </div>                                                                                                                   
                                        <div class="form-group pb0">
                                            <label for="" class="control-label col-sm-2">Trạng thái</label>
                                            <div class="col-sm-2 tabular-border">
                                                <select class="form-control" name="status">                                                                    
                                                    <option value="{{ App\Models\Post::STATUS_ON }}">public</option>
                                                    <option value="{{ App\Models\Post::STATUS_OFF }}">private</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <input type="submit" class="btn-primary btn" value="Save">
                                                    <a href="{{ route('admin.post.index')}}" class="btn-default btn">Cancel</a>
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
                
                CKEDITOR.replace('editor');
                // $('.supplier_select').select2();
                // CKEDITOR.config.filebrowserImageUploadUrl = '{!! route('admin.about.index').'?_token='.csrf_token() !!}';
                CKEDITOR.config.filebrowserUploadUrl = '{{ route('admin.import.importImagePost') }}?_token={{ csrf_token() }}';
                
                if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
                    CKEDITOR.tools.enableHtml5Elements( document );

                // The trick to keep the editor in the sample quite small
                // unless user specified own height.
                CKEDITOR.config.height = 300;
                CKEDITOR.config.width = 'auto';
                CKEDITOR.config.extraPlugins += (CKEDITOR.config.extraPlugins.length == 0 ? '' : ',') + 'ckeditor_wiris';
                
                CKEDITOR.config.allowedContent = true;
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
                            // CKEDITOR.replace( 'editor', {
                            //     filebrowserBrowseUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/ckfinder.html') }}',
                            //     filebrowserImageBrowseUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/ckfinder.html?type=Images') }}',
                            //     filebrowserFlashBrowseUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/ckfinder.html?type=Flash') }}',
                            //     filebrowserUploadUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files') }}',
                            //     filebrowserImageUploadUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images') }}',
                            //     filebrowserFlashUploadUrl: '{{ asset('public/admintrator/assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash') }}'
                            // } );
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