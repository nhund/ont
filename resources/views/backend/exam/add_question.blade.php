<div class="row top10">
    <div class="col-xs-12">
        <div class="panel panel-grape panel-bod">
            <div class="panel-heading"><h2>Chọn cậu hỏi vào đề thi</h2></div>
            <div class="panel-body">
                <div class="table-responsive SourceSansProSemibold">
                    <form method="get" action="" id="add_question">
                        <input hidden name="exam_id" value="{{$lesson->id ?? ''}}">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-bold"><label for="keySearch">Tìm câu hỏi</label></td>
                                    <td><input id="keySearch" value="{{request('key_search')}}" class="form-control" type="text" name="key_search"></td>
                                    <td> <button class="btn btn-primary" type="submit">tìm kiếm</button> </td>
                                </tr>
                                <tr>
                                    <td class="text-bold"><label for="part">Câu hỏi thuộc phần</label></td>
                                    <td>
                                        <select class="form-control" id="part" name="part" data-input="part">
                                                <option value="">--Chọn phần--</option>
                                            @foreach($parts as $part)
                                                <option {{request('part') == $part->id ?'selected' : ''}} value="{{$part->id}}">{{$part->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                    @if($suggestQuestions)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-bold">ID</th>
                                    <th>Tên</th>
                                    <th style="min-width: 50px">Loại</th>
                                    <th style="min-width: 50px">Thêm/Bỏ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suggestQuestions as $suggestQuestion)
                                    <tr>
                                        <td>{{$suggestQuestion->id}}</td>
                                        <td>{!! $suggestQuestion->question ?: $suggestQuestion->content !!}</td>
                                        <td>{!! $suggestQuestion->type() !!}</td>
                                        <td><input type="checkbox" @if(in_array($suggestQuestion->id, $questionIds)) checked @endif name="question_id" value="{{$suggestQuestion->id}}"/></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-sm-4 pull-right"><button class="btn btn-primary" type="submit" onclick="addQuestionToExam()">Thêm/Xóa</button></div>
                        <div class="col-sm-4 pull-left">{{ $suggestQuestions->appends(['key_search' => request('key_search')])->render() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function addQuestionToExam() {

        if($.trim($('[data-input=part]').val())  == ''){
            showErrorMsg('Vui chọn phần thi');
            return false;
        }

        let addQuestion = [];
        let removeQuestion = [];
        await $('input[name=question_id]').each(function (index, ele) {
            if($(ele).is(':checked')){
                addQuestion.push($(ele).val())
            }else{
                removeQuestion.push($(ele).val())
            }
        });
        const part = $('select[name=part]').val();
        const exam_id = $('input[name=exam_id]').val();
        $.ajax({
            url: '/admin/exam',
            data: {removeQuestion, addQuestion, part, exam_id},
            dataType: 'json',
            method: 'POST',
            success: function (response) {
                console.log(response);
                if (response.status) {
                    if (response.status === 201){
                        showErrorMsg(response.message);
                    } else {
                        window.location.reload();
                    }
                }
            }
        });
    }
</script>
