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

    function audioAnswer(flagAnswer) {
        if (flagAnswer){
            document.getElementById('correct-answer').play()
        }else {
            document.getElementById('false-answer').play()
        }
    }

    var submit_question     = false;
    var submit_doc_loadding = false;

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
        const questionType = $this.data('type')
        data.push({name : 'question_type', value : questionType });
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
                   checkButton($this)

                   let answer = data.data.answer;
                    let  flagAnswer = true;
                   $.each(answer, function (key, val) {

                       if (val.error == 2) {
                           $('.answer_' + val.answer).closest('.radio').append('<i class="fa fa-check-circle-o"></i>');
                           $('.answer_' + val.answer).closest('.radio').find('label').css('color', '#7BCDC7');

                       } else {
                           flagAnswer = false;
                           $('.answer_' + val.answer).closest('.radio').append('<i class="fa fa-check-circle-o"></i>');
                           $('.answer_' + val.answer).closest('.radio').find('label').css('color', '#7BCDC7');

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
                   audioAnswer(flagAnswer)
                   showAnswers(resultExam = data.data.result);

               } else {
                   if (data.error) {
                       notify(data.error.answers[0])
                   }else {
                       notify(data.message)
                   }
               }
           },
           error  : function (e) {

           }
        }).always(function () {

        });
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
                   checkButton($this);
                   let answer = data.data.answer;
                   let  flagAnswer = true;
                   $.each(answer, function (key, val) {

                       if (parseInt(val.error) === 2) {
                           $('.question_id_' + key).find('.result').addClass('true');

                       } else {
                           flagAnswer = false;
                           $('.question_id_' + key).find('.result').addClass('error');
                       }
                       $('.question_id_' + key).find('.user_input span').text(val.input);
                       $('.question_id_' + key).find('.result_ok span').text(val.answer);
                       $('.question_id_' + key).find('.result').show();

                       var box_interpret_child = $('.box_interpret_' + key);
                       box_interpret_child.show();

                   });
                   audioAnswer(flagAnswer)
                   showAnswers(resultExam = data.data.result);
               } else {
                   notify(data.message)
               }
           },
           error  : function (e) {}})
            .always(function () {});
    });

    //next question
    $('.submit_question .btn_next').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var key   = parseInt($this.closest('.question_type').attr('data-key'));
        $.each($('[data-audio]'), function (i ,au) {au.pause();});
        $('.question_type').hide();
        $('.question_type.question_stt_' + parseInt(key + 1)).show();

    });

    //xem goi y dien tu doan van cho tung dap an
    $('.dien_tu_doan_van .list_question .question_item .show_suggest').on('click', function (e) {
        e.preventDefault();
        var format_content_temp = 'Tính năng không hoạt động khi làm bài kiểm tra';
        swal({
             title: 'Thông báo',
             text : format_content_temp,
             html : true,
         });
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
                           checkButton($this)

                           let answer = data.data.answer
                           let  flagAnswer = true;
                           $.each(answer, function (key, val) {
                               $.each(val, function (key2, val2) {
                                   var input_answer = $('.dien_tu_doan_van input[name="txtLearnWord[' + key + '][' + key2 + ']"]');
                                   if (parseInt(val2.error) === 2) {
                                       var tpl = '<span class="answer_error_box sucess"><span class="answer_true">' + val2.answer + '</span><span>';
                                       input_answer.before(tpl);
                                       input_answer.hide();

                                   } else {
                                       flagAnswer = false;
                                       var tpl = '<span class="answer_error_box"><span class="answer_error">' + val2.input + '</span><span class="answer_true">' + val2.answer + '</span><span>';
                                       input_answer.before(tpl);
                                       input_answer.hide();
                                   }
                                   var box_interpret_child = $('.box_interpret_' + key);
                                   box_interpret_child.show();
                               });

                           });
                           audioAnswer(flagAnswer)
                           showAnswers(resultExam = data.data.result);
                       }else {
                           notify(data.message)
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

    function checkButton($button){
        let key   = parseInt($button.closest('.question_type').attr('data-key'));
        let totalQuestion = $('input[name=totalQuestion]').val();
        if (key == totalQuestion ){
            $button.closest('.submit_question').find('.btn_finish').show();
            $button.closest('.submit_question').find('.btn_next').remove();
            $button.closest('.submit_question').find('.btn_submit').remove();
        } else {
            $button.closest('.submit_question').find('.btn_next').show();
            $button.closest('.submit_question').find('.btn_submit').remove();
            $button.closest('.submit_question').find('.btn_finish').remove();
        }

    }

    function notify(message= '', type = 'danger'){
        $.notify({
                     icon   : 'fa fa-warning',
                     title  : 'Lỗi! ',
                     message: message
                 }, {
                     element  : 'body',
                     type     : type,
                     placement: {
                         from : "top",
                         align: "center"
                     },
                     z_index  : 9999,
                     delay    : 3000,
                     timer    : 1000,
                 });
    }
    $(window).load(function () {
        $('#hoclythuyet .report.send_report').on('click', function (e) {
            e.preventDefault();
            var $this         = $(this);
            var question_id   = $this.attr('data-id');
            var question_type = $this.attr('data-type');
            $('#feedbackModel .modal-body input[name="question_id"]').val(question_id);
            $('#feedbackModel .modal-body input[name="type"]').val(question_type);
            $('#feedbackModel').modal({show: 'false'});
        });
    });

    $(document).ajaxComplete(function() {$('.btn_submit').prop('disabled', false)});
    $(document).ajaxStart(function() {$('.btn_submit').prop('disabled', true)});

});

function showAnswers(results){
    let resultHtml ='';
    if (results){
        results.forEach(function (result, index) {
            let element  = `<div class="part-${result.id}"><div>${result.name}</div>`;
            let userExamAnswers = result.user_exam_answer;
                if (userExamAnswers) {
                    userExamAnswers.forEach(function (userExamAnswer, indexUserExamAnswer) {
                        const answers = userExamAnswer.answer;
                        if (answers) {
                            element += `<div><div class="number-question ${parseInt(userExamAnswer.status) === 2 ? 'answer-true' : 'answer-false'}">Câu ${indexUserExamAnswer + 1}</div>`;
                            Object.keys(answers).forEach(function (key, index) {
                                const subAnswers = answers[key];
                                if (subAnswers[1]) {
                                    Object.keys(subAnswers).forEach(function (id, indexs) {

                                        const trueOrFalse =  parseInt(subAnswers[id].error) === 2 ? 'answer-true' : 'answer-false';

                                        if(Object.keys(subAnswers).length === 1){
                                            element += `<div class="answer-question ${trueOrFalse}">${subAnswers[id].input_text ? subAnswers[id].input_text : '------' }</div>`
                                        }else {
                                            element += `<div class="answer-question ${trueOrFalse}">${indexs + 1} - ${subAnswers[id].input_text ? subAnswers[id].input_text : '------' }</div>`
                                        }
                                    });
                                }else {
                                    const trueOrFalse =  parseInt(answers[key].error) === 2 ? 'answer-true' : 'answer-false';
                                    if(Object.keys(answers).length === 1){
                                        element += `<div class="answer-question ${trueOrFalse}">${answers[key].input_text ? answers[key].input_text : '------' }</div>`
                                    }else {
                                        element += `<div class="answer-question ${trueOrFalse}">${index + 1} - ${answers[key].input_text ? answers[key].input_text : '------' }</div>`
                                    }
                                }
                            });
                            element += `</div><div class="clearfix"></div>`;
                        }
                    })
                }

            element += `</div><div class="clearfix"></div>`;
            resultHtml += element;
        });
        $('.result-exam').html(resultHtml)
    } 
}