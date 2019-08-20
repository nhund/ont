@extends('backend.layout')
@section('title', 'Thêm menu')
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div id="panel-advancedoptions">
                    <div class="panel panel-default" data-widget-editbutton="false">
                        <div class="panel-heading">
                            <h2>Thêm menu</h2>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <form method="POST" action="{{ route('admin.menu.save') }}" class="form-horizontal row-border">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">Tiêu đề</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="name" placeholder="Tiêu đề" value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">Menu cha</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="parent_id">
                                                    <option value="">Chọn menu cha</option>
                                                    @if(count($var['menu_all']) > 0)
                                                        @foreach($var['menu_all'] as $menu_all)
                                                            <option value="{{ $menu_all->id }}">{{ $menu_all->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">Url</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="url" placeholder="Url" value="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="control-label col-sm-1">Trạng thái</label>
                                            <div class="col-sm-2 tabular-border">
                                                <select class="form-control" name="status">
                                                    <option value="{{ App\Models\Menu::STATUS_ON }}">public</option>
                                                    <option value="{{ App\Models\Menu::STATUS_OFF }}">private</option>
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
@push('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            //Bootstrap Switch
            $('input.bootstrap-switch').bootstrapSwitch();
        });
    </script>
@endpush