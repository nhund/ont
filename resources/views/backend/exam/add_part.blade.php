<div class="row top10">
    <div class="col-xs-12">
{{--        <div><button class="btn btn-info" type="button" onclick="addPartExam()">thêm phần kiểm tra</button></div>--}}
{{--        <hr/>--}}
        <div class="panel panel-grape panel-bod">
            <div class="panel-heading"><h2>Điểm Từng phần của bài kiểm tra</h2></div>
            <div class="panel-body">
                <div class="table-responsive SourceSansProSemibold">
                    <input hidden name="exam_id" value="{{$lesson->id ?? ''}}">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-bold">Tên</th>
                                <th class="text-bold">Số câu hỏi</th>
                                <th class="text-bold">Tổng điểm</th>
                                <th class="text-bold">Sửa</th>
{{--                                <th class="text-bold">Xóa</th>--}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parts as $part)
                                <tr>
                                    <td><a href="{{route('exam.detail.part', ['id' => $lesson->id, 'part_id' => $part->id])}}"> <span class="fa fa-plus"> {!! $part->name !!}</span> </a></td>
                                    <td>{!! $part->number_question !!}</td>
                                    <td>{!! $part->score !!}</td>
                                    <td><button type="button" class="btn btn-info" onclick="editPart({{$part}})">Sửa</button></td>
{{--                                    <td><button type="button" data-toggle="modal" onclick="modalConfirm({{$part->id}})" class="btn btn-warning">Xóa</button></td>--}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-part-exam" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" name="part_id" value="">
                <p class="text-bold">Bạn có chắc chắn muốn xóa ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="modal-btn-yes" class="btn btn-primary">Xóa</button>
                <button type="button" id="modal-btn-no" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-part-exam" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <p class="text-bold text-center">Thêm phần mới cho bài kiểm tra <strong>{{$lesson->name ?? ''}}</strong></p>
                <form id="form-add-part-exam" method="POST" action="{{route('part.add')}}">
                    <div class="modal-body">
                        <input type="hidden" name="lesson_id" value="{{$lesson->id ?? ''}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" data-input="id" name="id" value="">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="name">Tên</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" data-title="Tên" data-input="name" id="name" type="text" name="name">
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="score">Tổng điểm</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" data-title="Tổng điểm" data-input="score"  id="score" type="number" name="score" min="0">
                            </div>
                        </div><br/>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="score">Tổng số câu hỏi</label>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control" data-title="Tổng số câu hỏi" data-input="number_question"  type="number" name="number_question" min="0">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="submit-add-part">Thêm</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<script>
    const modalConfirm = function(part_id){

        $('input[name=part_id]').val(part_id);

        $("#delete-part-exam").modal('show');

        $("#modal-btn-no").on("click", function(){
            $("#delete-part-exam").modal('hide');
        });

        $("#modal-btn-yes").on("click", function(){
            $.ajax({
                url: '/admin/exam/part',
                data: {part_id},
                dataType: 'json',
                method: 'DELETE',
                success: function (response) {
                    const exam_id =  $('input[name=exam_id]').val();
                    console.log('response', response.status === 200);
                   if (response.status === 200) {
                       window.location.href = '/admin/exam/'+exam_id;
                   }
                }
             });
            console.log('partId', part_id);
        });
    };

    const addPartExam = function(){
        $("#add-part-exam").modal('show');

        $("#submit-add-part").on("click", function(){

            CKEDITOR.instances.exDescription.updateElement();

            const inputs = $('form#form-add-part-exam [data-title]');
            let valid =  true;
            inputs.each(function ( ele, input) {
                const value = $(input).val();
                if ( $.trim($(input).val()) === ''){
                    valid = false;
                    showErrorMsg('Vui lòng nhập ' + $(input).data('title') );
                }
            });

            const serialise = $( "form#form-add-part-exam" ).serialize();
            $.ajax({
                   url: '/admin/exam/part',
                   data: serialise,
                   dataType: 'json',
                   method: 'POST',
                   success: function (response) {
                       const exam_id =  $('input[name=exam_id]').val();
                       console.log('response', response.status === 200);
                       if (response.status === 200) {
                           window.location.href = '/admin/exam/'+exam_id;
                       }else {
                           showErrorMsg(response.message);
                       }
                   }
               });
        });

    };
    
    const editPart = function (part) {
        const inputs = $('#form-add-part-exam [data-input]');
        inputs.each(function ( ele, input) {
            const name = $(input).data('input');
            $(input).val(part[name])
        });
        addPartExam();
    }
</script>