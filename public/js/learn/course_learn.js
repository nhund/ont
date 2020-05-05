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
                const correct =  report.totalDid > 0 ? Number(report.totalCorrectQuestions*100/report.totalDid).toFixed(0) : 0;

                $('[data-lesson=name]').html(data.data.name);
                $('[data-lesson=des]').html(data.data.description);
                $('[data-lesson=question-did]').html(did);
                $('[data-lesson=question-correct]').html(`${correct}%`);
                $('[data-lesson=total-question]').html(report.totalQuestions);
                $('[data-lesson=title]').html(data.data.name);

                const $new = $('[data-sub-lesson=new]');
                const $wrong =  $('[data-sub-lesson=wrong]');
                const $old =  $('[data-sub-lesson=old]');
                const $bookmark =  $('[data-sub-lesson=bookmark]');

                $('.offer-course').removeClass('disabled-link');

                if (report.totalNewQuestions === 0){
                    $new.closest('a').addClass('disabled-link')
                }
                if (report.totalWrongQuestions === 0){
                    $wrong.closest('a').addClass('disabled-link')
                }
                if (report.totalDid === 0){
                    $old.closest('a').addClass('disabled-link')
                }
                if (report.totalBookmarkQuestions === 0){
                    $bookmark.closest('a').addClass('disabled-link')
                }

                $new.html(report.totalNewQuestions+' câu');
                $wrong.html(report.totalWrongQuestions+' câu');
                $old.html(report.totalDid+' câu');
                $bookmark.html(report.totalBookmarkQuestions+' câu');

                document.getElementById("myNav").style.height = "100%";
                lessonId = lesson_id;
            }
        }
    })
}

function reportExam(lesson_id, slugName){

    $.ajax({
        headers: {
            'X-CSRF-Token': $('meta[name=csrf-token]').attr("content"),
            'Authorization': localStorage.getItem('access_token'),
        },
        type   : "GET",
        url    :  `/api/exam/${lesson_id}/detail?include=userExam`,
        success: function (data) {
            if (data.code === 200){
                const exam = data.data;
                const turnUser    = data.data.userExam ? data.data.userExam.data.turn : 0;
                const name        = $('[data-exam=name]');
                const des         = $('[data-exam=des]');
                const number      = $('[data-exam=number_question]');
                const time_repeat = $('[data-exam=time_repeat]');
                const $minutes    = $('[data-exam=minutes]');
                const minScore    = $('[data-exam=min_score]');
                const urlHTML     = $('[data-exam=href]');
                const rankingUrlHTML  = $('[data-ranking=href]');

                const turn = parseInt(exam.repeat_time) - parseInt(turnUser);

                name.html(exam.name);
                des.html(exam.description);
                number.html(exam.total_question);
                time_repeat.html(turn > 0 ? turn : 0);
                $minutes.html(`${exam.minutes} phút`);
                minScore.html(exam.min_score);

                if (turn <=0 ){
                    urlHTML.addClass('no_action')
                }else {
                    urlHTML[0].setAttribute('href' , `/kiem-tra/bat-dau/${slugName}.${lesson_id}`);
                }
                if (turnUser > 0){
                    rankingUrlHTML[0].setAttribute('href' , `/kiem-tra/${slugName}.${lesson_id}`);
                }else  {
                    rankingUrlHTML.addClass('no_action');
                }
                document.getElementById("exam-modal").style.height = "100%";
            }
        }
    });


}

function recommendationLesson(name, courseId, type) {
    location.href = `/khoa-hoc/${name}.${courseId}/tong-quan/${type}?lesson_id=${lessonId}`
}