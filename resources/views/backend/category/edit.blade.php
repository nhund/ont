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
                                    <form method="POST" action="{{ route('admin.category.update') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $var['category']->id }}">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tiêu đề</label>
                                            <div class="col-sm-8">
                                            <input type="text" name="name" value="{{ $var['category']->name }}" placeholder="Tiêu đề" class="form-control">
                                            </div>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label class="col-sm-2 control-label">Mô tả ngắn</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="des" value="{{ $var['slider']->des }}" placeholder="Mô tả ngắn" class="form-control">
                                            </div>
                                        </div> --}}
                                        {{-- <div class="form-group">
                                            <label class="col-sm-2 control-label">Url</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="url" value="{{ $var['slider']->url }}" placeholder="Url khi click vào ảnh (Không bắt buộc)" class="form-control">
                                            </div>
                                        </div> --}}
                                        {{-- <div class="form-group">
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
                                        </div> --}}
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Loại chuyên mục</label>
                                            <div class="col-sm-2 tabular-border">
                                                <select name="type" class="form-control">
                                                    <option @if($var['category']->type == 0) selected @endif value="0">Chọn loại chuyên mục</option>
                                                    <option @if($var['category']->type == 1) selected @endif value="1">Post</option>
                                                    <option @if($var['category']->type == 2) selected @endif value="2">News</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group pb0">
                                            <label for="" class="control-label col-sm-2">Trạng thái</label>
                                            <div class="col-sm-2 tabular-border">
                                                <select class="form-control" name="status">
                                                    <option @if($var['category']->status == \App\Models\Category::STATUS_ON) selected @endif value="{{ \App\Models\Category::STATUS_ON }}">Hiển thị</option>
                                                    <option @if($var['category']->status == \App\Models\Category::STATUS_OFF) selected @endif  value="{{ \App\Models\Category::STATUS_OFF }}">Ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <input type="submit" class="btn-primary btn" value="Save">
                                                    <a href="{{ route('admin.category.index') }}" class="btn-default btn">Cancel</a>
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
    
@endpush