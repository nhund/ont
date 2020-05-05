@extends('backend.layout')
@section('title', $page_title)
@push('css')
    <link href="{{asset('/public/admintrator/assets/css/animate.min.css')}}" type="text/css" rel="stylesheet">
@endpush
@push('js')
    <script src="{{ asset('/public/admintrator/assets/js/bootstrap-notify.min.js?ver=1') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript">
        $('.from_time').datepicker({
            todayHighlight: true,
            format: 'dd-mm-yyyy',
            closeOnConfirm: false
        });
        $('.to_time').datepicker({
            todayHighlight: true,
            format: 'dd-mm-yyyy',
            closeOnConfirm: false
        });
        function changeUserStatus(id, course_id, val) {
            $.ajax({
                url: '/admin/course/changeUserStatus',
                data: { id: id, _token: '{{ csrf_token() }}', course_id:course_id, val:val},
                dataType: 'json',
                method: 'POST',
                success: function (response) {
                    if (response.status) {
                        showSuccessMsg(response.msg);
                    } else {
                        showErrorMsg(response.msg);
                    }
                }
            });
        }
    </script>
@endpush
@section('content')
    @include('backend.include.breadcrumb',['var'=>$breadcrumb])
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-midnightblue">
                    <div class="panel-heading">
                        <h2>{{ $page_title }} </h2>
                        {{-- <div class="pull-right">
                            <a class="btn btn-primary" href="#addUser" data-toggle="modal">Thêm mới</a>
                        </div> --}}
                    </div>
                    <div class="panel-body">
                        <form action="" method="GET">
                            <div class="row">
                                 <div class="col-md-12">
                                     <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" autocomplete="off" name="from_time" placeholder="Từ ngày" class="form-control from_time" value="{{ $from_time ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" autocomplete="off" name="to_time" placeholder="Đến ngày" class="form-control to_time" value="{{ $to_time ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" autocomplete="off" name="user_search" placeholder="Nhập tên thành viên hoặc email" class="form-control" value="{{ $user_search ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select class="form-control" name="status">
                                                    <option value="">Trạng thái</option>
                                                    <option @if(isset($status) && $status == \App\Models\UserCourse::STATUS_APPROVAL) selected @endif value="{{ \App\Models\UserCourse::STATUS_APPROVAL }}">Chờ duyệt</option>
                                                    <option @if(isset($status) && $status == \App\Models\UserCourse::STATUS_ON) selected @endif value="{{ \App\Models\UserCourse::STATUS_ON }}">Đang học</option>
                                                    <option @if(isset($status) && $status == \App\Models\UserCourse::STATUS_OFF) selected @endif value="{{ \App\Models\UserCourse::STATUS_OFF }}">Khóa</option>
                                                </select>
                                            </div>
                                        </div>
                                         <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                 </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <h4>Tổng số thành viên : {{ number_format($users->total()) }}</h4>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="10">STT</th>
                                    <th width="200">Họ Tên</th>
                                    <th width="200">Trạng thái</th>
                                    <th width="100">Tham gia</th>
                                    <th width="150">Học gần nhất</th>
                                    <th width="200">Tổng câu đã học</th>
                                    <th width="200">Tổng câu làm đúng</th>
                                    <th width="400">Tổng quan</th>
                                    {{--<th width="200">Lượt làm max</th>--}}
                                    {{--<th width="200">Lượt làm min</th>--}}
                                    {{--<th width="200">Lượt làm trung bình</th>--}}
                                    {{-- <th>Vai trò</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                @if ($users->total())
                                    @foreach($users as $user)
                                       {{--  @if (file_exists(public_path().'/document/file/'.$user->document)) --}}
                                            <tr class="row-doc">
                                                <td>{{ $loop->iteration  }}</td>
                                                <td align="left">
                                                    <img class="user_img" src="{{ !empty($this->avatar) ? web_asset($this->avatar) : web_asset('public/images/avatar-default.png')  }}"     >
                                                    {{ $user->full_name }}
                                                    <p>{{ $user->email }}</p>
                                                </td>                                                
                                                <td>
                                                    @if ($user->id != Auth::user()['id'])
                                                        <select class="form-control" onchange="changeUserStatus('{{ $user->id }}', '{{ $course->id }}', this.value)">
                                                            <option @if($user->user_course_status == \App\Models\UserCourse::STATUS_APPROVAL) selected @endif value="{{ \App\Models\UserCourse::STATUS_APPROVAL}}">Chờ duyệt</option>
                                                            <option @if($user->user_course_status == \App\Models\UserCourse::STATUS_ON) selected @endif value="{{ \App\Models\UserCourse::STATUS_ON}}">Đang học</option>
                                                            <option @if($user->user_course_status == \App\Models\UserCourse::STATUS_OFF) selected @endif value="{{ \App\Models\UserCourse::STATUS_OFF}}">Khóa</option>
                                                        </select>
                                                    @endif
                                                </td>
                                                <td>{{ date('d/m/y', $user->created_at) }}</td>
                                                <td>
                                                    @if(isset($user->learn_last_time->update_time))
                                                        {{ date('d/m/y', $user->learn_last_time->update_time) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ number_format($user->userLearn)}}/ {{ number_format($course_questions)}}
                                                </td>
                                                <td>
                                                    {{ number_format($user->userLearn_true)}}/ {{ number_format($course_questions)}}
                                                </td>
                                                <td>
                                                    @foreach($course_lessons as $course_lesson)
                                                        @if(isset($user->user_lesson_all[$course_lesson]))
                                                            {{ $user->user_lesson_all[$course_lesson]->count }}
                                                        @else 
                                                            0
                                                        @endif
                                                        /
                                                    @endforeach
                                                </td>
                                                {{--<td> --}}
                                                    {{--{{ isset($user->learn_lesson_max) ? number_format($user->learn_lesson_max) : '' }}--}}
                                                {{--</td>--}}
                                                {{--<td> --}}
                                                    {{--{{ isset($user->learn_lesson_min) ? number_format($user->learn_lesson_min) : '' }}--}}
                                                {{--</td>--}}
                                                {{--<td>--}}
                                                    {{--{{ isset($user->learn_lesson_avg) ? number_format($user->learn_lesson_avg) : '' }}--}}
                                                {{--</td>--}}
                                                {{-- <td>
                                                    @if ($user->id == Auth::user()['id']) <span class="color-green">Quản trị lớp học</span> @else Học viên @endif
                                                </td> --}}
                                            </tr>
                                        {{-- @endif --}}
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Chưa có thành viên
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            {{ $users->appends(Request::except('page'))->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.course.user.user_modal')
@endsection