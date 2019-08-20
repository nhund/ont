$(document).ready(function(){
    $('.register-now .register-redirect').on('click',function(e){
        e.preventDefault();
        $('#loginModal').modal('hide');
        $('#registerModal').modal('show');
    });
    $('.register-now .login-redirect').on('click',function(e){
        e.preventDefault();
        $('#loginModal').modal('show');
        $('#registerModal').modal('hide');
    });
});