$(document).ready(function () {
	$('body').click(function () {
        $(".instant-results").fadeOut('500');
    });
	$('.search-form input[name="name"]').bind("keyup", function (event){
		var name = $('.search-form input[name="name"]').val();
		$.ajax({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
			type: "GET",
			url: sugges_user,
			data: {
				name: name
			},
			success: function (data) {
				if(data.error == false){
					$('.instant-results').children().remove();
					$('.instant-results').append(data.html);
					$(".instant-results").fadeIn('slow').css('height', 'auto');
				}
			},
			error: function (e) {
				console.log(e);
			}
		});
	});
	$('body').on('click','.instant-results .result-entry',function(event) {
		var $this = $(this);
		var id = $this.attr('data-id');
		var name = $this.find('.media-heading').text();
		if(name == "")
		{
			name = $this.find('.email').text();
		}
		$('.search-form input[name="user_id"]').val(id);
		$('.search-form input[name="name"]').val(name);
	});
});