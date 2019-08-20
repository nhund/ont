@extends('backend.layout')
@section('title', 'About')
@section('content')
    {{-- @include('admin.include.breadcrumb') --}}
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div id="panel-advancedoptions">
                    <div class="panel panel-default" data-widget-editbutton="false">
                        <div class="panel-heading">
                            <h2>Thông tin chung</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('admin.about.save') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        @if(isset($about->id))
                                            <input type="hidden" name="id" value="{{ $about->id }}" />
                                        @endif
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tên công ty</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="title" placeholder="Tên website" value="{{ isset($about->title)?$about->title:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Giới thiệu</label>
                                            <div class="col-sm-8">
                                                <textarea class="note-codable form-control" id="editor" name="about_us">{{ isset($about->about_us)?$about->about_us:'' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Chính sách riêng tư</label>
                                            <div class="col-sm-8">
                                                <textarea class="note-codable form-control" id="editor_privacy_policy" name="privacy_policy">{{ isset($about->privacy_policy)?$about->privacy_policy:'' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Điều khoản sử dụng</label>
                                            <div class="col-sm-8">
                                                <textarea class="note-codable form-control" id="editor_terms" name="terms">{{ isset($about->terms)?$about->terms:'' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Logo</label>
                                            <div class="col-sm-3">
                                                <div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 200px; height: 200px;">
                                                        <img class="preview_img" @if(empty($about->logo)) style="display: none" @endif src="{{ isset($about->logo) ? asset($about->logo) :'' }}">
                                                    </div>
                                                    <div>
                                                        <input id="ckfinder-input-1" name="logo" value="{{ isset($about->logo) ? $about->logo : '' }}" type="text" style="display: none" class="form-control">
                                                        <button id="ckfinder-popup-1" type="button" class="btn btn-info">Chọn ảnh</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Website</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="url" placeholder="website" value="{{ isset($about->url)?$about->url:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Địa chỉ</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="address" placeholder="Địa chỉ" value="{{ isset($about->address)?$about->address:'' }}" class="form-control">
                                            </div>
                                        </div>                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Phone</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="phone" placeholder="phone" value="{{ isset($about->phone)?$about->phone:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="email" placeholder="email" value="{{ isset($about->email)?$about->email:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Page Facebook</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="page_facebook" placeholder="page facebook" value="{{ isset($about->page_facebook)?$about->page_facebook:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Group Facebook</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="group_facebook" placeholder="group facebook" value="{{ isset($about->group_facebook)?$about->group_facebook:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Twitter</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="twitter" placeholder="twitter" value="{{ isset($about->twitter)?$about->twitter:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Google</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="google" placeholder="google" value="{{ isset($about->google)?$about->google:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Instagram</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="instagram" placeholder="instagram" value="{{ isset($about->instagram)?$about->instagram:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">youtube</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="youtube" placeholder="youtube" value="{{ isset($about->youtube)?$about->youtube:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Map</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="map" placeholder="map" value="{{ isset($about->map)?$about->map:'' }}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <input type="submit" class="btn-primary btn" value="Save">                                                    
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