<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
    Route::namespace('App\Http\Controllers\CP')->group(function () {
        Route::get('admin', function() {
            if (auth()->check() && in_array(auth()->user()->type, [1, 5]))
                return redirect()->route('ws.home');
            return redirect()->route('ws.login');
        });

        Route::middleware('AdminAuth')->group(function () {

            Route::prefix('admin')->group(function () {

                Route::get('dashboard', 'LoginController@dashboard')->name('admin.dashboard');

                Route::get('logout', 'LoginController@logout')->name('admin.logout');

                Route::prefix('countries')->name('countries')->middleware('checkPermission:settings')->group(function () {
                    Route::get('/', 'CountryController@index');
                    Route::any('/list', 'CountryController@list')->name('.list');
                    Route::post('/status', 'CountryController@status')->name('.status');
                    Route::any('/show_form/{id?}', 'CountryController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'CountryController@add_edit')->name('.add_edit');
                    Route::post('/delete', 'CountryController@delete')->name('.delete');
                });

                Route::prefix('users')->name('users')->middleware('checkPermission:users')->group(function () {
                    Route::get('/', 'UserController@index');
                    Route::any('/list', 'UserController@list')->name('.list');
                    Route::post('/status', 'UserController@status')->name('.status');
                    Route::any('/show_form/{id?}', 'UserController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'UserController@add_edit')->name('.add_edit');
                    Route::post('/delete', 'UserController@delete')->name('.delete');
                    Route::post('/check_unique', 'UserController@check_unique')->name('.check_unique');
                    Route::post('/send_verification_link', 'UserController@send_verification_link')->name('.send_verification_link');
                    Route::post('/import_users', 'UserController@import_users')->name('.import_users');

                    Route::prefix('sessions_requests')->name('.sessions_requests')->group(function () {
                        Route::get('/{id}', 'SessionRequestController@index');
                        Route::any('/list/{id}', 'SessionRequestController@list')->name('.list');
                        Route::post('/delete', 'SessionRequestController@delete')->name('.delete');
                    });

                    Route::prefix('user_dates')->name('.user_dates')->group(function () {
                        Route::get('/{id}', 'UserDateController@index');
                        Route::any('/list/{id}', 'UserDateController@list')->name('.list');
                        Route::post('/status', 'UserDateController@status')->name('.status');
                        Route::any('/show_form/{user_id}/{id?}', 'UserDateController@show_form')->name('.show_form');
                        Route::post('/add_edit', 'UserDateController@add_edit')->name('.add_edit');
                        Route::post('/delete', 'UserDateController@delete')->name('.delete');
                    });
                });

                Route::prefix('phases')->name('phases')->middleware('checkPermission:phases')->group(function () {
                    Route::get('/', 'PhaseController@index');
                    Route::any('/list', 'PhaseController@list')->name('.list');
                    Route::post('/status', 'PhaseController@status')->name('.status');
                    Route::any('/show_form/{id?}', 'PhaseController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'PhaseController@add_edit')->name('.add_edit');
                    Route::post('/delete', 'PhaseController@delete')->name('.delete');
                    Route::post('/reorder', 'PhaseController@reorder')->name('.reorder');
                    Route::post('/duplicate/{id}', 'PhaseController@duplicate')->name('.duplicate');
                });

                Route::prefix('sliders')->name('sliders')->middleware('checkPermission:settings')->group(function () {
                    Route::get('/', 'SliderController@index');
                    Route::any('/list', 'SliderController@list')->name('.list');
                    Route::post('/status', 'SliderController@status')->name('.status');
                    Route::any('/show_form/{id?}', 'SliderController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'SliderController@add_edit')->name('.add_edit');
                    Route::post('/delete', 'SliderController@delete')->name('.delete');
                });

                Route::prefix('courses')->name('courses')->middleware('checkPermission:courses')->group(function () {
                    Route::get('/', 'CourseController@index');
                    Route::any('/list', 'CourseController@list')->name('.list');
                    Route::post('/status', 'CourseController@status')->name('.status');
                    Route::post('/is_available', 'CourseController@is_available')->name('.is_available');
                    Route::any('/show_form/{id?}', 'CourseController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'CourseController@add_edit')->name('.add_edit');
                    Route::post('/delete', 'CourseController@delete')->name('.delete');
                    Route::post('/reorder', 'CourseController@reorder')->name('.reorder');
                    Route::any('/show_duplicate_form/{id?}', 'CourseController@show_duplicate_form')->name('.show_duplicate_form');
                    Route::post('/duplicate/{id}', 'CourseController@duplicate')->name('.duplicate');

                    Route::prefix('lectures')->name('.lectures')->group(function () {
                        Route::get('/{id}', 'LectureController@index');
                        Route::any('/list/{id}', 'LectureController@list')->name('.list');
                        Route::post('/status', 'LectureController@status')->name('.status');
                        Route::any('/show_form/{course_id}/{id?}', 'LectureController@show_form')->name('.show_form');
                        Route::post('/add_edit', 'LectureController@add_edit')->name('.add_edit');
                        Route::post('/delete', 'LectureController@delete')->name('.delete');
                        Route::post('/reorder', 'LectureController@reorder')->name('.reorder');

                        Route::prefix('assignments')->name('.assignments')->group(function () {
                            Route::get('/{id}', 'AssignmentController@index');
                            Route::any('/list/{id}', 'AssignmentController@list')->name('.list');
                            Route::post('/delete', 'AssignmentController@delete')->name('.delete');
                        });

                        Route::prefix('questions')->name('.questions')->group(function () {
                            Route::get('/{id}', 'QuestionController@index');
                            Route::any('/list/{id}', 'QuestionController@list')->name('.list');
                            Route::post('/status', 'QuestionController@status')->name('.status');
                            Route::any('/show_form/{course_id}/{lecture_id}/{id?}', 'QuestionController@show_form')->name('.show_form');
                            Route::post('/add_edit', 'QuestionController@add_edit')->name('.add_edit');
                            Route::post('/delete', 'QuestionController@delete')->name('.delete');
                            Route::post('/reorder', 'QuestionController@reorder')->name('.reorder');
                        });

                        Route::prefix('users_attempts')->name('.users_attempts')->group(function () {
                            Route::get('/{id}', 'UserAttemptController@index');
                            Route::any('/list/{id}', 'UserAttemptController@list')->name('.list');
                            Route::any('/show_form/{course_id}/{lecture_id}/{id}', 'UserAttemptController@show_form')->name('.show_form');
                            Route::post('/delete', 'UserAttemptController@delete')->name('.delete');
                        });
                    });
                });

                Route::prefix('interests')->name('interests')->middleware('checkPermission:settings')->group(function () {
                    Route::get('/', 'InterestController@index');
                    Route::any('/list', 'InterestController@list')->name('.list');
                    Route::post('/status', 'InterestController@status')->name('.status');
                    Route::any('/show_form/{id?}', 'InterestController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'InterestController@add_edit')->name('.add_edit');
                    Route::post('/delete', 'InterestController@delete')->name('.delete');
                });

                Route::prefix('languages')->name('languages')->middleware('checkPermission:settings')->group(function () {
                    Route::get('/', 'LanguageController@index');
                    Route::any('/list', 'LanguageController@list')->name('.list');
                    Route::post('/status', 'LanguageController@status')->name('.status');
                    Route::any('/show_form/{id?}', 'LanguageController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'LanguageController@add_edit')->name('.add_edit');
                    Route::post('/delete', 'LanguageController@delete')->name('.delete');
                });

                Route::prefix('partners')->name('partners')->middleware('checkPermission:settings')->group(function () {
                    Route::get('/', 'PartnerController@index');
                    Route::any('/list', 'PartnerController@list')->name('.list');
                    Route::post('/status', 'PartnerController@status')->name('.status');
                    Route::any('/show_form/{id?}', 'PartnerController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'PartnerController@add_edit')->name('.add_edit');
                    Route::post('/delete', 'PartnerController@delete')->name('.delete');
                });

                Route::prefix('galleries')->name('galleries')->middleware('checkPermission:settings')->group(function () {
                    Route::get('/', 'GalleryController@index');
                    Route::any('/list', 'GalleryController@list')->name('.list');
                    Route::post('/status', 'GalleryController@status')->name('.status');
                    Route::any('/show_form/{id?}', 'GalleryController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'GalleryController@add_edit')->name('.add_edit');
                    Route::post('/delete', 'GalleryController@delete')->name('.delete');
                });

                Route::prefix('settings')->name('settings')->middleware('checkPermission:settings')->group(function () {
                    Route::get('/', 'SettingsController@index');
                    Route::post('/update', 'SettingsController@update')->name('.update');
                });

                Route::prefix('user_grades')->name('user_grades')->middleware('checkPermission:user_grades')->group(function () {
                    Route::get('/', 'UserGradeController@index');
                    Route::any('/list', 'UserGradeController@list')->name('.list');
                    Route::post('/status', 'UserGradeController@status')->name('.status');
                    Route::any('/show_form/{id?}', 'UserGradeController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'UserGradeController@add_edit')->name('.add_edit');
                    Route::post('/delete', 'UserGradeController@delete')->name('.delete');
                });

                Route::prefix('user_assignments')->name('user_assignments')->middleware('checkPermission:user_assignments')->group(function () {
                    Route::get('/', 'UserAssignmentController@index');
                    Route::any('/list', 'UserAssignmentController@list')->name('.list');
                    Route::any('/show_form/{id}', 'UserAssignmentController@show_form')->name('.show_form');
                    Route::post('/add_edit', 'UserAssignmentController@add_edit')->name('.add_edit');
                    Route::get('/download', 'UserAssignmentController@download')->name('.download');
                });

                Route::prefix('users_quizzes')->name('users_quizzes')->middleware('checkPermission:users_quizzes')->group(function () {
                    Route::get('/', 'UserQuizController@index');
                    Route::any('/list', 'UserQuizController@list')->name('.list');
                    Route::any('/show_form/{id}', 'UserQuizController@show_form')->name('.show_form');
                });

                Route::prefix('users_courses')->name('users_courses')->middleware('checkPermission:users_courses')->group(function () {
                    Route::get('/', 'UserCourseController@index');
                    Route::any('/list', 'UserCourseController@list')->name('.list');
                });

                Route::prefix('chats')->name('chats')->middleware('checkPermission:chats')->group(function () {
                    Route::get('/', 'ChatController@index');
                    Route::any('/list', 'ChatController@list')->name('.list');
                    Route::post('/delete', 'ChatController@delete')->name('.delete');
                    Route::post('/clear_messages/{id}', 'ChatController@clear_messages')->name('.clear_messages');
                });
            });
        });
    });
    Route::namespace('App\Http\Controllers\WS')->group(function () {
        Route::get('users/verify/{token}', 'UserController@verify')->name('ws.users.verify');
        Route::post('users/verify', 'UserController@verify_post')->name('ws.users.verify_post');
        Route::get('login', 'UserController@login')->name('ws.login');
        Route::post('login', 'UserController@login_post')->name('ws.login_post');
        Route::get('forget_password', 'UserController@forget_password')->name('ws.forget_password');
        Route::post('forget_password_post', 'UserController@forget_password_post')->name('ws.forget_password_post');
        Route::middleware('UserAuth')->group(function () {
            Route::get('/', 'HomeController@index')->name('ws.home');
            Route::get('/modules', 'HomeController@modules')->name('ws.modules');
            Route::get('/module/{course_id}/{lecture_id?}', 'CourseController@show')->name('ws.course.show');
            Route::post('/module/reviews', 'CourseController@more_reviews')->name('ws.course.more_reviews');
            Route::post('/module/reviews/add', 'CourseController@add_review')->name('ws.course.add_review');
            Route::post('/module/reviews/delete', 'CourseController@delete_review')->name('ws.course.delete_review');
            Route::post('assignment', 'CourseController@assignment')->name('ws.assignment');
            Route::post('complete_lecture', 'CourseController@complete_lecture')->name('ws.complete_lecture');
            Route::get('quiz/{id}', 'CourseController@quiz')->name('ws.quiz');
            Route::post('quiz_attempt', 'CourseController@quiz_attempt')->name('ws.quiz_attempt');

            Route::get('logout', 'UserController@logout')->name('ws.logout');
            Route::get('profile', 'UserController@profile')->name('ws.profile');
            Route::post('profile', 'UserController@profile_post')->name('ws.profile_post');
            Route::get('user/{id}', 'UserController@user_profile')->name('ws.user_profile');
            Route::post('book_session', 'UserController@book_session')->name('ws.book_session');

            Route::get('gallery', 'HomeController@gallery')->name('ws.gallery');
            Route::get('teammates/{interest_id?}', 'HomeController@teammates')->name('ws.teammates');
            Route::get('mentors', 'HomeController@mentors')->name('ws.mentors');
            Route::get('schedule', 'HomeController@schedule')->name('ws.schedule');

            Route::get('messages/start/{id}', 'HomeController@start_chat')->name('ws.start_chat');
            Route::get('messages/{id?}', 'HomeController@messages')->name('ws.messages');
            Route::get('get_messages', 'HomeController@get_messages')->name('ws.messages.get');
            Route::get('show_chat', 'HomeController@show_chat')->name('ws.chat.show');
            Route::post('store_message', 'HomeController@store_message')->name('ws.messages.store');
            Route::post('delete_message', 'HomeController@delete_message')->name('ws.messages.destroy');
        });
    });
});
Route::post('send_curl_mails', 'App\Http\Controllers\EmailController@send_curl_mails')->name('send_curl_mails');
