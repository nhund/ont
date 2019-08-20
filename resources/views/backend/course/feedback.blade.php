@extends('backend.layout')
@section('title', $page_title)
@push('css')
    <link href="{{asset('/public/admintrator/assets/css/animate.min.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('/public/css/comment.css')}}" type="text/css" rel="stylesheet">
@endpush
@push('js')
    <script src="{{ asset('/public/admintrator/assets/js/bootstrap-notify.min.js?ver=1') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/form-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/public/js/detail/comment.js') }}"></script>
    <script>
       var comment_add = '{{ route('user.course.comment.add') }}';
       var comment_delete = '{{ route('user.course.comment.delete') }}';
       var rating = '{{ route('user.course.rating') }}';
       var course_buy = '{{ route('user.course.buy') }}';
    </script>
@endpush
@section('content')
    @include('include.backend.breadcrumb')
<div class="table-responsive">
    <div class="form-group well">
        <div class="col-sm-1">
            <img class="user_img"
                 @if(!Auth::user()->avatar) src="{{ asset('public/images/avatar-default.png') }}" @else src="{{ asset(Auth::user()['avatar']) }}" @endif>
        </div>
        <div class="input-group col-sm-11">
            <input type="hidden" name="course_id" value="{{ $course['id'] }}">
            <input type="text" name="comment_content" placeholder="Đăng cái gì đó..." class="form-control">
            <span class="input-group-btn">
                <a class="btn btn-primary" onclick="addComment(this, 0, '{{ $course['id'] }}')"><i class="fa fa-send-o"></i></a>
            </span>
        </div>
    </div>

    <ul id="comments-list" class="comments-list">
        @if(count($comments) > 0)
            @foreach ($comments as $comment)
                @include('course.detail.comment.comment')
            @endforeach
        @endif
    </ul>
</div>
@endsection