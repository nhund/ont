<div class="row top10">
    <div class="col-xs-12">
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
                                <th class="text-bold">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parts as $part)
                                <tr>
                                    <td>{!! $part->name !!}</td>
                                    <td>{!! $part->number_question !!}</td>
                                    <td>{!! $part->score !!}</td>
                                    <td><button type="button" class="btn btn-info">Sửa</button></td>
                                    <td><button type="button" data-toggle="modal" onclick="modalConfirm({{$part->id}})" class="btn btn-warning">Xóa</button></td>
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
                method: 'POST',
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
</script>