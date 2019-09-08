$(document).ready(function () {        
    //foget password
    $("#loginModal .forgot a").on("click",function(e){
        var phone = $('header .header-contact-info .phone').text();
        var message = 'Liên hệ với admin qua hotline '+phone+' hoặc chat với fanpage Ôn thi EZ để được hỗ trợ';
        swal({
            title: "Thông báo",
            text: message,
            timer: 20000,
            type : 'success',
        });
    });
    //login
    var ajax_login  = false;
    var icon_loadding = $('.icon-loading');
    $("#btnLogin").on("click",function(e){
        e.preventDefault();
        var $this = $("#loginModal");
        var email = $this.find("input[name='email']").val();
        var password = $this.find("input[name='password']").val();
        var remember = $this.find("input[name='remember']").val();

        var data = {remember:remember,email:email,password:password,_token:$('meta[name=csrf-token]').attr("content")};
        if(!ajax_login)
        {
            var ajax_login = true;
            icon_loadding.show();
            $.ajax({
                type: "POST",
                url: route_login,
                dataType: 'json',
                data: data,
                success: function (result) {
                    if(result.code === 200)
                    {
                        swal({
                            title: result.message,
                            timer: 1000,
                            type : 'success',
                        },function(){
                            window.location.reload();
                        });
                    }else{
                        swal({
                            title:result.message,
                            type : 'error',
                        })
                    }
                },
                error: function (result) {

                }
            }).always(function () {
                ajax_login = false;
                icon_loadding.hide();
            });
        }
    });

    //register
    var ajax_register = false;
    $("#btnRegister").on("click",function(e){
        e.preventDefault();
        var $this = $("#registerModal");
        //var name = $this.find("input[name='name']").val();
        var email = $this.find("input[name='email']").val();
        //var full_name = $this.find("input[name='full_name']").val();
        var password = $this.find("input[name='password']").val();
        var password_confirmation = $this.find("input[name='password_confirmation']").val();
        // var gender = $this.find("input[name='gender']:checked").val();
        if($.trim(email) == '' || $.trim(password) == '' || $.trim(password_confirmation) == '')
        {
            swal({
                title: "Thông báo",
                text: 'Bạn cần điền đầy đủ thông tin',
                timer: 5000,
                type : 'error',
            })
        }
        var data = {email:email,password:password,password_confirmation:password_confirmation,_token:$('meta[name=csrf-token]').attr("content")};
        if(!ajax_register)
        {
            var ajax_register = true;
            icon_loadding.show();
            $.ajax({
                type: "POST",
                url: route_register,
                dataType: 'json',
                data: data,
                success: function (result) {
                    if(result.code  ===  200)
                    {
                        swal({
                            title:result.message,
                            timer: 1000,
                            type : 'success',
                            showConfirmButton: false,
                        },function(){
                            window.location.reload();
                        });
                    }else{
                        swal({
                            title:result.message,
                            timer: 5000,
                            type : 'error',
                        })
                    }
                },
                error: function (result) {

                }
            }).always(function () {
                ajax_register = false;
                icon_loadding.hide();
            });
        }
    });
});