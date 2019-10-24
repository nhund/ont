@extends('backend.layout')
@section('title', 'Cập nhật' )
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div id="panel-advancedoptions">
                    <div class="panel panel-default" data-widget-editbutton="false">
                        <div class="panel-heading">
                            <h2>Cập nhật : {{ $var['post']->name }}</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <form method="POST" action="{{ route('admin.post.update') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $var['post']->id }}">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tiêu đề</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="name" autocomplete="off" value="{{ $var['post']->name }}" placeholder="Tiêu đề" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Danh mục</label>
                                            <div class="col-sm-2 tabular-border">
                                                <select name="category_id" class="form-control">
                                                    <option value="">Chọn danh mục tin</option>
                                                    @foreach($_category as $value)
                                                        <option @if($var['post']->category_id == $value->id) selected @endif value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <p style="padding-top: 6px">Lưu ý: nếu bài viết là tin tức hãy chọn danh mục</p>
                                        </div>
                                        <div class="form-group hide-show none">
                                            <label class="col-sm-2 control-label">Tin nổi bật</label>
                                            <div class="col-sm-2">
                                                <select name="feature" class="form-control" id="feature">
                                                    <option value="0" @if($var['post']->feature == 0) selected @endif>Không</option>
                                                    <option value="1" @if($var['post']->feature == 1) selected @endif>Có</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group hide-show-hot none_hot">
                                            <label class="col-sm-2 control-label">Tin nổi bật nhất</label>
                                            <div class="col-sm-2">
                                                <select name="feature_hot" class="form-control">
                                                    <option value="0" @if($var['post']->feature_hot == 0) selected @endif>Không</option>
                                                    <option value="1" @if($var['post']->feature_hot == 1) selected @endif>Có</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Mô tả</label>
                                            <div class="col-sm-8">
                                                <textarea class="note-codable form-control" rows="6" name="des">{{ $var['post']->des }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Nội dung</label>
                                            <div class="col-sm-8">
                                                <textarea class="note-codable form-control" id="editor" name="content">{{ $var['post']->content }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Hình đại diện</label>
                                            <div class="col-sm-8">
                                                <div class="fileinput fileinput-new" style="width: 100%;"
                                                     data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput"
                                                         style="width: 50%; height: 150px;">
                                                        <img src="{{ asset('/public/images/news/'.$var['post']->id.'/'.$var['post']->avatar)}}">
                                                    </div>
                                                    <div>
                                                        <a href="#" class="btn btn-default fileinput-exists"
                                                           data-dismiss="fileinput">Xoá</a>
                                                        <span class="btn btn-default btn-file">
                                                        <span class="fileinput-new">Chọn ảnh</span>
                                                        <span class="fileinput-exists">Thay đổi</span>
                                                        <input type="file" name="avatar" id="avatar">
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group pb0">
                                            <label for="" class="control-label col-sm-2">Trạng thái</label>
                                            <div class="col-sm-2 tabular-border">
                                                <select class="form-control" name="status">                                                                   
                                                    <option @if(App\Models\Post::STATUS_ON == $var['post']->status) selected @endif value="{{ App\Models\Post::STATUS_ON }}">Hiển thị</option>
                                                    <option @if(App\Models\Post::STATUS_OFF == $var['post']->status) selected @endif value="{{ App\Models\Post::STATUS_OFF }}">Ẩn</option>
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
            $('#category-news').change(function () {
                var val = $(this).val();
                if (val === ""){
                    $('.hide-show').addClass('none');
                    $('.hide-show-hot').addClass('none');
                }else {
                    $('.hide-show').removeClass('none');
                    $('.hide-show-hot').removeClass('none');
                }
            });

            $('#feature').change(function () {
                var val = $(this).val();
                if (val == 0){
                    $('.hide-show-hot').addClass('none_hot');
                }else {
                    $('.hide-show-hot').removeClass('none_hot');
                }
            });
    </script>
@endpush