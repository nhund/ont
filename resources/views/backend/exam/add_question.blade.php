<div class="row top10">
    <div class="col-xs-12">
        <div class="panel panel-grape panel-bod">
            <div class="panel-heading"><h2>Chọn cậu hỏi vào đề thi</h2></div>
            <div class="panel-body">
                <div class="table-responsive SourceSansProSemibold">
                    <form method="get" action="">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="text-bold"><label for="keySearch">Tìm câu hỏi</label></td>
                                    <td><input id="keySearch" class="form-control" type="text" name="key_search"></td>
                                    <td> <button class="btn btn-primary" type="submit">tìm kiếm</button> </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <form method="post" action="{{route('exam.store')}}">
                    <table class="table">
                            <thead>
                                <tr>
                                    <td class="text-bold"><label for="part">Câu hỏi thuộc phần</label></td>
                                    <td><select class="form-control" id="part" name="part">
                                            <option value="1">Phần 1</option>
                                            <option value="2">Phần 2</option>
                                            <option value="3">Phần 3</option>
                                            <option value="4">Phần 4</option>
                                            <option value="5">Phần 5</option>
                                            <option value="6">Phần 6</option>
                                        </select>
                                    </td>
                                </tr>
                            </thead>
                        </table>

                    @if($suggestQuestions)
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="text-bold">ID</th>
                                <th>Tên</th>
                                <th>Loại</th>
                                <th style="min-width: 50px">Thêm/Bỏ</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($suggestQuestions as $suggestQuestion)
                                    <tr>
                                        <td>{{$suggestQuestion->id}}</td>
                                        <td>{!! $suggestQuestion->question !!}</td>
                                        <td>{!! $suggestQuestion->type() !!}</td>
                                        <td><input type="checkbox" name="question_id[]" value="{{$suggestQuestion->id}}"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div><button class="btn btn-primary" type="submit">tìm kiếm</button></div>
                        <div class="col-sm-4 pull-right">{{ $suggestQuestions->render() }}</div>

                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
