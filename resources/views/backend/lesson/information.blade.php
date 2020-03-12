<div class="row top10">
    <div class="col-md-6">
        <div class="panel panel-default panel-bod">
            <div class="panel-heading"><h2>Thông tin chung</h2></div>
            <div class="panel-body">
                <div class="table-responsive SourceSansProSemibold">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="50%" align="right" class="text-bold">Tổng số câu hỏi</td>
                                <td>{{ $questions->total() }} câu</td>
                            </tr>
                            <tr>
                                <td width="50%" align="right" class="text-bold">Đáp án trác nghiệm</td>
                                <td>
                                    @if($lesson->random_question == \App\Models\Lesson::TRAC_NGHIEM_ANSWER_RANDOM)
                                        Đảo ngẫu nhiên
                                    @else 
                                        Theo thứ tự
                                    @endif
                                </td>
                            </tr>
                            {{-- <tr>
                                <td width="50%" align="right" class="text-bold">Số người đã tham gia</td>
                                <td>{{ $user_course ? $user_course : 0 }}</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default panel-bod">
            <div class="panel-heading"><h2>Tiến độ khóa học</h2></div>
            <div class="panel-body">
                {{--<a href="{{ route('admin.course.listUser', ['id' => $lesson->course_id]) }}">Xem tiến độ</a>--}}
                <a href="{{ route('admin.userLesson.report.detail', ['lesson' => $lesson->id]) }}">  Xem tiến độ bài học</a>
            </div>
        </div>
    </div>
</div>

<div class="row top10">
	<div class="col-xs-12">
		<div class="panel panel-grape panel-bod">
			<div class="panel-heading">
				<h2>Câu hỏi</h2>
			</div>
			<div class="panel-body">
             {{-- <div class="col-sm-5 mb15">
                <select class="sltOpt form-control">
                    <option value="">Tổng số câu hỏi {{ $questions->total() }}</option>
                </select>
            </div> --}}
            <div class="col-sm-12">
             <div class="col-sm-8">&nbsp;</div>
             
         </div>
         @if ($questions)
         <table class="table mb0 top10">
            <tbody>
                @foreach($questions as $quest)
                <tr class="row-doc">
                    @if($quest->type == \App\Models\Question::TYPE_TRAC_NGHIEM_DON)
                        <td width="50%">{{ $loop->iteration }}. {!! $quest->question !!}</td>
                    @else
                        <td width="50%">{{ $loop->iteration }}. {!! $quest->content !!}</td>
                    @endif
                    <td>
                        @if ($quest->type == \App\Models\Question::TYPE_DIEN_TU)
                            @if ($quest->subs)
                                @foreach($quest->subs as $sub)
                                    <p>{{ $loop->iteration }}. {!! $sub->question !!}: {!! $sub->answer[0]->answer !!}</p>
                                @endforeach
                            @else
                                <p>{!! $quest->content !!}</p>
                            @endif
                        @elseif ($quest->type == \App\Models\Question::TYPE_TRAC_NGHIEM)
                            @if ($quest->subs)
                                @foreach($quest->subs as $sub)
                                    <div class="row col-sm-12">{{ $loop->iteration }}. {!! $sub->question !!}</div>
                                    @foreach($sub->answer as $ans)
                                        <div class="col-sm-6">
                                            @if($ans->status == 2)
                                                <span class="color-red">*</span> @endif {!! $ans->answer !!}
                                        </div>
                                    @endforeach
                                @endforeach
                            @else
                                <p>{!! $quest->content !!}</p>
                            @endif
                        @elseif ($quest->type == \App\Models\Question::TYPE_TRAC_NGHIEM_DON)
                            @foreach($quest->answer as $ans)
                                <div class="col-sm-6">
                                    @if($ans->status == 2)
                                        <span class="color-red">*</span> @endif {!! $ans->answer !!}
                                </div>
                            @endforeach
                        @else
                            <p>{!! $quest->question !!}</p>
                        @endif
                    </td>
                    <td>
                        <div class="question_edit" data-id="{{ $quest->id }}">
                            <a href="{{ route('admin.question.edit',['id'=>$quest->id]) }}">
                                <i class="fa fa-edit"></i>
                                Sửa
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-sm-4 pull-right">{{ $questions->render() }}</div>
        @endif
    </div>
</div>
</div>
</div>