<table>
    <thead>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
        </tr>
    </thead>
    <tbody>
        @if($questions)
            @foreach($questions as $question)
                {{-- flash card don --}}
                @if($question->type == \App\Models\Question::TYPE_FLASH_SINGLE)
                    <tr>
                        @if(!empty($question->content))
                            <td><span>#f.{{ export_math_latex($question->content) }}</span></td>
                        @endif
                        @if(!empty($question->question))
                            <td><span>$f.{{ export_math_latex($question->question) }}</span></td>
                        @endif
                        @if(!empty($question->explain_before))
                            <td><span>$fh.{{ export_math_latex($question->explain_before) }}</span></td>
                        @endif
                        @if(!empty($question->question_after))
                            <td><span>$b.{{ export_math_latex($question->question_after) }}</span></td>
                        @endif
                        @if(!empty($question->explain_after))
                            <td><span>$bh.{{ export_math_latex($question->explain_after) }}</span></td>    
                        @endif
                        @if(!empty($question->img_before))
                            <td><span>$fi.{{ $question->img_before }}</span></td>
                        @endif
                        @if(!empty($question->img_after))
                            <td><span>$bi.{{ $question->img_after }}</span></td>
                        @endif
                        @if(!empty($question->audio_content))
                            <td><span>$ac.{{$question->audio_content}}</span></td>
                        @endif
                    </tr>
                @endif

                {{-- flash card chuoi --}}
                @if($question->type == \App\Models\Question::TYPE_FLASH_MUTI)
                    <tr>
                        <td><span>#mf.{{ export_math_latex($question->content) }}</span></td>
                    </tr>
                    @if(isset($question->child_cards))
                        @foreach ($question->child_cards as $child_cards)
                            <tr>
                                @if(!empty($child_cards->question))
                                    <td><span>$f.{{ export_math_latex($child_cards->question) }}</span></td>
                                @endif
                                @if(!empty($child_cards->explain_before))
                                    <td><span>$fh.{{ export_math_latex($child_cards->explain_before) }}</span></td>
                                @endif
                                @if(!empty($child_cards->question_after))
                                    <td><span>$b.{{ export_math_latex($child_cards->question_after) }}</span></td>
                                @endif
                                @if(!empty($child_cards->explain_after))
                                    <td><span>$bh.{{ export_math_latex($child_cards->explain_after) }}</span></td>
                                @endif
                                @if(!empty($child_cards->img_before))
                                    <td><span>$fi.{{ $child_cards->img_before }}</span></td>
                                @endif
                                @if(!empty($child_cards->img_after))
                                    <td><span>$bi.{{ $child_cards->img_after }}</span></td>
                                @endif
                            </tr>
                            @if(isset($child_cards->child))
                                @foreach($child_cards->child as $child_cards_child)
                                    <tr>
                                        @if(!empty($child_cards_child->question))
                                            <td><span>$sf.{{ export_math_latex($child_cards_child->question) }}</span></td>
                                        @endif
                                        @if(!empty($child_cards_child->explain_before))
                                            <td><span>$fh.{{ export_math_latex($child_cards_child->explain_before) }}</span></td>
                                        @endif
                                        @if(!empty($child_cards_child->question_after))
                                            <td><span>$b.{{ export_math_latex($child_cards_child->question_after) }}</span></td>
                                        @endif
                                        @if(!empty($child_cards_child->explain_after))
                                            <td><span>$bh.{{ export_math_latex($child_cards_child->explain_after) }}</span></td>
                                        @endif
                                        @if(!empty($child_cards_child->img_before))
                                            <td><span>$fi.{{ $child_cards_child->img_before }}</span></td>
                                        @endif
                                        @if(!empty($child_cards_child->img_after))
                                            <td><span>$bi.{{ $child_cards_child->img_after }}</span></td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endif

                {{-- trac nghiem --}}
                @if($question->type == \App\Models\Question::TYPE_TRAC_NGHIEM)
                    <tr>
                        <td><span>#tn.{{ export_math_latex($question->content) }}</span></td>                        
                        {{-- @if(!empty($question->content))
                            <td><span>#tn.{{ export_math_latex($question->content) }}</span></td>
                        @endif --}}
                        @if(!empty($question->explain_before))
                            <td><span>$h.{{ export_math_latex($question->explain_before) }}</span></td>
                        @endif
                        @if(!empty($question->img_before))
                            <td><span>$i.{{ $question->img_before }}</span></td>
                        @endif
                        @if(!empty($question->interpret_all))
                            <td><span>$e.{{ $question->interpret_all }}</span></td>
                        @endif
                        @if(!empty($question->audio_content))
                            <td><span>$ac.{{$question->audio_content}}</span></td>
                        @endif
                    </tr>
                    @if(isset($question->childs))
                        @foreach($question->childs as $question_child)
                            <tr>
                                @if(!empty($question_child->question))
                                    <td><span>$tn.{{ export_math_latex($question_child->question) }}</span></td>
                                @endif
                                @if(!empty($question_child->explain_before))
                                    <td><span>$h.{{ export_math_latex($question_child->explain_before) }}</span></td>
                                @endif
                                @if(!empty($question_child->img_before))
                                    <td><span>$i.{{ $question_child->img_before }}</span></td>
                                @endif
                                @if(isset($question_child->answers))
                                    @foreach($question_child->answers as $question_answers)
                                        @if($question_answers->status == \App\Models\QuestionAnswer::REPLY_ERROR)
                                            @if(!empty($question_answers->answer))
                                                <td><span>$s.{{ export_math_latex($question_answers->answer) }}</span></td>
                                            @endif
                                        @else 
                                            @if(!empty($question_answers->answer))
                                                <td><span>$t.{{ export_math_latex($question_answers->answer) }}</span></td>
                                            @endif
                                        @endif 
                                    @endforeach
                                @endif  
                                @if(!empty($question_child->interpret))
                                    <td><span>$e.{{ export_math_latex($question_child->interpret) }}</span></td>
                                @endif
                                @if(!empty($question_child->audio_question))
                                    <td><span>$aq.{{$question_child->audio_question}}</span></td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                @endif

                {{-- trac nghiem đơn --}}
                @if($question->type == \App\Models\Question::TYPE_TRAC_NGHIEM_DON)
                    <tr>
                        @if(!empty($question->question))
                            <td><span>#tnd.{{ export_math_latex($question->question) }}</span></td>
                        @endif
                        @if(!empty($question->explain_before))
                            <td><span>$h.{{ export_math_latex($question->explain_before) }}</span></td>
                        @endif
                        @if(!empty($question->img_before))
                            <td><span>$i.{{ $question->img_before }}</span></td>
                        @endif
                        @if(isset($question->answers))
                            @foreach($question->answers as $question_answers)
                                @if($question_answers->status == \App\Models\QuestionAnswer::REPLY_ERROR)
                                    @if(!empty($question_answers->answer))
                                        <td><span>$s.{{ export_math_latex($question_answers->answer) }}</span></td>
                                    @endif
                                @else
                                    @if(!empty($question_answers->answer))
                                        <td><span>$t.{{ export_math_latex($question_answers->answer) }}</span></td>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        @if(!empty($question->interpret))
                            <td><span>$e.{{ export_math_latex($question->interpret) }}</span></td>
                        @endif
                        @if(!empty($question->audio_question))
                            <td><span>$ac.{{$question->audio_question}}</span></td>
                        @endif
                    </tr>
                @endif

                {{-- dien tu ngan --}}
                @if($question->type == \App\Models\Question::TYPE_DIEN_TU)
                    <tr>
                        <td><span>#q.{{ export_math_latex($question->content) }}</span></td>
                        @if(!empty($question->img_before))
                            <td><span>$i.{{ $question->img_before }}</span></td>
                        @endif
                        @if(!empty($question->interpret_all))
                            <td><span>$e.{{ $question->interpret_all }}</span></td>
                        @endif
                        @if(!empty($question->audio_content))
                            <td><span>$ac.{{$question->audio_content}}</span></td>
                        @endif
                    </tr>
                    @if(isset($question->childs))
                        @foreach($question->childs as $question_child)
                            <tr>
                                @if(!empty($question_child->question))
                                    <td><span>$d.{{ export_math_latex($question_child->question) }}</span></td>
                                @endif                                
                                @if(isset($question_child->answers))
                                    @foreach($question_child->answers as $question_answers)
                                        @if($question_answers->status == \App\Models\QuestionAnswer::REPLY_OK)
                                            @if(!empty($question_answers->answer))
                                                <td><span>$t.{{ export_math_latex($question_answers->answer) }}</span></td>
                                            @endif
                                        @endif 
                                    @endforeach
                                @endif
                                @if(!empty($question_child->explain_before))
                                    <td><span>$h.{{ export_math_latex($question_child->explain_before) }}</span></td>
                                @endif  
                                @if(!empty($question_child->img_before))
                                    <td><span>$i.{{ $question_child->img_before }}</span></td>
                                @endif
                                @if(!empty($question_child->interpret))
                                    <td><span>$e.{{ export_math_latex($question_child->interpret) }}</span></td>
                                @endif
                                @if(!empty($question_child->audio_question))
                                    <td><span>$aq.{{$question_child->audio_question}}</span></td>
                                @endif
                            </tr>
                        @endforeach
                    @endif    
                @endif
                {{-- dien tu doan van --}}
                @if($question->type == \App\Models\Question::TYPE_DIEN_TU_DOAN_VAN)
                    <tr>
                        <td><span>#dt.{{ export_math_latex($question->content) }}</span></td>
                        @if(!empty($question->img_before))
                            <td><span>$i.{{ $question->img_before }}</span></td>
                        @endif    
                        @if(!empty($question->interpret_all))
                            <td><span>$e.{{ $question->interpret_all }}</span></td>
                        @endif
                        @if(!empty($question->audio_question))
                            <td><span>$ac.{{$question->audio_question}}</span></td>
                        @endif
                    </tr>
                    @if(isset($question->childs))
                        @foreach ($question->childs as $question_child)
                            <tr>
                                @if(!empty($question_child->question_display))
                                    <td><span>$dt.{{ export_math_latex($question_child->question_display) }}</span></td>
                                @endif  
                                @if(!empty($question_child->interpret))
                                    <td><span>$e.{{ export_math_latex($question_child->interpret) }}</span></td>
                                @endif
                                @if(!empty($question_child->explain_before))
                                    <td><span>$h.{{ export_math_latex($question_child->explain_before) }}</span></td>
                                @endif
                                @if(!empty($question_child->audio_question))
                                    <td><span>$aq.{{$question_child->audio_question}}</span></td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                @endif
            @endforeach
        @endif
    </tbody>
</table>