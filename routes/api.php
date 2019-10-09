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
        });
    });

    Route::namespace('Exam')->prefix('exam')->group(function () {
        Route::get('/{lesson}', 'ExamController@show');
        Route::post('/question/{question}', 'ExamController@submitQuestion');
        Route::get('/{lesson}/rank', 'ExamController@rank');
        Route::get('/{lesson}/result', 'ExamController@result');
    });

    Route::namespace('Lesson')->prefix('lesson')->group(function () {
        Route::get('/{lesson}', 'LessonController@show');
        Route::get('/{lesson}/question', 'LessonController@question');
    });
    Route::namespace('Question')->prefix('question')->group(function () {
        Route::post('/{question}', 'QuestionAnswerController@store');


        Route::post('/{question}/bookmark', 'QuestionController@bookmark');
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
        Route::get('/{course}/rating', 'CourseController@rating');
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
