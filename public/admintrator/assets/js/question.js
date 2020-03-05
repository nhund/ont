$(document).ready(function () {

    $('.btn_add_question').on('click',function(e){
        e.preventDefault();
        $('#addQuestionModal').show();

    });

    $('.btn_cancel_add_question').on('click',function(e){
        e.preventDefault();
        $('.addQuestion').trigger("reset");
        $('#addQuestionModal').hide();

    });
    $('body').on('click', '.addQuestion .form_dien_tu .dropdown .add_explain', function (e) { 
        e.preventDefault();   
        var $this = $(this);
        $this.closest('.box_answer').find('.box_explain').show();    

    });
    $('body').on('change', '.addQuestion select[name="type"]', function (e) { 
        e.preventDefault();
        var $this = $(this);
        const type = parseInt($this.val());
        $this.closest('.addQuestion').find('.form_question').hide();
        
        if (type !== 6){
            $('.doan-van').show()
        }else{
            $('.doan-van').hide()
        }
        
        if(type === 1) {
            $this.closest('.addQuestion').find('.form_question.form_flash_card').show();
        }
        if(type === 2) {
            $this.closest('.addQuestion').find('.form_question.form_flash_card_chuoi').show();
        }
        if(type === 3) {
            $this.closest('.addQuestion').find('.form_question.form_dien_tu').show();
        }
        if(type === 4) {
            $this.closest('.addQuestion').find('.form_question.form_trac_nghiem').show();
        }
        if(type === 5) {
            $this.closest('.addQuestion').find('.form_question.form_dien_tu_doan_van').show();
        }
        if(type === 6) {
            $this.closest('.addQuestion').find('.form_question.form_trac_nghiem_don').show();
        }
    });
    // $('body').on('click', '.addQuestion .popup_upload', function (e) {     
    //     e.preventDefault();
    //     var $this = $(this);
    //     var type = $this.attr('data-type'); console.log(type);
    //     $('#addImage .modal-body input[name="image_type"]').val(type);
    //     $('#addImage').modal('show'); 
    // });
    
    $('.phd .upload').change(function () {
        var $this = $(this);        
        var formData = new FormData();
        formData.append('file', $this[0].files[0]);
        formData.append('_token', $('meta[name=csrf-token]').attr("content"));            
        $.ajax({
         url : upload_image,
         type : 'POST',
         data : formData,
         processData: false,
         contentType: false,
         success : function(data) {       
               //$this             
               $('.image_box .'+type).attr('src',data.image).show();
               $('.image_box input[name="'+type+'"]').val(data.url);
               $this.hide();
               //$('#addImage').modal('toggle');
           }
       });
    });
    $('.upImage').change(function () {
        var $this = $(this);
        var type = $this.parent('.modal-body').find('input[name="image_type"]').val(); console.log(type);
        var formData = new FormData();
        formData.append('file', $this[0].files[0]);
        formData.append('_token', $('meta[name=csrf-token]').attr("content"));            
        $.ajax({
         url : upload_image,
         type : 'POST',
         data : formData,
         processData: false,
         contentType: false,
         success : function(data) {                
            if(type == 'content')
            {
                $('.box_content .box_media .box_image img').attr('src',data.image);
                $('.box_content .box_media .box_image').show();
                $('.box_content .box_media .box_image input[name="image"]').val(data.url);
            }else{
                $('.answer_'+type+' .box_media .box_image img').attr('src',data.image);
                $('.answer_'+type+' .box_media .box_image').show();
                $('.answer_'+type+' .box_media .box_image .input_image').val(data.url);
            }                
               //$('.image_box .'+type).attr('src',data.image).show();
              // $('.image_box input[name="'+type+'"]').val(data.url);
              // $this.hide();
              $('#addImage').modal('toggle');
          }
      });
    });
    //upload image flash don
    // $('body').on('click', '.form_flash_card .media_box .flash_img_upload', function (e) {     
    //     e.preventDefault();
    //     var $this = $(this);
    //     var type = $this.attr('data-type'); 
    //     var postion = $this.attr('data-postion'); 
    //     $('#addImageFlashDon .modal-body input[name="type"]').val(type);
    //     $('#addImageFlashDon .modal-body input[name="postion"]').val(postion);
    //     $('#addImageFlashDon').modal('show'); 
    // });
    // $('.upImageFlashDon').change(function () {
    //     var $this = $(this);
    //     var type = $this.parent('.modal-body').find('input[name="type"]').val(); 
    //     var postion = $this.parent('.modal-body').find('input[name="postion"]').val();
        
    //     var formData = new FormData();
    //     formData.append('file', $this[0].files[0]);
    //     formData.append('course_id', $('input[name="course_id"]').val());
    //     formData.append('_token', $('meta[name=csrf-token]').attr("content"));            
    //     $.ajax({
    //      url : upload_image,
    //      type : 'POST',
    //      data : formData,
    //      processData: false,
    //      contentType: false,
    //      success : function(data) {      
    //          $this.val("");          
    //          if(type == 'flash_card')
    //          {
                
    //             $('.form_flash_card .media_box .img_'+postion).attr('src',data.file).show();
    //             $('.form_flash_card .media_box .img_'+postion).parent('.image_box').show();
    //             //$('.form_flash_card .box_media .box_image').show();
    //             $('.form_flash_card .media_box input[name="img_card_'+postion+'"]').val(data.file);
    //             //$('.form_flash_card .media_box .btn_img_'+postion).hide();

    //         }else{

    //         }                
    //            //$('.image_box .'+type).attr('src',data.image).show();
    //           // $('.image_box input[name="'+type+'"]').val(data.url);
    //           // $this.hide();
    //           $('#addImageFlashDon').modal('toggle');
    //       }
    //   });
    // });
    
    
    $('#addQuestionModal .modal-footer button[type="submit"]').on('click',function(e){
        e.preventDefault();
        var $this = $(this);  
        tinyMCE.triggerSave();              
        var form = $this.closest('.addQuestion').serializeArray();
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
            type: "POST",
            url: question_add,
            data: form,
            success: function (data) {
                if(data.error == false){
                    swal({
                        title: 'Thông báo',
                        text: data.msg,
                        timer: 3000,
                        type: 'success',
                    })
                    setTimeout(function(){ 
                        window.location.reload();
                    }, 1000);
                    
                }else{
                    swal({
                        title: 'Thông báo',
                        text: data.msg,
                        timer: 3000,
                        type: 'error',
                    })
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
    //lay template dien tu
    $('body').on('click', '.addQuestion .form_dien_tu .add_question', function (e) {     
        e.preventDefault();
        var $this = $(this);                
        var data = { count : $this.attr('data-count')};                                
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
            type: "GET",
            url: question_get_temlate_dien_tu,
            data: data,
            success: function (data) {
                if(data.error == false){
                    $this.closest('.form-group').before(data.template);
                    $this.attr('data-count',data.data);                    
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
    // lay template flash chuoi
    $('body').on('click', '.addQuestion .form_flash_card_chuoi .add_flash_card', function (e) {     
        e.preventDefault();
        var $this = $(this);                
        var data = { count : $this.attr('data-count') ,type:'parent'};                                
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
            type: "GET",
            url: question_get_temlate_flc_chuoi,
            data: data,
            success: function (data) {
                if(data.error == false){
                    $this.closest('.box_add_btn').before(data.template);
                    $this.attr('data-count',data.data);
                }
            },
            error: function (e) {
                swal({
                    title: 'Thông báo',
                    text: 'Có lỗi xẩy ra',
                    timer: 3000,
                    type: 'error',
                });
            }
        }).always(function () {
                    //loadding.hide();
                    //$this.show();
                });
    });
    // lay template trac nghiem
    $('body').on('click', '.form_trac_nghiem .add_question', function (e) {    
        e.preventDefault();
        var $this = $(this);                
        var data = { count : $this.attr('data-count') ,type:'parent'};                                
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
            type: "GET",
            url: question_get_temlate_trac_nghiem,
            data: data,
            success: function (data) {
                if(data.error == false){
                    $this.closest('.box_add_btn').before(data.template);
                    $this.attr('data-count',data.data);
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
    
    $('body').on('click', '.phd .add_answer_error', function (e) {
        e.preventDefault();
        var $this = $(this);
        var count = $this.attr('data-count');
        var count_child = $this.closest('.box_answer').find('.box_text:last-child').attr('data-child');
        if(count_child === undefined)
        {
            count_child = 1;
        }
        //console.log(count_child); return;
        var data = { count :count, count_child:count_child  ,type:'answer',templateType:'error'};                                
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
            type: "GET",
            url: question_get_temlate_trac_nghiem,
            data: data,
            success: function (data) {
                if(data.error == false){
                    $this.closest('.box_answer').find('.box_text:last-child').after(data.template);
                    //$this.attr('data-count',data.data);
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
    $('body').on('click', '.addQuestion .form_flash_card_chuoi .add_flash_card_child', function (e) {        
        e.preventDefault();
        var $this = $(this);                
        var data = { count : $this.attr('data-count'), count_child : $this.attr('data-countchild') ,type:'child'};                                
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
            type: "GET",
            url: question_get_temlate_flc_chuoi,
            data: data,
            success: function (data) {
                if(data.error == false){
                    $this.closest('.flash_card_list').find('.flah_card_child').append(data.template);
                    $this.attr('data-countchild',data.data);
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
    //bat popup upload image flash card
    // $('body').on('click', '.addQuestion .form_flash_card_chuoi .flash_img_upload', function (e) {        
    //     e.preventDefault();
    //     var $this = $(this);                        
    //     var type = $this.attr('data-type');
    //     var postion = $this.attr('data-postion');
    //     var count = $this.attr('data-count');
    //     $('#addImageFlash .modal-body input[name="type"]').val(type);
    //     $('#addImageFlash .modal-body input[name="postion"]').val(postion);
    //     $('#addImageFlash .modal-body input[name="count"]').val(count);

    //     $('#addImageFlash').modal('show');
    // });
    
    //upload flash card chuoi
    $('body').on('change', '.upload_flash_card', function (e) {        
        var $this = $(this);
        // var type = $this.parent('.modal-body').find('input[name="type"]').val();
        // var postion = $this.parent('.modal-body').find('input[name="postion"]').val();
        // var count = $this.parent('.modal-body').find('input[name="count"]').val();                

        var formData = new FormData();
        formData.append('file', $this[0].files[0]);
        formData.append('course_id', $('input[name="course_id"]').val());
        formData.append('_token', $('meta[name=csrf-token]').attr("content"));            
        $.ajax({
         url : upload_image,
         type : 'POST',
         data : formData,
         processData: false,
         contentType: false,
         success : function(data) {    
            $this.val("");
            $this.closest('.img_item').find('.image_box img').attr('src',data.file).show();
            $this.closest('.img_item').find('.image_box input').val(data.file);
            $this.closest('.img_item').find('.image_box').show();
          }
      });
    });
    //xoa anh flash card
    $('body').on('click', '.image_box .delete_image', function (e) { 
        let $this = $(this);
        $this.parent('.image_box').hide();
        $this.parent('.image_box').find('input').val('');
        $this.parent('.image_box').find('img').attr('src','');                
    });
    //bat popup upload image trac nghiem
    $('body').on('click', '.form_trac_nghiem .popup_upload_tn', function (e) {        
        e.preventDefault();
        var $this = $(this);                        
        var type = $this.attr('data-type');
        var postion = $this.attr('data-position');
        var count = $this.attr('data-count');
        $('#addImageTracNghiem .modal-body input[name="type"]').val(type);
        $('#addImageTracNghiem .modal-body input[name="postion"]').val(postion);
        $('#addImageTracNghiem .modal-body input[name="count"]').val(count);

        $('#addImageTracNghiem').modal('show');
    });
    //upload image trac nghiem
    $('#addImageTracNghiem .upImageTn').change(function () {
        var $this = $(this);
        var type = $this.parent('.modal-body').find('input[name="type"]').val();
        var postion = $this.parent('.modal-body').find('input[name="postion"]').val();
        var count = $this.parent('.modal-body').find('input[name="count"]').val();                

        var formData = new FormData();
        formData.append('file', $this[0].files[0]);
        formData.append('_token', $('meta[name=csrf-token]').attr("content"));            
        $.ajax({
         url : upload_image,
         type : 'POST',
         data : formData,
         processData: false,
         contentType: false,
         success : function(data) {    
            $this.val("");
            if(type == 'answer_error')
            {
                $('.answer_box_error .box_image .image_error_'+postion).attr('src',data.image).show();
                //$('.answer_box_error .img_item .btn_img_'+postion+'_'+count).hide();                
                $('.answer_box_error .box_image .input_image_error_'+postion).val(data.url);

            }
            if(type == 'answer')
            {
                $('.answer_box .box_image .image_'+postion).attr('src',data.image).show();
                //$('.answer_box_error .img_item .btn_img_'+postion+'_'+count).hide();                
                $('.answer_box .box_image .input_image_'+postion).val(data.url);
            } 
            if(type == 'question')
            {
                $('.box_question .box_image .image_'+postion).attr('src',data.image).show();
                //$('.answer_box_error .img_item .btn_img_'+postion+'_'+count).hide();                
                $('.box_question .box_image .input_image_'+postion).val(data.url);
            }             
               //$('.image_box .'+type).attr('src',data.image).show();
              // $('.image_box input[name="'+type+'"]').val(data.url);
              // $this.hide();
              $('#addImageTracNghiem').modal('toggle');
          }
      });
    });
    $('body').on('click', '.addQuestionModal .delete_question', function (e) { console.log("xxxx");
        e.preventDefault();
        var $this = $(this);
        var id = $this.attr('data-id');
        var question_type = $this.attr('data-type');
        if(id  == '')
        {

            $this.closest('.box_question_d').remove();
            // if(question_type == 5)
            // {
            //     var question_doan_van = $('.form_dien_tu_doan_van .add_question');
            //     var count_question = question_doan_van.attr('data-count');
            //     if(parseInt(count_question) > 0){
            //         question_doan_van.attr('data-count',parseInt(count_question) -1 );
            //     }
            // }
            return;
        }
        var data = { id:id, question_type :question_type  };
        
        swal({
            title: "Xác nhận",
            text: "Bạn có chắc muốn xóa dữ liệu!", type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Đồng ý",
            closeOnConfirm: false
        },
        function () {
           $.ajax({
             headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
             url : question_delete,
             type : 'POST',
             data : data,
             success : function(data) {                
                if(data.error == false)
                {
                    $this.closest('.box_question_d').remove();                    
                    swal({
                        title: 'Thông báo',
                        text: data.msg,
                        timer: 2000,
                        type: 'success',
                    });
                    if(data.redirect !== undefined)
                    {
                        window.location.href = data.redirect;
                    }
                }else{
                    swal({
                        title: 'Thông báo',
                        text: data.msg,
                        timer: 3000,
                        type: 'error',
                    });
                }
            }
        });   

       });

    });
    //them cau hoi dien tu doan van
     $('body').on('click', '.addQuestion .form_dien_tu_doan_van .add_question', function (e) {        
        e.preventDefault();
        var $this = $(this);                
        var data = { count : $this.attr('data-count')};                                
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
            type: "GET",
            url: question_get_temlate_dien_tu_dv,
            data: data,
            success: function (data) {
                if(data.error == false){
                    $this.closest('.box_add_btn').before(data.template);
                    $this.attr('data-count',data.data);
                    // var questionNr = $('.question_dt').length;
                     generateTinyMCE(data.data);
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
     
    //update question
    // $('.question_edit').on('click',function(e){
    //     e.preventDefault();
    //     var $this = $(this);
    //     var id = $this.attr('data-id');
    //     var data = { id: id };
    //     //console.log($('meta[name=csrf-token]').attr("content")); return;
    //     $.ajax({
    //          headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr("content") },
    //          url : edit_question_route,
    //          type : 'POST',
    //          data : data,
    //          success : function(data) {                
    //             if(data.error == false)
    //             {
    //                 //hide form add
    //                 $('#addQuestion').trigger("reset");
    //                 $('#addQuestionModal').hide();
    //                 //show form edit
    //                 $('.editQuestion .modal-dialog').remove();
    //                 $('.editQuestion').append(data.template);
    //                 $('.editQuestion').show();
    //             }
    //         }
    //   });        

    // });
});