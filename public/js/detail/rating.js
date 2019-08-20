$(document).ready(function(){
    var $star_rating = $('.star-rating .fa-star');

    $star_rating.mouseover(function() {
    var rate = parseInt($(this).data('rating'));
    $('input.rating-value').val(rate);
    $('#rating .send_rating').show();
    $star_rating.each(function() {
        if (rate >= parseInt($(this).data('rating'))) {
        return $(this).removeClass('checked').addClass('checked');
        } else {
        return $(this).removeClass('checked');
        }
    });
    });
    var ajax_rating = false; 
    $('#rating .send_rating').on('click',function(e){
        e.preventDefault();
        var course_id = $('input[name="course_id"]').val();
        var rating_value = $('#rating input[name="rating_value"]').val();
        var data = {course_id:course_id, rating_value:rating_value, _token:$('meta[name=csrf-token]').attr("content")};
           
        if(!ajax_rating)
            {
                var ajax_rating = true;
                //icon_loadding.show();
                $.ajax({
                    type: "POST",
                    url: rating,
                    dataType: 'json',
                    data: data,
                    success: function (result) {
                        if(result.error == false)
                        {
                            swal({
                                title: "Thông báo",
                                text: result.msg,
                                timer: 1000,
                                type : 'success',
                            });
                            // setTimeout(function() {
                            //     location.reload();
                            // }, 1500);
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
                    ajax_rating = false;
                    //icon_loadding.hide();
                });
            }
    });
    
});