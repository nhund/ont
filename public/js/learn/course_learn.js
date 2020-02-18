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
var lessonId;

function reportLesson(lesson_id){
    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr("content"),
            'Authorization': localStorage.getItem('access_token'),
        },
        type   : "GET",
        url    :  `/api/lesson/${lesson_id}/report`,
        success: function (data) {
            if (data.meta) {
                const report = data.meta;
                const did = `${report.totalDid}<span style="font-size: 15px;">/${report.totalQuestions}</span>`;
                const correct =  Number(report.totalCorrectQuestions*100/report.totalQuestions).toFixed(2);
                $('[data-lesson=total-question]').html(report.totalQuestions);
                $('[data-lesson=question-did]').html(did);
                $('[data-lesson=question-correct]').html(`${correct}%`);
                $('[data-lesson=title]').html(data.data.name);
                document.getElementById("myNav").style.height = "100%";
                lessonId = lesson_id;
            }
        }
    })
}

function reportExam(strName,slugName,  strDes, exam){

    exam   = JSON.parse(exam);
    const name        = $('[data-exam=name]');
    const des         = $('[data-exam=des]');
    const number      = $('[data-exam=number_question]');
    const time_repeat = $('[data-exam=time_repeat]');
    const minutes     = $('[data-exam=minutes]');
    const minScore    = $('[data-exam=min_score]');
    const urlHTML    =  $('[data-exam=href]');

    name.html(strName);
    des.html(strDes);
    number.html(exam.total_question);
    time_repeat.html(exam.repeat_time);
    minutes.html(exam.minutes);
    minScore.html(exam.min_score);

    urlHTML[0].setAttribute('href' , `/kiem-tra/bat-dau/${slugName}.${exam.lesson_id}`);
    document.getElementById("exam-modal").style.height = "100%";
}

function recommendationLesson(name, courseId, type) {
    if (type === 'lam-bai-tap') {
        location.href = `/bai-tap/lesson/${name}.${lessonId}/${type}?lesson_id=${lessonId}`
    }else {
        location.href = `/khoa-hoc/${name}.${courseId}/tong-quan/${type}?lesson_id=${lessonId}`
    }
}