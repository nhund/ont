@extends('backend.layout')
@section('title', 'Danh sách phản hồi')
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
                            <form id="form_search_feedback" action="{{ route('admin.feedback.index') }}" class="form-inline mb10" method="GET">
                                <div class="row">
                                    <div class="col-md-12">                                                                            
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input autocomplete="true" type="text" class="form-control" name="create_date" value="{{ isset($data['create_date'])?$data['create_date']:'' }}" placeholder="Ngày tạo" id="daterangepicker1">
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
                                    <tr>
                                        <th width="50">STT</th>
                                        <th width="100">Thành viên</th>
                                        <th width="100">Tiêu đề</th>
                                        <th width="100">Nội dung</th>
                                        <th width="100">Câu hỏi</th>
                                        <th width="160">Khóa học</th>
                                        <th width="100">Trạng thái</th>
                                        <th width="150">Hành động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['feedbacks'])
                                        @foreach($var['feedbacks'] as $key => $feedback)
                                            <tr class="tr">
                                                <td>{{ $key+1 }}</td> 
                                                <td>
                                                    <p><strong>Tên:</strong> {{ $feedback->user->name_full }}</p>
                                                    <p><strong>Email:</strong> {{ $feedback->email }}</p>
                                                </td> 
                                                <td>
                                                    {{ $feedback->title }} {{$feedback->question_id}} {{$feedback->id}}
                                                </td>
                                                <td>
                                                    {{ $feedback->content }}
                                                </td>
                                                <td>
                                                    {{ $feedback->question->question }}
                                                </td>
                                                <td>
                                                    <p><a target="_blank" href="{{ route('course.detail',['id'=>$feedback->course_id]) }}">{{ $feedback->course->name }}</a></p>
                                                    <p><strong>Nguồn: </strong><a href="{{route('lesson.detail', ['id' =>  $feedback->lesson->id ?? '' ])}}">{{ $feedback->lesson->name ?? '' }}</a></p>
                                                    <p>({{ date('d-m-Y H:i',$feedback->create_date ) }})</p>
                                                </td>
                                                <td>
                                                    @if($feedback->status == \App\Models\Feedback::STATUS_EDIT)
                                                        <span style="color: #5cb85c;font-weight: bold;">Đã sửa</span>
                                                        <p>{{ date('d-m-Y H:i',$feedback->update_date ) }}</p>
                                                    @endif
                                                    @if($feedback->status == \App\Models\Feedback::STATUS_NOT_EDIT)
                                                        <span style="color: #c9302c; font-weight: bold;">Chưa sửa</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a target="_blank" href="https://mail.google.com/mail/u/0/#inbox?compose=new" class="btn btn-default btn-xs btn-label"><i class="fa fa-envelope"></i>Trả lời email</a>
                                                    <a href="{{ route('admin.feedback.editQuestion',['id'=>$feedback->question_id,'feedback_id'=>$feedback->id]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-pencil"></i>Sửa</a>

                                                    @if($feedback->question->parent_id == 0)
                                                        <a onclick="bookmark(`{{$feedback->question_id}}`, this)" class="btn {{$feedback->bookmark ? 'btn-success bookmarked' : 'btn-default'}} btn-xs btn-label"><i class="fa fa-bookmark"></i>Bookmark</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                <div class="pagination">
                                    {{ $var['feedbacks']->links('vendor.pagination.default') }}
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
    <script src="{{ asset('public/plugin/form-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('public/plugin/form-daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript">
        const book_mark_url     = '{{ route('user.question.bookMark') }}';

        $(document).ready(function() {
            $('#daterangepicker1').daterangepicker({ format: 'DD/MM/YYYY' });
            $('body').on('click','.daterangepicker .applyBtn',function(event) {
                $('#form_search_feedback').submit();
            });
            $('.icheck input').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });            
        });


    </script>
@endpush