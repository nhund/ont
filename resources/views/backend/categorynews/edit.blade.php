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
                                    <form method="POST" action="{{ route('admin.news.update') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $var['category']->id }}">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tiêu đề</label>
                                            <div class="col-sm-8">
                                            <input type="text" name="name" value="{{ $var['category']->name }}" placeholder="Tiêu đề" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group pb0">
                                            <label for="" class="control-label col-sm-2">Trạng thái</label>
                                            <div class="col-sm-2 tabular-border">
                                                <select class="form-control" name="status">
                                                    <option @if($var['category']->status == \App\Models\CategoryNews::STATUS_ON) selected @endif value="{{ \App\Models\CategoryNews::STATUS_ON }}">Hiển thị</option>
                                                    <option @if($var['category']->status == \App\Models\CategoryNews::STATUS_OFF) selected @endif  value="{{ \App\Models\CategoryNews::STATUS_OFF }}">Ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <input type="submit" class="btn-primary btn" value="Save">
                                                    <a href="{{ route('admin.news.index') }}" class="btn-default btn">Cancel</a>
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