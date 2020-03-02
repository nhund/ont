@if(count($var['feedbacks']) > 0)
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th width="50">STT</th>
            <th width="100">Thành viên</th>
            <th width="100">Tiêu đề</th>
           <th width="100">Nội dung</th>
            <th width="100">Câu hỏi</th>                                            
            <th width="100">Bài tập</th>
            <th width="180">Trạng thái</th>
            <th width="150">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if($var['feedbacks'])
        @foreach($var['feedbacks'] as $key => $feedback)
        <tr class="tr">  
            <td>{{ $loop->iteration  }}</td> 
            <td>
                {{ $feedback->user->name_full }}
                <p>{{ $feedback->email }} </p>
            </td>                         
            <td>{{ $feedback->title }}</td>
            <td>{{ $feedback->content }}</td>
            <td>{{ $feedback->question->question }}</td>
            <td><a href="{{route('lesson.detail', ['id' =>  $feedback->lesson->id ?? '' ])}}">{{ $feedback->lesson->name ?? '' }}</a></td>
            <td>
                @if($feedback->status == \App\Models\Feedback::STATUS_EDIT)
                <p><span style="color: #5cb85c;font-weight: bold;">Đã sửa: </span>{{ date('d-m-Y H:i',$feedback->update_date ) }}</p>
                @endif
                @if($feedback->status == \App\Models\Feedback::STATUS_NOT_EDIT)
                <span style="color: #c9302c; font-weight: bold;">Chưa sửa</span>
                @endif
                <p><strong>Ngày tạo:</strong> {{ date('d-m-Y H:i',$feedback->create_date ) }}</p>
            </td>
            <td>
                <a target="_blank" href="https://mail.google.com/mail/u/0/#inbox?compose=new" class="btn btn-default btn-xs btn-label" style="margin-bottom:5px "><i class="fa fa-envelope"></i>Trả lời email</a>
                <a href="{{ route('admin.feedback.editQuestion',['id'=>$feedback->question_id,'feedback_id'=>$feedback->id]) }}" class="btn btn-default btn-xs btn-label"><i class="fa fa-pencil"></i>Sửa</a>
                <a onclick="bookmark(`{{$feedback->question_id}}`, this)" class="btn {{$feedback->bookmark ? 'btn-success bookmarked' : 'btn-default'}} btn-xs btn-label"><i class="fa fa-bookmark"></i>Bookmark</a>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>

</table>
<div class="pagination">
    {{ $var['feedbacks']->links('vendor.pagination.default') }}
</div>
@else 
    <span>Không có phản hồi</span>
@endif