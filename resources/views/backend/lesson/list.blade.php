<div class="table-vertical">
    <table class="table">
        <thead>
            <tr>
                <th width="50px"></th>
                <th width="70%" class="pleft0">Nội dung bài học</th>
                <th>Số lượng</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($course_lesson[$lesson->id]) && isset($course_lesson[$lesson->id]['sub']))
            @foreach($course_lesson[$lesson->id]['sub'] as $cl)
            @if ($cl)
            <tr class="row-doc" onclick="window.location.href='{{ route('lesson.detail', ['id' => $cl]) }}'">
                <th class="col-td">
                    <div class="topic_icon_col" style="background-color: rgb(218, 55, 55);"></div>
                    <div class="topic_icon new_style">{{ $loop->iteration }}</div>
                </th>
                <td class="td-infor">
                    <span class="@if($course_lesson[$cl]['is_exercise'] && $course_lesson[$cl]['type'] == \App\Models\Lesson::LESSON) sub-name-ex
                                @elseif($course_lesson[$cl]['type'] == \App\Models\Lesson::EXAM) sub-name-exam @else sub-name @endif">
                        {{ $loop->iteration }}. {{ $course_lesson[$cl]['name'] }}
                    </span>
                </td>
                <td>{{ isset($course_lesson[$cl]['sub'])?count($course_lesson[$cl]['sub']):0 }} bài</td>
                <td>@if ($course_lesson[$cl]['status'] == 1) <span class="color-green">Đã phát hành</span>@else Chưa phát hành @endif</td>
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