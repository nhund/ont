<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Auth')->group(function () {
    Route::post('login', 'LoginController@store');
    Route::post('register', 'RegisterController@store');
//    Route::post('redirect/facebook', 'LoginController@redirect');
//    Route::post('callback/facebook', 'RegisterController@callback');
//    Route::post('redirect/google', 'LoginController@redirect');
//    Route::post('callback/google', 'RegisterController@callback');
});

Route::post('social/{provider}/authenticate', 'Api\Auth\Social\SocialController@authenticate');

Route::middleware(['auth:api'])->namespace('Api')->group(function () {

    Route::namespace('User')->group(function () {

        Route::prefix('me')->group(function () {
            Route::get('/', 'UserController@show');
            Route::post('/', 'UserController@update');
            Route::post('/avatar', 'UserController@updateAvatar');
            Route::post('/password', 'UserController@updatePassword');

            Route::get('/courses', 'UserCourseController@courses');
            Route::get('/courses/report', 'UserCourseController@report');
            Route::post('/courses/add', 'UserCourseController@store');
            Route::get('/courses/{course}', 'UserCourseController@detail');
            Route::delete('/courses/{course}', 'UserCourseController@delete');
        });
    });

    Route::namespace('Exam')->prefix('exam')->group(function () {
        Route::get('/{lesson}', 'ExamController@show');
        Route::post('/question/{question}', 'ExamController@submitQuestion');
        Route::get('/{lesson}/rank', 'ExamController@rank');
        Route::get('/{lesson}/result', 'ExamController@resultExam');
        Route::get('/{lesson}/result/detail', 'ExamController@detailResult');
        Route::get('/{lesson}/detail', 'ExamController@detail');
        Route::post('/{lesson}/submit', 'ExamController@submitExam');
        Route::post('/{lesson}/stop', 'ExamController@stopExam');
        Route::post('/{lesson}/finish', 'ExamController@finish');
        Route::post('/{lesson}/restart', 'ExamController@restartExam');
    });

    Route::namespace('Lesson')->prefix('lesson')->group(function () {
        Route::get('/{lesson}', 'LessonController@show');
        Route::get('/{lesson}/question', 'LessonController@question');
        Route::get('/{lesson}/report', 'LessonController@report');
    });
    Route::namespace('Question')->prefix('question')->group(function () {
        Route::post('/{question}', 'QuestionAnswerController@store');
        Route::post('/{lesson}/theory', 'QuestionAnswerController@theory');

        Route::post('/{question}/bookmark', 'QuestionController@bookmark');
        Route::post('/{question}/feedback', 'QuestionController@feedback');
    });

    Route::namespace('Comment')->prefix('comment')->group(function (){

        Route::prefix('course')->group(function () {
            Route::post('/{course}', 'CommentCourseController@store');
            Route::get('/{course}', 'CommentCourseController@index');
        });

        Route::prefix('question')->group(function () {
            Route::post('/{question}', 'CommentQuestionController@store');
            Route::get('/{question}', 'CommentQuestionController@index');
        });
    });

    Route::namespace('Course')->group(function (){
        Route::post('courses/{course}/rating', 'RatingController@store');
    });

    Route::namespace('Recommendation')->prefix('recommendation')->group(function (){
        Route::get('course/{course}/replay', 'RecommendationController@replay');
        Route::get('course/{course}/new', 'RecommendationController@new');
        Route::get('course/{course}/bookmark', 'RecommendationController@bookmark');
        Route::get('course/{course}/wrong', 'RecommendationController@wrong');
        Route::get('course/{course}/suggest', 'RecommendationController@suggest');
        Route::get('course/{course}/report', 'RecommendationController@report');
        Route::get('lesson/{lesson}/click', 'RecommendationController@click');
    });

});

Route::namespace('Api')->group(function () {

    Route::namespace('Slide')->prefix('slide')->group(function () {
        Route::get('/', 'SlideController@index');
    });

    Route::namespace('Course')->prefix('courses')->group(function () {
        Route::get('/free', 'CourseController@freeCourses');
        Route::get('/sticky', 'CourseController@StickyCourses');
        Route::get('/other', 'CourseController@otherCourses');
        Route::get('/search', 'CourseController@search');
        Route::get('/{course}/detail', 'CourseController@show');
        Route::get('/{course}/rating', 'RatingController@index');
    });

    Route::namespace('School')->prefix('schools')->group(function () {
        Route::get('/', 'SchoolController@index');
        Route::get('/all', 'SchoolController@allSchool');
        Route::get('/{school_id}/report', 'SchoolController@report');

        Route::get('/{school_id}/free', 'SchoolCourseController@freeCourses');
        Route::get('/{school_id}/sticky', 'SchoolCourseController@StickyCourses');
        Route::get('/{school_id}/other', 'SchoolCourseController@otherCourses');
    });

    Route::namespace('User')->group(function () {
        Route::prefix('me')->group(function () {

            Route::post('/courses/add', 'UserCourseController@store');
        });
    });
});
