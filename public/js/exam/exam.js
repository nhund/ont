$(document).ready(function () {
    function upCountQuestion() {
        var count_question_current = $('.hoclythuyet .course_process .count_question_done');
        var total_question         = $('.hoclythuyet .course_process .total_question');
        var process_bar            = $('.hoclythuyet .lesson_name .progress-bar');
        var coutn_question_new     = parseInt(count_question_current.text()) + 1;
        count_question_current.text(coutn_question_new);
        var percent = (coutn_question_new / parseInt(total_question.text())) * 100;
        process_bar.css('width', percent + '%');
        $(window).scrollTop(0);
    }

    var submit_question     = false;

    var submit_doc_loadding = false;
    //submit doc
    $('#hoclythuyet .btn_submit_doc').on('click', function (e) {
        e.preventDefault();
        //console.log(submit_doc);
        var $this     = $(this);
        var lesson_id = $this.attr('data-id');

        var data = {lesson_id: lesson_id};
        if (submit_doc_loadding == false) {
            submit_doc_loadding = true;
            $.ajax({
               headers: {'X-CSRF-Token': $('meta[name=csrf-token]').attr("content")},
               type   : "POST",
               url    : submit_doc,
               data   : data,
               success: function (data) {
                   if (data.error == false) {
                       $this.parent('form').submit();
                   }
               },
               error  : function (e) {
               }
           }).always(function () {
            submit_doc_loadding = false;
            });
        }

    });
    // trac nghiem
    $('.trac_nghiem_box .submit_question .btn_next').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var key   = parseInt($this.closest('.question_type').attr('data-key'));
        $('.question_type').hide();
        //console.log(parseInt(key+1));
        $('.question_type.question_stt_' + parseInt(key + 1)).show();

    });
    //hien thi goi y trac nghiem
    $('.trac_nghiem_box .form_trac_nghiem .head_content .box_action .suggest').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.hasClass('open_suggest')) {
            $this.addClass('open_suggest');
            $this.closest('.form_trac_nghiem').find('.head_content .box_suggest').show();
        } else {
            $this.removeClass('open_suggest');
            $this.closest('.form_trac_nghiem').find('.head_content .box_suggest').hide();
        }
    });
    //hien thi goi y trac nghiem cau hoi
    $('.trac_nghiem_box .form_trac_nghiem .list_question .box_suggest_answer .suggest').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.hasClass('open_suggest')) {
            $this.addClass('open_suggest');
            $this.closest('.box_suggest_answer').find('.suggest_answer_content p').show();
        } else {
            $this.removeClass('open_suggest');
            $this.closest('.box_suggest_answer').find('.suggest_answer_content p').hide();
        }
    });
    //kiem tra neu co 1 cau trac nghiem thi submit luon
    $('.trac_nghiem_box .list_answer input[type="radio"]').on('change', function () {
        var $this          = $(this);
        var count_question = $this.closest('.content_question').find('input[name="count_question"]').val();
        if (parseInt(count_question) == 1) {
            $this.closest('.content_question').find('.submit_question .btn_submit').click();
        }
    });
    //submit bai tap trac nghiem
    $('.trac_nghiem_box .submit_question .btn_submit').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var data  = $this.closest('.form_trac_nghiem').serializeArray();
        //console.log(form); return;

        data.push({name : 'question_type', value : 4 });
        $.ajax({
           headers: {
               'X-CSRF-Token': $('meta[name=csrf-token]').attr("content"),
               'Authorization': localStorage.getItem('access_token'),
           },
           type   : "POST",
           url    :  `/api/exam/question/${data[0].value}`,
           data   : data,
           success: function (data) {

               if (parseInt(data.code) === 200) {
                   // hien thi giai thich chung
                   if (data.interpret_all !== '') {
                       var box_interpret_all = $this.closest('.form_trac_nghiem').find('.head_content .box_interpret_all');
                       box_interpret_all.find('span').append(data.interpret_all);
                       //console.log($('#box_interpret_all_'+data.question_id).html());
                       var format_content_temp = document.getElementById('box_interpret_all_' + data.question_id);
                       MathJax.Hub.Queue(["Typeset", MathJax.Hub, format_content_temp]);
                       box_interpret_all.show();
                   }

                   upCountQuestion();
                   $this.closest('.submit_question').find('.btn_next').show();
                   $this.closest('.submit_question').find('.btn_submit').remove();

                   $.each(data.data, function (key, val) {

                       if (val.error == 2) {
                           $('.answer_' + val.answer).closest('.radio').append('<i class="fa fa-check-circle-o"></i>');
                           $('.answer_' + val.answer).closest('.radio').find('label').css('color', '#00C819');

                       } else {
                           $('.answer_' + val.answer).closest('.radio').append('<i class="fa fa-check-circle-o"></i>');
                           $('.answer_' + val.answer).closest('.radio').find('label').css('color', '#00C819');

                           $('.answer_' + val.input).closest('.radio').append('<i class="fa fa-times"></i>');
                           $('.answer_' + val.input).closest('.radio').find('label').css('color', '#FF503B');
                       }
                       // hien thi giai thich chung
                       if (data.interpret !== '') {
                           var box_interpret_child = $('.box_interpret_' + val.question_id);
                           box_interpret_child.find('span').append(val.interpret);
                           var format_content_temp = document.getElementById('box_interpret_all_' + val.question_id);
                           MathJax.Hub.Queue(["Typeset", MathJax.Hub, format_content_temp]);
                           box_interpret_child.show();

                       }
                   });

               } else {
                   toastr.error('Thông báo!', data.msg, {timeOut: 600, positionClass: "toast-top-modify"})
               }
           },
           error  : function (e) {

           }
        }).always(function () {

        });
    });
    //next dien tu
    $('.dientu_box .submit_question .btn_next').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var key   = parseInt($this.closest('.question_type').attr('data-key'));
        $('.question_type').hide();
        //console.log(parseInt(key+1));
        $('.question_type.question_stt_' + parseInt(key + 1)).show();

    });

    //submit dien tu
    $('.dientu_box .submit_question .btn_submit').on('click', function (e) {
        e.preventDefault();
        const $this = $(this);
        let data    = $this.closest('.form_dien_tu').serializeArray();

        data.push({name : 'question_type', value : 3 });

        $.ajax({
           headers: {
               'X-CSRF-Token': $('meta[name=csrf-token]').attr("content"),
               'Authorization': localStorage.getItem('access_token'),
           },
           type   : "POST",
           url    :  `/api/exam/question/${data[0].value}`,
           data   : data,
           success: function (data) {

               if (data.code === 200) {
                   // hien thi giai thich chung
                   var box_interpret_all = $this.closest('form').find('.head_content .box_interpret_all');

                   box_interpret_all.show();

                   upCountQuestion();
                   $this.closest('.submit_question').find('.btn_next').show();
                   $this.closest('.submit_question').find('.btn_submit').remove();


                   $.each(data.data, function (key, val) {
                       if (parseInt(val.error) === 2) {
                           $('.question_id_' + key).find('.result').addClass('true');

                       } else {
                           $('.question_id_' + key).find('.result').addClass('error');
                       }
                       $('.question_id_' + key).find('.user_input span').text(val.input);
                       $('.question_id_' + key).find('.result_ok span').text(val.answer);
                       $('.question_id_' + key).find('.result').show();

                       var box_interpret_child = $('.box_interpret_' + key);
                       box_interpret_child.show();

                   });
               }
           },
           error  : function (e) {}})
            .always(function () {});
    });

    //next dien tu doan van
    $('.dien_tu_doan_van .submit_question .btn_next').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var key   = parseInt($this.closest('.question_type').attr('data-key'));
        $('.question_type').hide();
        //console.log(parseInt(key+1));
        $('.question_type.question_stt_' + parseInt(key + 1)).show();

    });

    //xem goi y dien tu doan van cho tung dap an
    $('.dien_tu_doan_van .list_question .question_item .show_suggest').on('click', function (e) {
        e.preventDefault();
        var $this       = $(this);
        var question_id = $this.closest('form').find('input[name="id"]').val();
        var suggest     = $this.attr('data-title');
        if (suggest == '' || suggest == undefined) {
            return;
        }
        var format_content_temp = document.getElementById("format_content_" + question_id);
        var DynamicMJ           = {
            formula: format_content_temp,
            update : function () {
                var tex                = suggest;
                this.formula.innerHTML = tex;
                MathJax.Hub.Queue(["Typeset", MathJax.Hub, this.formula]);
            }
        };
        DynamicMJ.update();
        swal({
                 title: 'Gợi ý',
                 text : $(format_content_temp).html(),
                 html : true,
             });
        $(format_content_temp).html('');
    });

    //xem goi y cho toan cau
    $('.dien_tu_doan_van .list_question .question_item .icon.suggest').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.closest('.question_item').find('.box_suggest').slideToggle();
    });

    //hien thi goi y dien tu van ban
    $('.dientu_chuoi_box .form_dien_tu_dien_tu_doan_van .head_content .box_action .suggest').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.hasClass('open_suggest')) {
            $this.addClass('open_suggest');
            $this.closest('.form_dien_tu_dien_tu_doan_van').find('.head_content .box_suggest').show();
        } else {
            $this.removeClass('open_suggest');
            $this.closest('.form_dien_tu_dien_tu_doan_van').find('.head_content .box_suggest').hide();
        }
    });


    //submit dien tu doan van
    $('.dien_tu_doan_van .submit_question .btn_submit').on('click', function (e) {
        e.preventDefault();
        const $this = $(this);
        let data  = $this.closest('.form_dien_tu_dien_tu_doan_van').serializeArray();
        //console.log(form); return;
        data.push({name : 'question_type', value : 5 });
        $.ajax({
                   headers: {
                       'X-CSRF-Token': $('meta[name=csrf-token]').attr("content"),
                       'Authorization': localStorage.getItem('access_token'),
                   },
                   type   : "POST",
                   url    :  `/api/exam/question/${data[0].value}`,
                   data   : data,
                   success: function (data) {

                       if (parseInt(data.code) === 200) {
                           // hien thi giai thich chung
                           $this.closest('form').find('.head_content .box_interpret_all').show();

                           upCountQuestion();
                           $this.closest('.submit_question').find('.btn_next').show();
                           $this.closest('.submit_question').find('.btn_submit').remove();

                           $.each(data.data, function (key, val) {
                               $.each(val, function (key2, val2) {
                                   var input_answer = $('.dien_tu_doan_van input[name="txtLearnWord[' + key + '][' + key2 + ']"]');
                                   if (parseInt(val2.error) === 2) {
                                       var tpl = '<span class="answer_error_box sucess"><span class="answer_true">' + val2.answer + '</span><span>';
                                       input_answer.before(tpl);
                                       input_answer.hide();

                                   } else {
                                       var tpl = '<span class="answer_error_box"><span class="answer_error">' + val2.input + '</span><span class="answer_true">' + val2.answer + '</span><span>';
                                       input_answer.before(tpl);
                                       input_answer.hide();
                                   }
                                   var box_interpret_child = $('.box_interpret_' + key);
                                   box_interpret_child.show();
                               });

                           });
                       }
                   },
                   error  : function (e) {

                   }
               }).always(function () {

        });
    });


    //lay goi y
    $('.list_question .answer .explain').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var id    = $this.attr('data-id');
        if ($this.hasClass('active')) {
            $this.closest('.question_item').find('.explain-text').text('');
            $this.closest('.question_item').find('.explain-text').hide();
            $this.removeClass('active');
        } else {
            var data = {id: id};
            $.ajax({
                       headers: {'X-CSRF-Token': $('meta[name=csrf-token]').attr("content")},
                       type   : "POST",
                       url    : getExplain,
                       data   : data,
                       success: function (data) {

                           if (data.error == false) {
                               $this.closest('.question_item').find('.explain-text').text(data.data);
                               $this.closest('.question_item').find('.explain-text').show();
                               $this.addClass('active');
                           }
                       },
                       error  : function (e) {

                       }
                   }).always(function () {

            });
        }

    });


    //bookmark
    var send_bookmark = false;
    $('body').on('click', '.icon.bookmark', function (e) {
        var $this       = $(this);
        var question_id = $this.attr('data-id');
        //book_mark
        if (!send_bookmark) {
            send_bookmark = true;
            var data      = {question_id: question_id};
            $.ajax({
                       headers: {'X-CSRF-Token': $('meta[name=csrf-token]').attr("content")},
                       type   : "POST",
                       url    : book_mark_url,
                       data   : data,
                       success: function (data) {

                           if (data.error == false) {
                               toastr.success('Thông báo!', data.msg, {timeOut: 600, positionClass: "toast-top-modify"})
                               if (data.type == 'add') {
                                   $this.attr('title', 'Bỏ bookmark');
                                   $this.addClass('bookmarked');
                               } else {
                                   $this.attr('title', 'Thêm bookmark');
                                   $this.removeClass('bookmarked');
                               }
                           } else {
                               toastr.error('Thông báo!', data.msg, {timeOut: 600, positionClass: "toast-top-modify"})
                           }
                       },
                       error  : function (e) {

                       }
                   }).always(function () {
                send_bookmark = false;
            });
        }
    });
    $(window).load(function () {
        $('#hoclythuyet .report.send_report').on('click', function (e) {
            e.preventDefault();
            var $this         = $(this);
            var question_id   = $this.attr('data-id');
            var question_type = $this.attr('data-type');
            $('#feedbackModel .modal-body input[name="question_id"]').val(question_id);
            $('#feedbackModel .modal-body input[name="type"]').val(question_type);
            $('#feedbackModel').modal({
                                          show: 'false'
                                      });
        });
    });

});