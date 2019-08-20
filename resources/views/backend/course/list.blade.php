<div class="table-vertical">
    <table class="table">
        <thead>
            <tr>
                <th width="50px"></th>
                <th width="70%" class="pleft0">Nội dung khóa học</th>
                <th>Số lượng</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @if ($var['course_lesson'])
                @foreach($var['course_lesson'] as $cl)
                    @if (isset($cl['parent_id']) && !$cl['parent_id'])
                        <tr class="row-doc" onclick="window.location.href='{{ route('lesson.detail', ['id' => $cl['id']]) }}'">
                            <th class="col-td">
                                <div class="topic_icon_col" style="background-color: rgb(218, 55, 55);"></div>
                                <div class="topic_icon new_style">{{ $loop->iteration }}</div>
                            </th>
                            <td class="td-infor">
                                <span class="@if ($cl['is_exercise']) sub-name-ex @else sub-name @endif">
                                    {{ $loop->iteration }}. {{ $cl['name'] }}
                                </span>
                            </td>
                            <td>{{ isset($cl['sub'])?count($cl['sub']):0 }} bài</td>
                            <td>@if ($cl['status'] == 1) <span class="color-green">Đã phát hành</span>@else Chưa phát hành @endif</td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">
                        Chưa có bài học
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>