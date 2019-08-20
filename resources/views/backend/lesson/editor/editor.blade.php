@push('css')

<style type="text/css">
    #editorQuestion .modal-dialog{
        width: 70%;
    }
</style>

@endpush

<div class="modal fade" id="editorQuestion" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Định dạng nội dung</h2>
            </div>
            <div class="modal-body">
                <input type="hidden" name="lesson_id" value="">  
                <div class="col-sm-12 row form-group">                            
                    <div class="form-group row">
                        <textarea class="note-codable form-control" id="editor_format" name="editor_format"></textarea>
                    </div>
                </div>                                          
            </div>
            <div class="modal-footer">
                <div class="loader" style="display: none;"></div>
                <div class="box_action">
                    <button type="button" class="btn btn-primary" onclick="appendFormatContent(this)">Lưu</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>    
                </div>                
            </div>
        </div>
    </div>
</div>
@push('js')
{{-- <script src="{{ asset('public/admintrator/assets/plugins/form-ckeditor/ckeditor.js') }}"></script> --}}
<script src="{{ asset('/public/plugin/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
        CKEDITOR.replace('editor_format');
                // $('.supplier_select').select2();
                // CKEDITOR.config.filebrowserImageUploadUrl = '{!! route('admin.about.index').'?_token='.csrf_token() !!}';
                CKEDITOR.config.filebrowserUploadUrl = '{{ route('admin.import.imageCkeditor') }}?_token={{ csrf_token() }}&course_id={{ $course_id }}';
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
                        var editorElement = CKEDITOR.document.getById( 'editor_format' );

                        // var editorElement = $( '.editor' );

                        // :(((
                        if ( isBBCodeBuiltIn ) {
                            editorElement.setHtml(
                                );
                        }

                        // Depending on the wysiwygarea plugin availability initialize classic or inline editor.
                        if ( wysiwygareaAvailable ) {
                            //CKEDITOR.replace( 'editor' );

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