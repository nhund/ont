@push('css')
<style type="text/css">
#feedbackModel .modal-dialog{
  margin-top: 90px;
}
#feedbackModel .modal-header .modal-title{
  font-weight: bold;
  text-align: center;
}
#feedbackModel .content-box{
  display: flex;
}
#feedbackModel .content-box .box_form,#feedbackModel .content-box .suggest_info{
  width: 50%;
}
#feedbackModel .content-box .box_form{
  padding: 10px;
  border-right: 1px solid#ccc;
}
#feedbackModel .content-box .suggest_info{
  padding: 10px;
  height: 350px;
  overflow: auto;
}
#feedbackModel .content-box .suggest_info .suggest_item{
  cursor: pointer;
  margin-bottom: 10px;
}
#feedbackModel .content-box .suggest_info .suggest_item .title{
  font-size: 14px;
  font-weight: bold;
  text-decoration: underline;
  padding-bottom: 5px;
}
#feedbackModel .content-box .suggest_info .suggest_item .content{
  padding-left: 15px;      
}
#feedbackModel .modal-footer{
  text-align: center;
}
#feedbackModel .modal-footer .btn-send-feedback{
  background: #FFC646;
  color: #fff;
}
#feedbackModel .modal-footer .btn-send-feedback:focus{
  outline: none;
}
</style>
@endpush
<div id="feedbackModel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Phản hồi câu hỏi</h4>
      </div>
      <div class="modal-body">
        <div class="content-box">
          <div class="box_form">
            <form class="form_feedback">
              <input type="hidden" name="question_id" value="31">
              <input type="hidden" name="type" value="31">
              <div class="form-group">
                <label for="email">Email phản hồi</label>
                <input type="email" name="email" class="form-control">
              </div>
              <div class="form-group">
                <label for="email">Tiêu đề</label>
                <input type="text" name="title" class="form-control">
              </div>
              <div class="form-group">
                <label for="email">Mô tả</label>
                <textarea name="content" class="form-control" rows="3"></textarea>
              </div>
            </form>            
          </div>
          <div class="suggest_info">
            <div class="suggest_list">
              <div class="suggest_item">
                <div class="title">Sai hình ảnh, âm thanh</div>
                <p class="content">Hình ảnh câu hỏi không hiển thị hoặc không liên quan đến câu hỏi</p>
              </div>
              <div class="suggest_item">
                <div class="title">Sai nội dung câu hỏi, gợi ý câu hỏi</div>
                <p class="content">câu hỏi báo lặp lại hiển thị, câu hỏi lặp lại ngữ pháp</p>
              </div>
              <div class="suggest_item">
                <div class="title">Sai nội dung câu trả lời, gợi ý câu trả lời</div>
                <p class="content">Đáp án câu hỏi báo sai</p>
              </div>              
              <div class="suggest_item">
                <div class="title clear">Vấn đề khác</div>                
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-send-feedback">Gửi</button>
        <button type="button" class="btn btn-cancel" data-dismiss="modal">Hủy</button>
      </div>
    </div>

  </div>
</div>
@push('js')
<script type="text/javascript">
  $(document).ready(function(){
    $('#feedbackModel .suggest_item').on('click',function(e){
        e.preventDefault();
        var $this = $(this);
        if($this.find('.title').hasClass('clear'))
        {
          $('#feedbackModel .form_feedback input[name="title"]').val('');
          $('#feedbackModel .form_feedback textarea[name="content"]').val('');        
        }else{
          $('#feedbackModel .form_feedback input[name="title"]').val($this.find('.title').text());
          $('#feedbackModel .form_feedback textarea[name="content"]').val($this.find('.content').text());        
        }        
    });
    var send_feedback = false;
    $('#feedbackModel .btn-send-feedback').on('click',function(e){
      e.preventDefault();
      var email = $('#feedbackModel .form_feedback input[name="email"]').val();
      var title = $('#feedbackModel .form_feedback input[name="title"]').val();
      var content = $('#feedbackModel .form_feedback textarea[name="content"]').val();
      if(!email.trim() || !title.trim() || !content.trim())
      {
        swal({
              title: 'Thông báo',
              text: 'Bạn cần điền đủ thông tin',
              timer: 2000,
              type: 'error',
            });
        return;
      }
      var form = $('#feedbackModel .form_feedback').serializeArray();
      $.ajax({
        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
        type: "POST",
        url: '{{ route('feedback.add') }}',
        data: form,
        success: function (data) {
          if(data.error == false){
            swal({
              title: 'Thông báo',
              text: data.msg,
              timer: 2000,
              type: 'success',
            });
            $('#feedbackModel').modal('toggle');
            $('#feedbackModel .form_feedback')[0].reset();
          }else{
            swal({
              title: 'Thông báo',
              text: data.msg,
              timer: 3000,
              type: 'error',
            });
          }
        },
        error: function (e) {
          swal({
            title: 'Thông báo',
            text: 'Có lỗi xẩy ra',
            timer: 3000,
            type: 'error',
          })
        }
      }).always(function () {
                    //loadding.hide();
                    //$this.show();
                  });
    });
  });
</script>
@endpush