$(document).ready(function () {



    //kiem tra neu co 1 cau trac nghiem thi submit luon
    $('.trac_nghiem_box .list_answer input[type="radio"]').on('change', function () {
        var $this          = $(this);
        var count_question = $this.closest('.content_question').find('input[name="count_question"]').val();
        if (parseInt(count_question) == 1) {
            $this.closest('.content_question').find('.submit_question .btn_submit').click();
        }
    });

    //next trac nghiem
    $('.submit_question .btn_next').on('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        var key   = parseInt($this.closest('.question_type').attr('data-key'));
        $('.question_type').hide();

        $('.question_type.question_stt_' + parseInt(key + 1)).show();
        $.each($('[data-audio]'), function (i ,au) {au.pause();});
        const type = $this.data('type');
        const stt = $this.data('stt');
        upCountQuestion()
        checkButton($(`[data-stt=${stt + 1}]`));
        reviewResult(stt, type);
    });
});
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

function reviewResult(stt, type) {

    const TYPE_DIEN_TU = 3;
    const TYPE_TRAC_NGHIEM = 4;
    const TYPE_TRAC_NGHIEM_DON = 6;
    const TYPE_DIEN_TU_DOAN_VAN = 5;

    let answer = reviewResults[stt].answer;

    switch (type) {
        case TYPE_DIEN_TU:
            $.each(answer, function (key, val) {

                if (parseInt(val.error) === 2) {
                    $('.question_id_' + key).find('.result').addClass('true');
                } else {
                    $('.question_id_' + key).find('.result').addClass('error');
                }
                $('.question_id_' + key).find('.user_input span').text(val.input);
                $('.question_id_' + key).find('.result_ok span').text(val.answer);
                $('.question_id_' + key).find('.result').show();
            });
            break;
        case TYPE_TRAC_NGHIEM:
            $.each(answer, function (key, val) {

                if (val.error == 2) {
                    $('.answer_' + val.answer).closest('.radio').append('<i class="fa fa-check-circle-o"></i>');
                    $('.answer_' + val.answer).closest('.radio').find('label').css('color', '#7BCDC7');
                } else {
                    $('.answer_' + val.answer).closest('.radio').append('<i class="fa fa-check-circle-o"></i>');
                    $('.answer_' + val.answer).closest('.radio').find('label').css('color', '#7BCDC7');

                    $('.answer_' + val.input).closest('.radio').append('<i class="fa fa-times"></i>');
                    $('.answer_' + val.input).closest('.radio').find('label').css('color', '#FF503B');
                }
            });
            break;
        case TYPE_TRAC_NGHIEM_DON:
            $.each(answer, function (key, val) {
                if (val.error == 2) {
                    $('.answer_' + val.answer).closest('.radio').append('<i class="fa fa-check-circle-o"></i>');
                    $('.answer_' + val.answer).closest('.radio').find('label').css('color', '#7BCDC7');
                } else {
                    $('.answer_' + val.answer).closest('.radio').append('<i class="fa fa-check-circle-o"></i>');
                    $('.answer_' + val.answer).closest('.radio').find('label').css('color', '#7BCDC7');

                    $('.answer_' + val.input).closest('.radio').append('<i class="fa fa-times"></i>');
                    $('.answer_' + val.input).closest('.radio').find('label').css('color', '#FF503B');
                }
            });
            break;
        case TYPE_DIEN_TU_DOAN_VAN:
            $.each(answer, function (key, val) {
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
                });
            });
            break;
    }
}

function checkButton($button){
    let key   = parseInt($button.closest('.question_type').attr('data-key'));
    let totalQuestion = reviewResults.length;
    if (isNaN(key)){
        $('.btn_finish').css('display','inline');
        $button.closest('.submit_question').find('.btn_next').hide();
    } else {
        $button.closest('.submit_question').find('.btn_next').show();
        $button.closest('.submit_question').find('.btn_finish').hide();
    }

}