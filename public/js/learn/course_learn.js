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
});