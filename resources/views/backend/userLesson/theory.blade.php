@extends('backend.layout')
@section('title', 'Dashboard')
@push('css')

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
                            <form action="{{ route('admin.user.index') }}" id="form_search_user" class="form-inline mb10" method="GET">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" value="{{ isset($var['params']['full_name'])?$var['params']['full_name']:'' }}" name="key_search" autocomplete="off" placeholder="#Họ tên, mail, sđt" class="form-control">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel">
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th>STT</th>
                                            <th>Tên</th>
                                            <th>Ngày học đầu tiên</th>
                                            <th>Ngày học gần nhất</th>
                                            <th>Đã học</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['users'])
                                        @foreach($var['users'] as $key => $userCourse)
                                            <tr class="tr">
                                                <td>{{(request('page')*15) + $key + 1}}</td>
                                                <td>
                                                    <p>
                                                        @if(!empty($userCourse->user->avatar))
                                                            <img src="{{ asset($userCourse->user->avatar) }}" class="" style="width: 40px; height: 40px;">
                                                        @endif {{ $userCourse->user->school->name }}
                                                    </p>
                                                    <p>{{ $userCourse->user->email }}</p>
                                                    <p>{{ $userCourse->user->phone }}</p>
                                                </td>
                                                <td style="text-align: center;">
                                                    @if($userCourse->lesson && $userCourse->lesson->create_at)
                                                        {{date('d-m-Y', $userCourse->lesson->create_at)}}
                                                    @endif
                                                </td>
                                                <td  style="text-align: center;">
                                                    @if($userCourse->lesson && $userCourse->lesson->updated_at)
                                                        {{date('d-m-Y h:i:s', strtotime($userCourse->lesson->updated_at))}}
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">
                                                    @if($userCourse->lesson && $userCourse->lesson->pass_ly_thuyet)
                                                        <img src="{{ web_asset('public/images/course/icon/icon_check.png') }}">
                                                    @endif
                                                </td>
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