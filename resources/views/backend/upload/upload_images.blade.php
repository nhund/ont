@extends('backend.layout')
@push('css')
<link href="{{ web_asset('/public/plugin/upload/css/style.css')}}" type="text/css" rel="stylesheet">
<link href="{{ web_asset('/public/plugin/upload/css/blueimp-gallery.min.css')}}" type="text/css" rel="stylesheet">
<link href="{{ web_asset('/public/plugin/upload/css/jquery.fileupload.css')}}" type="text/css" rel="stylesheet">
<link href="{{ web_asset('/public/plugin/upload/css/jquery.fileupload-ui.css')}}" type="text/css" rel="stylesheet">
<style type="text/css">
	#fileupload .files .preview img{
		width: 80px;
	}
</style>
@endpush
@section('content')
	<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        
    </div>
</div>
<div class="container">    
    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="{{ route('admin.toolUploadSave') }}" method="POST" enctype="multipart/form-data">       
    	{{ csrf_field() }}
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Chọn file...</span>
                    <input type="file" name="files" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Tải lên tất cả</span>
                </button>
                {{-- <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle"> --}}
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>
    <br>
    {{-- <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Demo Notes</h3>
        </div>
        <div class="panel-body">
            <ul>
                <li>The maximum file size for uploads in this demo is <strong>999 KB</strong> (default file size is unlimited).</li>
                <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo (by default there is no file type restriction).</li>
                <li>Uploaded files will be deleted automatically after <strong>5 minutes or less</strong> (demo files are stored in memory).</li>
                <li>You can <strong>drag &amp; drop</strong> files from your desktop on this webpage (see <a href="https://github.com/blueimp/jQuery-File-Upload/wiki/Browser-support">Browser support</a>).</li>
                <li>Please refer to the <a href="https://github.com/blueimp/jQuery-File-Upload">project website</a> and <a href="https://github.com/blueimp/jQuery-File-Upload/wiki">documentation</a> for more information.</li>
                <li>Built with the <a href="http://getbootstrap.com/">Bootstrap</a> CSS framework and Icons from <a href="http://glyphicons.com/">Glyphicons</a>.</li>
            </ul>
        </div>
    </div> --}}
</div>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>

@endsection
@push('js')   
	
	<script type="text/javascript">

		var url_upload = '{{ route('admin.toolUploadSave') }}';
	</script>
	<script id="template-upload" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
	    <tr class="template-upload fade">
	        <td>
	            <span class="preview"></span>
	        </td>
	        <td>
	            <p class="name">{%=file.name%}</p>
	            <strong class="error text-danger"></strong>
	        </td>
	        <td>
	            <p class="size">Processing...</p>
	            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
	        </td>
	        <td>
	            {% if (!i && !o.options.autoUpload) { %}
	                <button class="btn btn-primary start" disabled>
	                    <i class="glyphicon glyphicon-upload"></i>
	                    <span>Tải lên</span>
	                </button>
	            {% } %}
	            {% if (!i) { %}
	                <button class="btn btn-warning cancel">
	                    <i class="glyphicon glyphicon-ban-circle"></i>
	                    <span>Hủy</span>
	                </button>
	            {% } %}
	        </td>
	    </tr>
	{% } %}
	</script>
	<script id="template-download" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		    <tr class="template-download fade">
		        <td>
		            <span class="preview">
		                {% if (file.thumbnailUrl) { %}
		                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
		                {% } %}
		            </span>
		        </td>
		        <td>
		            <p class="name">
		                {% if (file.url) { %}
		                	<input type="text" value="{%=file.name%}">		                    
		                {% } else { %}
		                    <span>{%=file.name%}</span>
		                {% } %}
		            </p>
		            {% if (file.error) { %}
		                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
		            {% } %}
		        </td>
		        <td>
		            <span class="size">{%=o.formatFileSize(file.size)%}</span>
		        </td>
		        <td>
		            {% if (file.deleteUrl) { %}
		                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
		                    <i class="glyphicon glyphicon-trash"></i>
		                    <span>Delete</span>
		                </button>		                
		            {% } else { %}
		                <button class="btn btn-warning cancel">
		                    <i class="glyphicon glyphicon-ban-circle"></i>
		                    <span>Cancel</span>
		                </button>
		            {% } %}
		        </td>
		    </tr>
		{% } %}
</script>
	<script src="{{ web_asset('public/plugin/upload/js/vendor/jquery.ui.widget.js') }}"></script>

	<!-- The Templates plugin is included to render the upload/download listings -->	
	<script src="{{ web_asset('public/plugin/upload/js/tmpl.min.js') }}"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->	
	<script src="{{ web_asset('public/plugin/upload/js/load-image.all.min.js') }}"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->	
	<script src="{{ web_asset('public/plugin/upload/js/canvas-to-blob.min.js') }}"></script>

	<!-- blueimp Gallery script -->
	<script src="{{ web_asset('public/plugin/upload/js/jquery.blueimp-gallery.min.js') }}"></script>

	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script src="{{ web_asset('public/plugin/upload/js/jquery.iframe-transport.js') }}"></script>

	<!-- The basic File Upload plugin -->
	<script src="{{ web_asset('public/plugin/upload/js/jquery.fileupload.js') }}"></script>
	{{-- <script src="js/jquery.fileupload.js"></script> --}}
	<!-- The File Upload processing plugin -->
	<script src="{{ web_asset('public/plugin/upload/js/jquery.fileupload-process.js') }}"></script>
	{{-- <script src="js/jquery.fileupload-process.js"></script> --}}
	<!-- The File Upload image preview & resize plugin -->
	<script src="{{ web_asset('public/plugin/upload/js/jquery.fileupload-image.js') }}"></script>
	{{-- <script src="js/jquery.fileupload-image.js"></script> --}}
	<!-- The File Upload audio preview plugin -->
	<script src="{{ web_asset('public/plugin/upload/js/jquery.fileupload-audio.js') }}"></script>
	{{-- <script src="js/jquery.fileupload-audio.js"></script> --}}
	<!-- The File Upload video preview plugin -->
	<script src="{{ web_asset('public/plugin/upload/js/jquery.fileupload-video.js') }}"></script>
	{{-- <script src="js/jquery.fileupload-video.js"></script> --}}
	<!-- The File Upload validation plugin -->
	<script src="{{ web_asset('public/plugin/upload/js/jquery.fileupload-validate.js') }}"></script>
	{{-- <script src="js/jquery.fileupload-validate.js"></script> --}}
	<!-- The File Upload user interface plugin -->
	<script src="{{ web_asset('public/plugin/upload/js/jquery.fileupload-ui.js') }}"></script>
	{{-- <script src="js/jquery.fileupload-ui.js"></script> --}}
	<!-- The main application script -->
	<script src="{{ web_asset('public/plugin/upload/js/main.js') }}"></script>
	{{-- <script src="js/main.js"></script> --}}

@endpush