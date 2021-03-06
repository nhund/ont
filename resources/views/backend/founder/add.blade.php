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
                            <h2>Thêm Founder</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <form method="POST" action="{{ route('admin.founder.save') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tiêu đề</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="title" placeholder="Tiêu đề" class="form-control">
                                            </div>
                                        </div>                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Họ tên</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="name" placeholder="Họ tên" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Ảnh đại diện</label>
                                            <div class="col-sm-3">
                                                <div class="fileinput fileinput-new" style="width: 100%;" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail mb20" data-trigger="fileinput" style="width: 200px; height: 200px;">
                                                        <img class="preview_img" style="display: none" src="">
                                                    </div>
                                                    <div>
                                                        <input id="ckfinder-input-1" name="img" type="text" style="display: none" class="form-control">
                                                        <button id="ckfinder-popup-1" type="button" class="btn btn-info">Chọn ảnh</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Giới thiệu</label>
                                            <div class="col-sm-8">
                                                <textarea rows="4" class="note-codable form-control" id="editor" name="content"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group pb0">
                                            <label for="" class="control-label col-sm-2">Trạng thái</label>
                                            <div class="col-sm-2 tabular-border">
                                                <select class="form-control" name="status">                                                                    
                                                    <option value="{{ App\Models\Founder::STATUS_ON }}">Published</option>
                                                    <option value="{{ App\Models\Founder::STATUS_OFF }}">Draft</option>
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
            //Bootstrap Switch
            // $('input.bootstrap-switch').bootstrapSwitch();
        });
    </script>
@endpush