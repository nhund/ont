$(document).ready(function(){

    var ajax_login  = false;
    $('body').on('click', '#add-item-form .add-to-cart', function (e) {
        e.preventDefault();
        swal({
            title: "Xác nhận",
            text: "Bạn có chắc muốn mua khóa học!", 
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Đồng ý",
            closeOnConfirm: false
        },
        function () {
                   $.ajax({
                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
                    type: "POST",
                    url: course_buy,
                    data: {
                        course_id: $('#add-item-form input[name="course_id"]').val()
                    },
                    success: function (data) {
                        if(data.error == false){
                            swal({
                                title: "Thông báo",
                                text: data.msg,
                                type : 'success',
                            });
                            setTimeout(function() {
                                window.location.href = data.url;
                            }, 1500);
                        }else{
                            swal({
                                title: "Thông báo",
                                text: data.msg,
                                type : 'error',
                            });
                            if(data.action == 'login')
                            {
                                $('#loginModal').modal('show');

                            }
                        }
                    },
                    error: function (e) {
                        //console.log(e);
                    }
                });
        });   

    });
});