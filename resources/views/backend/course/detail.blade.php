@extends('backend.layout')
@section('title', $var['page_title'])
@push('css')
    <link href="{{asset('/public/admintrator/assets/css/animate.min.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('/public/css/comment.css')}}" type="text/css" rel="stylesheet">
    <link href="{{ web_asset('public/css/rating.css') }}" rel="stylesheet" type="text/css">
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
    @include('backend.include.breadcrumb',['var'=>$var['breadcrumb']])
    <div class="container-fluid">
        <div class="row">
            @include('include.backend.box_left',['course'=> $var['course'],'course_lesson'=>$var['course_lesson']])
            <div class="col-md-9">
                <div class="panel panel-gray">
                    <div class="panel-body mailbox-panel">
                        <section class="tabular">
                            <div class="message tabular-row">
                                <div class="tabular-cell col-sm-4">
                                    <img src="{{ $var['course']->avatar_thumb }}" style="max-width: 100%">
                                </div>
                                <div class="tabular-cell msg col-sm-6">
                                    <a href="#" class="msgee">{{ $var['course']->name }}</a>
                                    <p>Ngôn ngữ: Tiếng Việt</p>
                                    <p>Trạng thái :
                                        @if($var['course']->status == \App\Models\Course::TYPE_FREE_TIME) Miễn phí có thời hạn  @endif
                                        @if($var['course']->status == \App\Models\Course::TYPE_FREE_NOT_TIME) Miễn phí không thời hạn  @endif
                                        @if($var['course']->status == \App\Models\Course::TYPE_PUBLIC) Công khai  @endif
                                        @if($var['course']->status == \App\Models\Course::TYPE_APPROVAL) Cần xét duyệt  @endif
                                        @if($var['course']->status == \App\Models\Course::TYPE_PRIVATE) Riêng tư  @endif
                                    </p>
                                    <p>Học phí: <span class="color-red">@if($var['course']->is_free)
                                                Free @else {{number_format($var['course']->price,0,',','.')}} đ @endif</span>
                                    </p>
                                </div>
                                <div class="tabular-cell time">
                                    <div class=" pull-right">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.course.edit', ['id' => $var['course']->id]) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="fa fa-pencil"></i> Sửa
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <div class="panel-footer detail-footer">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h2>
                                        <ul class="nav nav-tabs">
                                            <li data-tab="description" class="active"><a href="#tab-des" data-toggle="tab"><span class="tabDes">Mô tả</span></a></li>
                                            <li data-tab="user" class=""><a href="{{ route('admin.course.listUser', ['id' => $var['course']->id]) }}" target="_blank"><i class="fa fa-group"></i><span class="">Thành viên</span></a></li>
                                            <li data-tab="assistant" class=""><a href="{{ route('admin.course.support.index', ['id' => $var['course']->id]) }}" target="_blank"><i class="fa fa-user"></i><span class="">Trợ giảng</span></a></li>
                                            <li data-tab="comment" class=""><a href="#tab-comment" data-toggle="tab"><span class="tabComment">Bình luận</span></a></li>
                                            <li data-tab="rate" class=""><a href="#tab-rate" data-toggle="tab"><img src="{{ asset('/public/images/course/icon/icon-star.png')}}" class="tab-des">Đánh giá</a></li>
                                            <li data-tab="feedback" class=""><a href="#tab-feedback" data-toggle="tab"><img src="{{ web_asset('public/images/course/icon/icon_flag.png') }}" class="tab-des">Phản hồi</a></li>
                                        </ul>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                    <div class="tab-content">
                                        <div data-tab="description" class="tab-pane active" id="tab-des">
                                            <p>{!! $var['course']->description !!}</p>
                                            @include('backend.course.list')
                                        </div>
                                        <div data-tab="user" class="tab-pane" id="tab-user">
                                        </div>
                                        <div  data-tab="comment" class="tab-pane" id="tab-comment">
                                            <div class="comments-container">
                                                <div id="comment" class="box-info">
                                                  <div class="container-fluid">
                                                     <div class="row">
                                                        @include('course.detail.comment.comment_list')
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                        </div>
                                        <div data-tab="rate" class="tab-pane" id="tab-rate">
                                            <p>Đánh giá</p>
                                            @include('course.detail.rating',['rating'=>$var['rates'],'rating_value'=>$var['rating_value'],'rating_avg'=>$var['rating_avg'],'user_rating'=>$var['user_rating']])
                                        </div>
                                        <div data-tab="feedback" class="tab-pane" id="tab-feedback">
                                            @include('backend.course.feedback.feedback')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('include.backend.detail_modal',['course'=>$var['course']])
@endsection

@push('js')
    <script>
        const url = location.search;
        let searchParams = new URLSearchParams(url);
        const type = searchParams.get('type');
        if (type) {
            $('[data-tab]').removeClass('active');
            $(`[data-tab=${type}]`).addClass('active');
        }
    </script>
@endpush