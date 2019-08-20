$(document).ready(function(){
    var ajax_login  = false;
    $('body').on('click', '.box_add_comment .send-comment', function (e) {
        e.preventDefault();
        var $this = $(this);
        var course_id = $('.comments-container input[name="course_id"]').val();
        var parent_id = $this.attr('data-parent');
        var content = $this.closest('.box_add_comment').find('.box_input input[name="content"]').val();
        if (!content.trim()) {
            swal({
                title: "Thông báo",
                text: "Nội dung bình luận không được để trống",
                type : 'error',
            })
        }
        var data = {course_id:course_id, parent_id:parent_id, content:content,_token:$('meta[name=csrf-token]').attr("content")};
        if(!ajax_login)
        {
            var ajax_login = true;
            //icon_loadding.show();
            $.ajax({
                type: "POST",
                url: comment_add,
                dataType: 'json',
                data: data,
                success: function (result) {
                    if(result.error == false)
                    {
                        $this.closest('.box_add_comment').find('.box_input input[name="content"]').val('');
                        if(parent_id == 0)
                        {
                            $("#comments-list").prepend(result.template);

                        }else{
                            $this.closest('li').find('.reply-list').prepend(result.template);
                        }
                    }else{
                        if(result.type == 'login')
                        {
                            $('#loginModal').modal('show');

                        }else{
                            swal({
                                title: "Thông báo",
                                text: result.msg,
                                type : 'error',
                            });
                        }                        
                    }
                },
                error: function (result) {

                }
            }).always(function () {
                ajax_login = false;
                //icon_loadding.hide();
            });
        }        
    });
    // xoa comment
    $('body').on('click', '.box-reply .btn-delete', function (e) {
        e.preventDefault();
        var $this = $(this);
        var id = $this.attr('data-id');
        swal({
            title: "Xác nhận",
            text: "Bạn có chắc muốn xóa dữ liệu!", 
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Đồng ý",
            closeOnConfirm: false
        },
        function () {
            var data = {id:id,_token:$('meta[name=csrf-token]').attr("content")};
                $.ajax({
                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
                    type: "POST",
                    url: comment_delete,
                    data: data,
                    success: function (data) {
                        if(data.error == false){
                            $this.closest('li').remove();
                            swal(
                                'Deleted!',
                                'Xóa thành công',
                                'success'
                            )
                        }
                    },
                    error: function (e) {
                        
                    }
                });
        });  
        

    });


    $('body').on('click', '.box-reply .btn-reply', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest('.box-reply').find('.box_add_comment').show();
        $this.closest('.box-reply').find('.box_add_comment input[name="content"]').focus();
    });
    $('body').on('click', '.box-reply .delete_content', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest('.box-reply').find('.box_add_comment').hide();
        $this.closest('.box-reply').find('.box_add_comment input[name="content"]').val('');
    });
});