@extends('backend.layout')
@section('title', 'Dashboard')
@push('css')
    <style type="text/css">
        td, th{
            vertical-align: middle;
        }
    </style>
    <link href="{{ asset('public/plugin/form-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css">

@endpush
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="{{ route('admin.user.add') }}" class="btn-primary btn">Thêm thành viên</a>
                        </div>
                        <div class="form-group">
                            <form action="{{ route('admin.user.index') }}" id="form_search_user" class="form-inline mb10" method="GET">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" value="{{ isset($var['params']['full_name'])?$var['params']['full_name']:'' }}" name="full_name" autocomplete="off" placeholder="#Họ tên" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" name="phone" value="{{ isset($var['params']['phone'])?$var['params']['phone']:'' }}" placeholder="#Số điện thoại" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" value="{{ isset($var['params']['email'])?$var['params']['email']:'' }}" name="email" placeholder="#email" autocomplete="off" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control" name="create_at" value="{{ isset($var['params']['create_at'])?$var['params']['create_at']:'' }}" placeholder="#Ngày đăng ký" autocomplete="off" id="daterangepicker1">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel">
                            <h4>Tổng số thành viên : {{ number_format(count($var['users'])) }}</h4>
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Tên</th>
                                        <th>Ngày học đầu tiên</th>
                                        <th>Ngày học gần nhất</th>
                                        <th>Số câu làm đúng gần nhất</th>
                                        <th>Số lượt làm đúng toàn bộ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['users'])
                                        @foreach($var['users'] as $key => $userCourse)
                                            <tr class="tr">
                                                <td>
                                                    <p>
                                                        @if(!empty($userCourse->user->avatar))
                                                            <img src="{{ asset($userCourse->user->avatar) }}" class="" style="width: 40px; height: 40px;">
                                                        @endif {{ $userCourse->user->school->name }}
                                                    </p>
                                                    <p>Email: {{ $userCourse->user->email }}</p>
                                                    <p>Phone: {{ $userCourse->user->phone }}</p>
                                                </td>
                                                <td  style="text-align: center;">
                                                    @if($userCourse->lesson && $userCourse->lesson->create_at)
                                                        {{date('d-m-Y', $userCourse->lesson->create_at)}}
                                                    @endif
                                                </td>
                                                <td  style="text-align: center;">
                                                    @if($userCourse->lesson && $userCourse->lesson->updated_at)
                                                        {{date('d-m-Y h:i:s', strtotime($userCourse->lesson->updated_at))}}
                                                    @endif
                                                </td>
                                                <td  style="text-align: center;">{{ $userCourse->correctQuestion}} / {{ $userCourse->didQuestion}}</td>
                                                <td  style="text-align: center;">{{ $userCourse->lesson ? $userCourse->lesson->turn_right : 0}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>

                                </table>
                                <div class="pagination">
                                    {{ $var['users']->links('vendor.pagination.default') }}
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