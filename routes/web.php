<?php

namespace App\Http\Controllers;

use App\Http\Controllers\guest_controller\ProfileGuest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('guest.home');
// });

Route::get('/', 'GuestController@index');
Route::post('guest/category', 'GuestController@courseCategories');

//COURSE GUEST
Route::get('course', 'guest_controller\CourseGuest@index');
Route::get('course/search', 'guest_controller\CourseGuest@SearchCourse');
Route::post('course/category', 'guest_controller\CourseGuest@getFilterByKat');
Route::get('course/info/{any}', 'guest_controller\CourseGuest@infoCourse');
//END COURSE GUEST

//EVENT GUEST
Route::get('event', 'guest_controller\EventGuest@index');
Route::get('event/search', 'guest_controller\EventGuest@searchEvent');
Route::get('event/detail', 'guest_controller\EventGuest@detailEvent');
Route::get('event/detail/{any}', 'guest_controller\EventGuest@detailEvent');
//END EVENT GUEST

Route::get('login', 'AuthController@login');
Route::post('login/authentication', 'AuthController@login_authentication');

Route::get('register', 'AuthController@register');
Route::post('register/store', 'AuthController@store');

Route::get('logout', 'AuthController@logout');

//FORGOT PASS
Route::get('forgot-password', 'AuthController@forgot_password');
Route::post('forgotPassword', 'AuthController@forgot_password_send');
Route::get('reset-password', 'AuthController@forgot_password_reset');
Route::post('resetPassword', 'AuthController@resetPassword');
//END FORGOT PASS

//VERIFICATION ACCOUNT
Route::get('verification/confirm', 'AuthController@verifAccount');

// 1 Admin
Route::middleware(['usersession:4,1'])->group(function () {

    Route::get('ebook', 'EbookController@index');
    Route::post('ebook/store', 'EbookController@store');
    Route::post('ebook/update', 'EbookController@update');
    Route::post('ebook/delete', 'EbookController@delete');

    Route::get('promo', 'PromoController@index');
    Route::post('promo/store', 'PromoController@store');
    Route::post('promo/update', 'PromoController@update');
    Route::post('promo/delete', 'PromoController@delete');

    Route::get('category', 'CategoryController@index');
    Route::post('category/store', 'CategoryController@store');
    Route::post('category/update', 'CategoryController@update');
    Route::post('category/delete', 'CategoryController@delete');

    Route::get('user', 'UserController@index');
    Route::post('user/store', 'UserController@store');
    Route::post('user/update', 'UserController@update');
    Route::post('user/delete', 'UserController@delete');

    Route::get('instructor', 'InstructorController@index');
    Route::post('instructor/accept', 'InstructorController@accept');
    Route::post('instructor/decline', 'InstructorController@decline');
    
    Route::get('setting', 'SettingController@index');
    Route::post('carousel/store', 'SettingController@addCarousel');
    Route::post('carousel/delete', 'SettingController@deleteCarousel');
    Route::post('carousel/edit', 'SettingController@editCarousel');

    Route::get('testimoni', 'SettingController@testimoni_index');
    Route::post('testimoni/store', 'SettingController@addTestimoni');
    Route::post('testimoni/delete', 'SettingController@deleteTestimoni');
    Route::post('testimoni/edit', 'SettingController@editTestimoni');
});

//2 INSTRUKTUR
Route::middleware(['usersession:2'])->group(function () {
    // Route::get('profile','guest_controller\ProfileGuest@index');
});

// 3 USER
Route::middleware(['usersession:4,3,2,1'])->group(function () {
//COURSE
    Route::get('course/detail/{any}', 'guest_controller\CourseGuest@detailCourse');
    Route::post('course/item/mapping', 'guest_controller\CourseGuest@getMappingCourse');
    Route::post('course/item', 'guest_controller\CourseGuest@getDetailItemCourse');
    Route::post('course/quiz/evaluation', 'guest_controller\CourseGuest@QuizEvaluation');
    Route::post('course/add', 'guest_controller\CourseGuest@add_event');
    Route::post('course/detail/addkomen', 'SocialController@addkomen');
//END COURSE

    Route::post('event/add', 'guest_controller\EventGuest@add_event');

// PROFILE
    Route::get('profile', [ProfileGuest::class, 'profile']);
    Route::get('/profile/overview', [ProfileGuest::class, 'overview']);
    Route::get('profile/myebook', [ProfileGuest::class, 'ebook']);
    Route::get('profile/academic', [ProfileGuest::class, 'academic']);
    Route::get('profile/document', [ProfileGuest::class, 'document']);
    Route::get('profile/mycourses', [ProfileGuest::class, 'mycourses']);
    Route::get('profile/myevents', [ProfileGuest::class, 'myevents']);
    Route::post('profile/update', [ProfileGuest::class, 'update_profile']);
    Route::post('/profile/academic/change', [ProfileGuest::class, 'academic_change']);
    Route::post('/profile/document/change', [ProfileGuest::class, 'doc_up']);
    Route::get('apply_instructor', 'InstructorController@apply_instructor');
//END PROFILE
});

Route::middleware(['usersession:4,1'])->group(function () {
    Route::get('dashboard', 'DashboardController@admin_index');

    Route::get('courses', 'CourseController@index');
    Route::get('courses/add', 'CourseController@add_course');
    Route::get('courses/add_materi/{id}', 'CourseController@add_materi');
    Route::get('courses/delete_materi/{id}', 'CourseController@delete_materi');
    Route::get('courses/add_quiz/{id}/{no_quiz}', 'CourseController@add_quiz')->name('add_quiz');
    Route::get('courses/delete_quiz/{id}', 'CourseController@delete_quiz');
    Route::get('courses/add_question/{id}/{index}', 'CourseController@add_question')->name('add_question');
    Route::get('courses/delete_question/{id}', 'CourseController@delete_question');
    Route::post('courses/store', 'CourseController@store');
    Route::post('courses/edit', 'CourseController@update_course'); // open page
    Route::get('courses/get/{id}', 'CourseController@deskripsi_get'); // get desc
    Route::get('courses/get_course_item/{id}/{materi}', 'CourseController@get_course_item'); // get materi / quiz
    Route::post('courses/update', 'CourseController@update'); // update kursus
    Route::post('courses/delete', 'CourseController@delete');
    
    Route::get('courses/invite', 'CourseController@invite');
    Route::post('courses/invite_individu', 'CourseController@invite_individu');
    Route::post('courses/invite_batch', 'CourseController@invite_batch');

    Route::get('events', 'EventController@index');
    Route::get('events/get/{id}', 'EventController@deskripsi_get');
    Route::post('events/add', 'EventController@store');
    Route::post('events/update', 'EventController@update');
    Route::post('events/delete', 'EventController@delete');
    
    Route::post('user/jadikanAdmin', 'DashboardController@jadikanAdmin');
});

//Social Media Routes (Under Progress)
// Route::get('auth/facebook', [SocialController::class, 'redirectToFacebook']);
// Route::get('auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

// Route::get('auth/instagram', [SocialController::class, 'redirectToInstagram']);
// Route::get('auth/instagram/callback', [SocialController::class, 'handleInstagramCallback']);
