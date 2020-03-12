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
                            {{--<h4>Tổng số thành viên : {{ number_format(count($var['users'])) }}</h4>--}}
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên</th>
                                            <th>Ngày học đầu tiên</th>
                                            <th>Ngày học gần nhất</th>
                                            <th>Số lần làm</th>
                                            <th>Đã điểm cao nhất</th>
                                            <th>Điểm lần gần nhất</th>
                                            <th>Đã đủ điểu kiện</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['examUsers'])
                                        @foreach($var['examUsers'] as $key => $examUser)
                                            <tr class="tr">
                                                <td>{{(request('page')*15) + $key + 1}}</td>
                                                <td>
                                                    <p>
                                                        @if(!empty($examUser->user->avatar))
                                                            <img src="{{ asset($examUser->user->avatar) }}" class="" style="width: 40px; height: 40px;">
                                                        @endif <strong>{{ $examUser->user->full_name }}</strong>
                                                    </p>
                                                    <p><strong>Email:</strong> {{ $examUser->user->email }}</p>
                                                    <p><strong>Phone:</strong> {{ $examUser->user->phone }}</p>
                                                </td>
                                                <td  style="text-align: center;">{{date('d-m-Y h:i', strtotime($examUser->created_at))}}</td>
                                                <td  style="text-align: center;">{{date('d-m-Y h:i', strtotime($examUser->last_at))}}</td>
                                                <td  style="text-align: center;">{{ $examUser->turn}}</td>
                                                <td>
                                                    <p><strong>Điểm:</strong> {{$examUser->highest_score}}</p>
                                                    <p><strong>Thời gian:</strong> {{$examUser->doing_time}}</p>
                                                </td>
                                                <td  style="text-align: center;">{{$examUser->score}}</td>
                                                <td  style="text-align: center;">
                                                    @if($examUser->exam->min_score <= $examUser->highest_score)
                                                        <img src="{{ web_asset('public/images/course/icon/icon_check.png') }}">
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>

                                </table>
                                <div class="pagination">
                                    {{ $var['examUsers']->links('vendor.pagination.default') }}
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