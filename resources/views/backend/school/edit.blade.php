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
                            <h2>Cập nhật : {{ $var['school']->name }}</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <form method="POST" action="{{ route('admin.school.update') }}" class="form-horizontal row-border" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $var['school']->id }}">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tên trường</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="name" placeholder="Tên trường" class="form-control" value="{{ $var['school']->name }}">
                                            </div>
                                        </div>                                                                          
                                                                            
                                        <div class="form-group pb0">
                                            <label for="" class="control-label col-sm-2">Trạng thái</label>
                                            <div class="col-sm-2 tabular-border">
                                                <select class="form-control" name="status">                                                                   
                                                    <option @if(App\Models\School::STATUS_ON == $var['school']->status) selected @endif value="{{ App\Models\School::STATUS_ON }}">public</option>
                                                    <option @if(App\Models\School::STATUS_OFF == $var['school']->status) selected @endif value="{{ App\Models\School::STATUS_OFF }}">private</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-8 col-sm-offset-2">
                                                    <input type="submit" class="btn-primary btn" value="Save">
                                                    <a href="{{ route('admin.school.index')}}" class="btn-default btn">Cancel</a>
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