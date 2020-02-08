$(document).ready(function() {
	var loadding_import = false;
	$('#importQuestion .import_save').on('click',function (e) {
		e.preventDefault();
		var $this = $(this);
		var file = $this.closest('#importQuestion').find('.modal-body input[type="file"]');
		var lesson_id = $this.closest('#importQuestion').find('.modal-body input[name="lesson_id"]').val();
		var type = $this.closest('#importQuestion').find('.modal-body select[name="type"]').val();

		var box_action = $this.closest('#importQuestion').find('.box_action');
		var loading = $this.closest('#importQuestion').find('.loader');
		if(type == '')
		{
			swal({
				title: 'Thông báo',
				text: 'bạn chưa chọn loại câu hỏi',
				timer: 3000,
				type: 'error',
			});
			return;
		}
		if(lesson_id == '')
		{
			swal({
				title: 'Thông báo',
				text: 'Có lỗi xẩy ra, vui lòng thử lại sau',
				timer: 3000,
				type: 'error',
			});
			return;
		}
		if(!loadding_import)
		{
			loadding_import = true;
			box_action.hide();
			loading.show();
			var formData = new FormData();
			formData.append('file', file[0].files[0]);
			formData.append('lesson_id', lesson_id);
			formData.append('type', type);
			formData.append('_token', $('meta[name=csrf-token]').attr("content"));            
			$.ajax({
				url : import_excel,
				type : 'POST',
				data : formData,
				processData: false,
				contentType: false,
				success : function(data) {                					
					if(data.error == false)
					{
                        $('#importQuestion').modal('toggle');
						swal({
							title: 'Thông báo',
							text: data.msg,
							timer: 3000,
							type: 'success',
						});
						setTimeout(function(){ 
							window.location.reload();
						}, 1000);
					}else{
						swal({
							title: 'Thông báo',
							text: data.msg,
							timer: 3000,
							type: 'error',
						});
					}
				},
			      error: function (xhr, ajaxOptions, thrownError) {
			        swal({
							title: 'Thông báo',
							text: 'Có lỗi xẩy ra, kiểm tra lại nội dung file',
							timer: 3000,
							type: 'error',
						});
			        setTimeout(function(){ 
							// window.location.reload();
						}, 2000);
			      }
			}).always(function () {
				loadding_import = false;
				box_action.show();
				loading.hide();
			});
		}
		
	});
});