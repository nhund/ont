<script type="text/javascript">

    function deleteAnwser(e)
    {
        var $this = $(e);   
        $this.closest('.box_text').remove();
    }
    //format_content
    var current_btn = '';
    function ShowFormatContent(e)
     {

        current_btn = e;
        var textarea = $(current_btn).closest('.box_content_t').find('textarea').val();
        //CKEDITOR.instances['editor_format'].insertText('some text here');
        CKEDITOR.instances['editor_format'].setData(textarea);
        $('#editorQuestion').modal({
            show: 'false',
        });
     }
     function appendFormatContent(e)
     {
        var desc_content =  CKEDITOR.instances['editor_format'].getData();
        var textarea = $(current_btn).closest('.box_content_t').find('textarea');
        textarea.val(desc_content);
        $("#editorQuestion .close").click();
        CKEDITOR.instances['editor_format'].setData('');
        //console.log(desc_content);
     }
     //audio
     var current_audio = '';
     function showAudioUpload(e)
     { 
        current_audio = e;
        $('#UploadAudioQuestion').modal({
            show: 'false',
        });
     }
     function uploadAudio(e)
     {
        var $this = $(e);   
        var formData = new FormData();
        formData.append('file', $this[0].files[0]);
        formData.append('course_id', $('input[name="course_id"]').val());
        formData.append('_token', $('meta[name=csrf-token]').attr("content"));
        $.ajax({
         url : upload_audio,
         type : 'POST',
         data : formData,
         processData: false,
         contentType: false,
         success : function(data) {       
               //$this             
               $this.closest('.modal-body').find('input[name="audio_url"]').val(data.file);
           }
       });

     }
     function appendAudioContent(e)
     {
        var $this = $(e);
        var audio = $this.closest('#UploadAudioQuestion').find('input[name="audio_url"]').val();
        if(audio == '')
        {
            return;
        }
        var parent_audio = $(current_audio).closest('.box_media').find('.box_audio');
        parent_audio.find('.input_audio').val(audio);
        parent_audio.find('.mediPlayer .listen').attr('src',audio);
        var svg = parent_audio.find('.mediPlayer svg');
        
        if(svg.length == 0)
        {
            parent_audio.find('.mediPlayer').mediaPlayer();
        }        
        parent_audio.show();
        $("#UploadAudioQuestion .close").click();
     }
     function deleteAudio(e)
     {
        var $this = $(e);
        $this.closest('.box_audio').find('.input_audio').val('');
        $this.closest('.box_audio').hide();
     }
     $("#UploadAudioQuestion").on('hide.bs.modal', function(){
        $("#UploadAudioQuestion").find('input[name="audio_url"]').val("");        
        $("#UploadAudioQuestion").find('.modal-body input[type="file"]').val("");
      });
     //upload image
     var current_img = '';
     function showImageUpload(e)
     { 
        current_img = e;
        $('#UploadImageQuestion').modal({
            show: 'false',
        });
     }
     function uploadImage(e)
     {
        
        var $this = $(e);   
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
               //$this             
               $this.closest('.modal-body').find('input[name="image_url"]').val(data.file);
               $this.closest('.modal-body').find('img').attr('src',data.file);
           }
       });

     }
     function appendImageContent(e)
     {
        var $this = $(e);
        var image = $this.closest('#UploadImageQuestion').find('input[name="image_url"]').val();
        if(image == '')
        {
            return;
        }
        var parent_image = $(current_img).closest('.box_media').find('.box_image');
        parent_image.find('.input_image').val(image);
        parent_image.find('img').attr('src',image);
        parent_image.show();
        $("#UploadImageQuestion .close").click();
     }
     function deleteImage(e)
     {
        var $this = $(e);
        $this.closest('.box_image').find('.input_image').val('');
        $this.closest('.box_image').hide();
     }
     $("#UploadImageQuestion").on('hide.bs.modal', function(){
        $("#UploadImageQuestion").find('input[name="image_url"]').val("");
        $("#UploadImageQuestion").find('.modal-body img').attr('src','');
        $("#UploadImageQuestion").find('.modal-body input[type="file"]').val("");
      });
</script>