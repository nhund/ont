<div class="col-md-3">
    <div class="panel">
        <div class="panel-body panel-no-padding">
            <a class="mailbox-msg-list" href="{{ route('course.detail', ['id' => $course['id']]) }}">
                <div class="mailbox-msg-list-item col-sm-10">
                    <span class="name avatar-course">{{ $course['name'] }}</span>                                        
                </div>
                
                <div class="col-sm-2 btn-create">
                    <a class="btn btn-primary btn-sm btn-circle" data-toggle="dropdown"><i class="fa fa-pencil"></i></a>
                    <ul class="dropdown-menu pull-right">
                        <li><a onclick="showModalAddLesson(0, '{{ $course['name'] }}', 'lesson')">Tạo bài giảng</a></li>
                        <li><a onclick="showModalAddExersice(0, 'exam')">Tạo bài Kiểm tra</a></li>
                        <li><a onclick="showModalAddLevel2(0, '{{ $course['name'] }}', 'level2')">Tạo bài level 2</a></li>
                    </ul>
                </div>
            </a>
            <a target="_blank" href="{{ route('course.learn',['title'=>str_slug($course['name']),'id'=>$course['id']]) }}">Làm bài tập</a>
            <a style="float: right;" href="{{ route('lesson.order',['id'=>$course['id']]) }}"><i class="	fa fa-arrows"></i>Sắp xếp</a>
            @if ($course_lesson)
                <ul class="mailbox-msg-list">
                    @foreach($course_lesson as $cl)

                        <!-- bài học -->
                        @if (isset($cl['parent_id']) && !$cl['parent_id'])
                            <li>
                                <div class="col-sm-12 @if(isset($lesson) && $cl['id'] == $lesson['id']) active-row @endif">
                                    <a href="{{ route('lesson.detail', ['id' => $cl['id']]) }}">
                                        <div class="mailbox-msg-list-item col-sm-10">
                                            <span class="name
                                                @if (isset($cl['is_exercise']) && $cl['is_exercise'] && $cl['type'] == \App\Models\Lesson::LESSON) sub-name-ex sd
                                                @elseif  (isset($cl['type']) && $cl['type'] == \App\Models\Lesson::EXAM) sub-name-exam
                                                @else sub-name @endif">{{ $cl['name'] }}
                                            </span>
                                        </div>
                                        @if(isset($lesson) && $cl['id'] == $lesson['id'])
                                            @if( $lesson['type'] == \App\Models\Lesson::LESSON)
                                                <div class="col-sm-2 btn-create">
                                                    <a class="btn btn-primary btn-sm btn-circle" data-toggle="dropdown"><i class="fa fa-pencil"></i></a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li><a onclick="showModalAddLesson('{{ $cl['id'] }}', '{{ $cl['name'] }}')">Tạo lý thuyết</a></li>
                                                        <li><a onclick="showModalAddExersice('{{ $cl['id'] }}', 'lesson')">Tạo bài tập</a></li>
                                                        <li><a onclick="showModalAddExersice('{{ $cl['id'] }}', 'exam', )">Tạo bài Kiểm tra</a></li>
                                                    </ul>
                                                </div>
                                            @endif
                                        @endif
                                    </a>
                                </div>
                                @if (isset($cl['sub']) && isset($lesson) && ($lesson['id'] == $cl['id'] || $lesson['lv1'] == $cl['id']))
                                    {{-- lv2 --}}
                                    <ul class="ls-non">
                                        @foreach($cl['sub'] as $sub)
                                            <li>
                                                <div class="col-sm-12 @if(isset($lesson) && $sub == $lesson['id']) active-row @endif">
                                                    <a href="{{ route('lesson.detail', ['id' => $sub]) }}">
                                                        <div class="mailbox-msg-list-item col-sm-10">
                                                            <span class="name
                                                                @if (isset($course_lesson[$sub]['is_exercise']) && $course_lesson[$sub]['is_exercise']  && $course_lesson[$sub]['type'] == \App\Models\Lesson::LESSON) sub-name-ex
                                                                @elseif  (isset($course_lesson[$sub]['type']) && $course_lesson[$sub]['type'] == \App\Models\Lesson::EXAM) sub-name-exam
                                                                @else sub-name @endif">{{ $course_lesson[$sub]['name'] }}
                                                            </span>
                                                        </div>
                                                        @if(isset($lesson) && $sub == $lesson['id'])
                                                            {{-- <div class="col-sm-2 btn-create">
                                                                <a class="btn btn-primary btn-sm btn-circle" data-toggle="dropdown"><i class="fa fa-pencil"></i></a>
                                                                <ul class="dropdown-menu pull-right">
                                                                    <li><a onclick="showModalAddLesson('{{ $sub }}', '{{ $course_lesson[$sub]['name'] }}')">Tạo bài giảng</a></li>
                                                                    <li><a onclick="showModalAddExersice('{{ $sub }}')">Tạo bài tập</a></li>
                                                                </ul>
                                                            </div> --}}
                                                        @endif
                                                    </a>
                                                </div>
                                                @if (isset($course_lesson[$sub]['sub']))
                                                    {{-- lv3 --}}
                                                    <ul class="ls-non">
                                                        @foreach($course_lesson[$sub]['sub'] as $sub2)
                                                            <li>
                                                                <div class="col-sm-12 @if(isset($lesson) && $sub2 == $lesson['id']) active-row @endif">
                                                                    <a href="{{ route('lesson.detail', ['id' => $sub2]) }}">
                                                                        <div class="mailbox-msg-list-item col-sm-10">
                                                                            <span class="name
                                                                                @if (isset($course_lesson[$sub2]['is_exercise']) && $course_lesson[$sub2]['is_exercise'] && $course_lesson[$sub2]['type'] == \App\Models\Lesson::LESSON) sub-name-ex
                                                                                @elseif  (isset($course_lesson[$sub2]['type']) && $course_lesson[$sub2]['type'] == \App\Models\Lesson::EXAM) sub-name-exam
                                                                                @else sub-name @endif">{{ $course_lesson[$sub2]['name'] }}
                                                                            </span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>