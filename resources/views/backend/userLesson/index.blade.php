@extends('backend.layout')
@section('title', 'Dashboard')
@push('css')


@endpush
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <form action="" id="form_search_user" class="form-inline mb10" method="GET">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" value="{{ request('key_search') }}" name="key_search" autocomplete="off" placeholder="#Họ tên, mail, sđt..." class="form-control">
                                            </div>
                                        </div>
                                        {{--<div class="col-md-3">--}}
                                            {{--<div class="form-group">--}}
                                                {{--<select class="form-control" name="turn_right">--}}
                                                    {{--<option value="">-- Sắp sếp số lượt đúng --</option>--}}
                                                    {{--<option {{request('turn_right') === 'ASC' ? 'selected' : ''}} value="ASC">Tăng dần</option>--}}
                                                    {{--<option {{request('turn_right') === 'DESC' ? 'selected' : ''}} value="DESC">Giảm dần</option>--}}
                                                {{--</select>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel">
                            <h4>Tổng số thành viên : {{ count($var['totalUser']) }}</h4>
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên</th>
                                        <th>Ngày làm đầu tiên</th>
                                        <th>Ngày làm gần nhất</th>
                                        <th>Số câu làm đúng gần nhất</th>
                                        <th>Số lượt làm đúng toàn bộ</th>
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
                                                        @endif <strong>{{ $userCourse->user->full_name }}</strong>
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