<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
if (App::environment('production')) {
    URL::forceScheme("https");
}
Route::get('/test', 'FrontEnd\HomeController@test')->name('test');

Route::namespace('Auth')->group(function () {
    Route::post('oauth/token/refresh', 'AuthenticationController@refreshAccessToken');
    Route::namespace('Web')->group(function () {
        Route::post('auth/login', 'LoginController@login')->name('login');
        Route::post('auth/logout', 'LoginController@logout')->name('logout');
        Route::post('/register', 'RegisterController@store')->name('register');
    });
});

//Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/logout-acount', 'FrontEnd\HomeController@logoutAcount')->name('logoutAcount');
/* login facebook */
Route::get('/fblogin', 'FrontEnd\AuthController@FBRedirect')->name('login.facebook');
Route::get('/facebook/callback', 'FrontEnd\AuthController@FBCallback')->name('login.facebook.fbcallback');
/* login google */
Route::get('/gglogin', 'FrontEnd\AuthController@GGRedirect')->name('auth.gglogin');
Route::get('/google/callback', 'FrontEnd\AuthController@GGCallback')->name('auth.ggcallback');

Route::get('/uploadPhoto', 'HomeController@uploadPhoto')->name('uploadPhoto');

Route::get('/', 'FrontEnd\HomeController@index')
            ->name('home');
Route::get('/chinh-sach-rieng-tu', 'FrontEnd\HomeController@chinhsachriengtu')
            ->name('chinhsachriengtu');
Route::get('/dieu-khoan-su-dung', 'FrontEnd\HomeController@dieukhoansudung')
            ->name('dieukhoansudung');                        
Route::get('/khoa-hoc', 'FrontEnd\CourseController@courseList')
            ->name('courseList');
Route::get('khoa-hoc/{title}.{id}', 'FrontEnd\CourseController@courseDetail')
            ->name('courseDetail');  
Route::get('/lien-he', 'FrontEnd\HomeController@contact')
            ->name('contact');                 
Route::post('/contact', 'FrontEnd\HomeController@contactPost')
            ->name('contactPost');
Route::get('/khoa-hoc-cua-toi', 'FrontEnd\CourseController@myCourse')
            ->name('myCourse');
Route::get('/khoa-hoc-da-tao', 'FrontEnd\CourseController@courseCreated')
            ->name('courseCreated');            
Route::get('/khoa-hoc-tro-giang', 'FrontEnd\CourseController@courseSupport')
            ->name('courseSupport');                        
Route::get('/user-info', 'FrontEnd\UserController@userInfo')
            ->name('userInfo');
Route::get('/user/change-password', 'FrontEnd\UserController@userChangePass')
            ->name('user.change.password');
Route::post('/user/save-password', 'FrontEnd\UserController@saveChangePass')
            ->name('user.change.password.post');            
Route::post('/user-info-update', 'FrontEnd\UserController@updateUserInfo')
            ->name('user.edit.userInfo');    
Route::post('/upload-avatar', 'FrontEnd\UserController@uploadAvatar')
            ->name('user.upload.avatar');                          
Route::prefix('course')->group(function () { 
        Route::get('/user/course/add', 'FrontEnd\UserCourseController@add')
                    ->name('user.course.add');
        Route::post('/comment/add', 'FrontEnd\CommentController@addComment')
                    ->name('user.course.comment.add');  
        Route::post('/comment/delete', 'FrontEnd\CommentController@deleteComment')
            ->name('user.course.comment.delete');                       
        Route::post('/buy', 'FrontEnd\UserCourseController@add')
            ->name('user.course.buy');     
        Route::post('/rating', 'FrontEnd\RatingController@add')
            ->name('user.course.rating');                  
        }); 
Route::prefix('bai-viet')->group(function () { 
        Route::get('/{title}.{id}', 'FrontEnd\PostController@detail')
                    ->name('post.detail');             
        });                         
Route::get('/khoa-hoc/{title}.{id}/tong-quan', 'FrontEnd\CourseLearnController@course')
        ->name('course.learn');
Route::get('/khoa-hoc/{title}.{id}/tong-quan/{type}', 'FrontEnd\CourseLearnController@courseTypeLearn')
        ->name('course.courseTypeLearn');  
Route::get('/search', 'FrontEnd\SearchController@search')
            ->name('search');  
Route::prefix('bai-tap')->group(function () { 
                // Route::get('/hoc-ly-thuyet.{id}', 'FrontEnd\CourseLearnController@lyThuyet')
                //             ->name('user.lambaitap.lythuyet');       
                Route::post('/get-explain', 'FrontEnd\CourseLearnController@getExplain')
                        ->name('user.lambaitap.getExplain');       
                Route::get('/hoc-ly-thuyet.{id}', 'FrontEnd\CourseLearnController@lyThuyet')
                            ->name('user.lambaitap.lythuyet');  

                Route::post('/hoc-ly-thuyet', 'FrontEnd\CourseLearnController@lyThuyetSubmit')
                            ->name('user.lambaitap.lyThuyetSubmit');     
                Route::get('/lesson/{title}.{id}/{type}', 'FrontEnd\CourseLearnController@question')
                            ->name('user.lambaitap.question');   
                Route::post('/question/submit', 'FrontEnd\CourseLearnController@questionSubmit')
                            ->name('user.lambaitap.questionSubmit');    
                Route::post('/bookmark', 'FrontEnd\BookmarkController@bookMark')
                            ->name('user.question.bookMark');                                                                     
                });                

Route::prefix('wallet')->group(function () { 
                Route::get('/history', 'FrontEnd\WalletController@history')
                    ->name('user.wallet.history');   
                Route::get('/add', 'FrontEnd\WalletController@add')
                    ->name('user.wallet.add');   
                Route::post('/add', 'FrontEnd\WalletController@addPost')
                    ->name('user.wallet.addPost');                  
                });                
    
Route::post('add-feedback','FrontEnd\HomeController@addFeedback')->name('feedback.add');    

                    /**      Route admin      * */
Route::group(['middleware' => 'admin','prefix' => 'admin'],function () {
    Route::get('/', 'BackEnd\DashBoardController@index')
        ->name('dashboard');
    /**
     * upload images toold
     */
    Route::get('/tool-upload', 'BackEnd\DashBoardController@toolUpload')
        ->name('admin.toolUpload');
    Route::any('/tool-upload-save', 'BackEnd\DashBoardController@toolUploadSave')
        ->name('admin.toolUploadSave');
    Route::any('/tool-upload-delete-image', 'BackEnd\DashBoardController@toolUploadDelete')
        ->name('admin.toolUploadDelete');    
    /** and upload images */
            
    Route::get('/test', 'BackEnd\DashBoardController@test')
        ->name('admin.test');   
    Route::post('/test-save', 'BackEnd\DashBoardController@testSave')
        ->name('admin.testSave');        
    Route::prefix('code')->group(function () {
        Route::get('/list', 'BackEnd\CodeController@listCode')
            ->name('code.list');
        Route::post('/handle', 'BackEnd\CodeController@handle')
            ->name('code.handle');
    });

    Route::prefix('course')->group(function () {
        Route::get('/add', 'BackEnd\CourseController@addCourse')->name('addcourse');
        Route::get('/edit/{id}', 'BackEnd\CourseController@editCourse')->name('admin.course.edit');
        Route::post('/handle', 'BackEnd\CourseController@handle')->name('course.handle');
        Route::get('/detail/{id}', 'BackEnd\CourseController@detail')->name('course.detail');
        Route::post('/addLesson', 'BackEnd\CourseController@addLesson')->name('course.addLesson');
        Route::post('/addLevel2', 'BackEnd\CourseController@addLevel2')->name('course.addLevel2');
        Route::post('/addExam', 'BackEnd\CourseController@addExam')->name('course.addExam');
        Route::get('/{id}/listUser', 'BackEnd\CourseController@listUser')->name('admin.course.listUser');
        Route::post('/changeUserStatus', 'BackEnd\CourseController@changeUserStatus')->name('course.changeUserStatus');
        Route::post('/addUser', 'BackEnd\CourseController@addUser')->name('course.addUser');
        Route::get('/{id}/feedback', 'BackEnd\CourseController@feedback')->name('course.feedback');

        Route::get('/list', 'BackEnd\CourseController@listCourse')->name('admin.course.index');     
        Route::post('/delete', 'BackEnd\CourseController@delete')->name('admin.course.delete');   

        Route::post('/user/approval', 'BackEnd\CourseController@userApproval')->name('admin.course.user.approval');    

        Route::post('/sticky', 'BackEnd\CourseController@changeSticky')->name('admin.course.changeSticky');

        Route::prefix('support')->group(function () {
            Route::get('/sugges-user', 'BackEnd\SupportController@suggesUser')->name('admin.course.support.suggesUser');
            Route::get('/{id}', 'BackEnd\SupportController@index')->name('admin.course.support.index');
            Route::get('/add', 'BackEnd\SupportController@add')->name('admin.course.support.add');
            Route::post('/save', 'BackEnd\SupportController@save')->name('admin.course.support.save');            
            Route::post('/delete', 'BackEnd\SupportController@delete')->name('admin.course.support.delete');
        });
    });
    Route::prefix('question')->group(function () {
        Route::get('/get-template-flashcard', 'BackEnd\QuestionController@getTemplateFlashCard')
            ->name('admin.question.getTemplateFlashCard');    
        Route::get('/get-template-trac-nghiem', 'BackEnd\QuestionController@getTemplateTracNghiem')
            ->name('admin.question.getTemplateTracNghiem');
        Route::get('/get-template-dien-tu', 'BackEnd\QuestionController@getTemplateDienTu')
            ->name('admin.question.getTemplateDienTu');     
        Route::get('/edit', 'BackEnd\QuestionController@edit')
            ->name('admin.question.edit');
        Route::post('/edit-save', 'BackEnd\QuestionController@editSave')
            ->name('admin.question.editSave');    

        Route::post('/detele', 'BackEnd\QuestionController@delete')
            ->name('admin.question.delete');   
        Route::get('/get-template-dien-tu-chuoi', 'BackEnd\QuestionController@getTemplateDienTuDoanvan')
            ->name('admin.question.getTemplateDienTuDoanvan');      
        Route::get('/order/{id}', 'BackEnd\QuestionController@order')
            ->name('admin.question.order');
        Route::post('/order/save', 'BackEnd\QuestionController@orderSave')
            ->name('admin.question.order.save');    
        
    });
    Route::prefix('lesson')->group(function () {
        Route::get('/{id}', 'BackEnd\LessonController@detail')
            ->name('lesson.detail');
        Route::post('/handle', 'BackEnd\LessonController@handle')
            ->name('lesson.handle');
        Route::post('/handleExercise', 'BackEnd\LessonController@handleExercise')
            ->name('lesson.handleEx');
        Route::get('/delete/{id}', 'BackEnd\LessonController@deleteLesson')
            ->name('lesson.delete');
        Route::get('/order/{id}', 'BackEnd\LessonController@order')
            ->name('lesson.order');
        Route::post('/order/save', 'BackEnd\LessonController@orderSave')
            ->name('lesson.order.save');    
        Route::post('/delete', 'BackEnd\LessonController@deleteLessonPost')
            ->name('lesson.delete.post');        
    });

    Route::prefix('exam')->group(function () {
        Route::get('/{id}', 'BackEnd\ExamController@detail')->name('exam.detail');
        Route::post('/', 'BackEnd\ExamController@store')->name('exam.store');
        Route::post('/part', 'BackEnd\ExamController@partExam')->name('exam.partExam');
    });

    Route::prefix('exercise')->group(function () {
        Route::post('/upload', 'BackEnd\ExerciseController@upload')
            ->name('exercise.upload');
        Route::post('/handle', 'BackEnd\ExerciseController@handle')
            ->name('exercise.handle');
    });
    Route::prefix('question')->group(function () {
        Route::post('/add', 'BackEnd\QuestionController@add')
            ->name('admin.question.add');
    });
    Route::prefix('document')->group(function () {
        Route::get('/{id}', 'BackEnd\DocumentController@listDocument')
            ->name('document.list');
        Route::post('/handle', 'BackEnd\DocumentController@handle')
            ->name('document.handle');
        Route::get('/download/{id}', 'BackEnd\DocumentController@getDownload')
            ->name('document.download');
        Route::get('/delete/{id}', 'BackEnd\DocumentController@delete')
            ->name('document.delete');
        Route::post('/infor', 'BackEnd\DocumentController@infor')
            ->name('document.information');
    });
    Route::prefix('category')->group(function () {
        Route::get('/', 'BackEnd\CategoryController@index')->name('admin.category.index');
        Route::get('/add', 'BackEnd\CategoryController@add')->name('admin.category.add');
        Route::post('/save', 'BackEnd\CategoryController@save')->name('admin.category.save');
        Route::get('/edit/{id}', 'BackEnd\CategoryController@edit')->name('admin.category.edit')->where('id', '[0-9]+');
        Route::post('/update', 'BackEnd\CategoryController@update')->name('admin.category.update');
        Route::post('/delete', 'BackEnd\CategoryController@delete')->name('admin.category.delete');
    });  
    Route::prefix('slider')->group(function () {
        Route::get('/', 'BackEnd\SliderController@index')->name('admin.slider.index');
        Route::get('/add', 'BackEnd\SliderController@add')->name('admin.slider.add');
        Route::post('/save', 'BackEnd\SliderController@save')->name('admin.slider.save');
        Route::get('/edit/{id}', 'BackEnd\SliderController@edit')->name('admin.slider.edit')->where('id', '[0-9]+');
        Route::post('/update', 'BackEnd\SliderController@update')->name('admin.slider.update');
        Route::post('/delete', 'BackEnd\SliderController@delete')->name('admin.slider.delete');
    });    

    Route::prefix('about')->group(function () {
        Route::get('/', 'BackEnd\AboutController@index')->name('admin.about.index');
        Route::post('/save', 'BackEnd\AboutController@save')->name('admin.about.save');
    });

    Route::prefix('founder')->group(function () {
        Route::get('/', 'BackEnd\FounderController@index')->name('admin.founder.index');
        Route::get('/add', 'BackEnd\FounderController@add')->name('admin.founder.add');
        Route::post('/save', 'BackEnd\FounderController@save')->name('admin.founder.save');
        Route::get('/edit/{id}', 'BackEnd\FounderController@edit')->name('admin.founder.edit')->where('id', '[0-9]+');
        Route::post('/update', 'BackEnd\FounderController@update')->name('admin.founder.update');
        Route::post('/delete', 'BackEnd\FounderController@delete')->name('admin.founder.delete');
    });
    Route::prefix('user-feel')->group(function () {
        Route::get('/', 'BackEnd\UserFeelController@index')->name('admin.user_feel.index');
        Route::get('/add', 'BackEnd\UserFeelController@add')->name('admin.user_feel.add');
        Route::post('/save', 'BackEnd\UserFeelController@save')->name('admin.user_feel.save');
        Route::get('/edit/{id}', 'BackEnd\UserFeelController@edit')->name('admin.user_feel.edit')->where('id', '[0-9]+');
        Route::post('/update', 'BackEnd\UserFeelController@update')->name('admin.user_feel.update');
        Route::post('/delete', 'BackEnd\UserFeelController@delete')->name('admin.user_feel.delete');
    });
    Route::prefix('school')->group(function () {
        Route::get('/', 'BackEnd\SchoolController@index')->name('admin.school.index');
        Route::get('/add', 'BackEnd\SchoolController@add')->name('admin.school.add');
        Route::post('/save', 'BackEnd\SchoolController@save')->name('admin.school.save');
        Route::get('/edit/{id}', 'BackEnd\SchoolController@edit')->name('admin.school.edit')->where('id', '[0-9]+');
        Route::post('/update', 'BackEnd\SchoolController@update')->name('admin.school.update');
        Route::post('/delete', 'BackEnd\SchoolController@delete')->name('admin.school.delete');
    });
    Route::prefix('post')->group(function () {
        Route::get('/', 'BackEnd\PostController@index')->name('admin.post.index');
        Route::get('/add', 'BackEnd\PostController@add')->name('admin.post.add');
        Route::post('/save', 'BackEnd\PostController@save')->name('admin.post.save');
        Route::get('/edit/{id}', 'BackEnd\PostController@edit')->name('admin.post.edit')->where('id', '[0-9]+');
        Route::post('/update', 'BackEnd\PostController@update')->name('admin.post.update');
        Route::post('/delete', 'BackEnd\PostController@delete')->name('admin.post.delete');
    });
    Route::prefix('user')->group(function () {
        Route::get('/', 'BackEnd\UserController@index')->name('admin.user.index');
        Route::get('/add', 'BackEnd\UserController@add')->name('admin.user.add');
        Route::post('/save', 'BackEnd\UserController@save')->name('admin.user.save');
        Route::get('/edit/{id}', 'BackEnd\UserController@edit')->name('admin.user.edit')->where('id', '[0-9]+');
        Route::post('/update', 'BackEnd\UserController@update')->name('admin.user.update');
        Route::post('/delete', 'BackEnd\UserController@delete')->name('admin.user.delete');
    });
     Route::prefix('contact')->group(function () {
        Route::get('/', 'BackEnd\DashBoardController@indexContact')->name('admin.contact.index');        
        Route::post('/delete', 'BackEnd\DashBoardController@deleteContact')->name('admin.contact.delete');
    });
    Route::prefix('import')->group(function () {
        Route::post('/course', 'BackEnd\ImportController@importCourse')->name('admin.import.course');
        Route::post('/audio', 'BackEnd\ImportController@importAudio')->name('admin.import.audio');
        Route::post('/image', 'BackEnd\ImportController@importImage')->name('admin.import.image');
        Route::post('/ckeditor-image', 'BackEnd\ImportController@importImageCkeditor')->name('admin.import.imageCkeditor');
        Route::post('/ckeditor-image-post', 'BackEnd\ImportController@importImagePost')->name('admin.import.importImagePost');
    });
    Route::prefix('export')->group(function () {
        Route::get('/export-question/{id}', 'BackEnd\ExportController@exportQuestion')->name('admin.export.question');
    });
    Route::prefix('feedback')->group(function () {
        Route::get('/', 'BackEnd\FeedbackController@index')->name('admin.feedback.index');       
        Route::get('/edit-question', 'BackEnd\FeedbackController@editQuestion')->name('admin.feedback.editQuestion');        
    });
    
    Route::prefix('menu')->group(function () {
        Route::get('/', 'BackEnd\MenuController@index')->name('admin.menu.index');
        Route::get('/add', 'BackEnd\MenuController@add')->name('admin.menu.add');
        Route::post('/save', 'BackEnd\MenuController@save')->name('admin.menu.save');
        Route::get('/edit/{id}', 'BackEnd\MenuController@edit')->name('admin.menu.edit')->where('id', '[0-9]+');
        Route::post('/update', 'BackEnd\MenuController@update')->name('admin.menu.update');
        Route::post('/delete', 'BackEnd\MenuController@delete')->name('admin.menu.delete');
        Route::post('/order', 'BackEnd\MenuController@order')->name('admin.menu.order');
    });
         

    
});
