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

    //route badan usaha
    Route::get('ukm/badan_usaha', 'ukm_controller\BadanUsahaController@index');
    Route::post('ukm/badan_usaha/add', 'ukm_controller\BadanUsahaController@store');
    Route::post('ukm/badan_usaha/update', 'ukm_controller\BadanUsahaController@update');
    Route::post('ukm/badan_usaha/delete', 'ukm_controller\BadanUsahaController@delete');

    //route jabatan ukm
    Route::get('ukm/jabatan_ukm', 'ukm_controller\JabatanUkmController@index');
    Route::post('ukm/jabatan_ukm/add', 'ukm_controller\JabatanUkmController@store');
    Route::post('ukm/jabatan_ukm/update', 'ukm_controller\JabatanUkmController@update');
    Route::post('ukm/jabatan_ukm/delete', 'ukm_controller\JabatanUkmController@delete');

    //route kategori ukm
    Route::get('ukm/kategori_ukm', 'ukm_controller\KategoriUkmController@index');
    Route::post('ukm/kategori_ukm/add', 'ukm_controller\KategoriUkmController@store');
    Route::post('ukm/kategori_ukm/update', 'ukm_controller\KategoriUkmController@update');
    Route::post('ukm/kategori_ukm/delete', 'ukm_controller\KategoriUkmController@delete');

    //route sumber bahanbaku
    Route::get('ukm/sumber_bahanbaku', 'ukm_controller\SumberBahanBakuController@index');
    Route::post('ukm/sumber_bahanbaku/add', 'ukm_controller\SumberBahanBakuController@store');
    Route::post('ukm/sumber_bahanbaku/update', 'ukm_controller\SumberBahanBakuController@update');
    Route::post('ukm/sumber_bahanbaku/delete', 'ukm_controller\SumberBahanBakuController@delete');

    //route legalitas usaha
    Route::get('ukm/legalitas_usaha', 'ukm_controller\LegalitasUsahaController@index');
    Route::post('ukm/legalitas_usaha/add', 'ukm_controller\LegalitasUsahaController@store');
    Route::post('ukm/legalitas_usaha/update', 'ukm_controller\LegalitasUsahaController@update');
    Route::post('ukm/legalitas_usaha/delete', 'ukm_controller\LegalitasUsahaController@delete');

    //route standar produk
    Route::get('ukm/standar_produk', 'ukm_controller\StandarProdukController@index');
    Route::post('ukm/standar_produk/add', 'ukm_controller\StandarProdukController@store');
    Route::post('ukm/standar_produk/update', 'ukm_controller\StandarProdukController@update');
    Route::post('ukm/standar_produk/delete', 'ukm_controller\StandarProdukController@delete');

    //route wilayah pemasaran
    Route::get('ukm/wilayah_pemasaran', 'ukm_controller\WilayahPemasaranController@index');
    Route::post('ukm/wilayah_pemasaran/add', 'ukm_controller\WilayahPemasaranController@store');
    Route::post('ukm/wilayah_pemasaran/update', 'ukm_controller\WilayahPemasaranController@update');
    Route::post('ukm/wilayah_pemasaran/delete', 'ukm_controller\WilayahPemasaranController@delete');

    //route fasilitas Kegiatan
    Route::get('ukm/fasilitas_kegiatan', 'ukm_controller\FasilitasKegiatanController@index');
    Route::post('ukm/fasilitas_kegiatan/add', 'ukm_controller\FasilitasKegiatanController@store');
    Route::post('ukm/fasilitas_kegiatan/update', 'ukm_controller\FasilitasKegiatanController@update');
    Route::post('ukm/fasilitas_kegiatan/delete', 'ukm_controller\FasilitasKegiatanController@delete');

    //route masalah ukm
    Route::get('ukm/masalah_ukm', 'ukm_controller\MasalahUkmController@index');
    Route::post('ukm/masalah_ukm/add', 'ukm_controller\MasalahUkmController@store');
    Route::post('ukm/masalah_ukm/update', 'ukm_controller\MasalahUkmController@update');
    Route::post('ukm/masalah_ukm/delete', 'ukm_controller\MasalahUkmController@delete');

    // Koperasi Controller
    Route::get('bentuk', 'KoperasiController@index_bentuk');
    Route::post('bentuk/store', 'KoperasiController@store_bentuk');
    Route::post('bentuk/update', 'KoperasiController@update_bentuk');
    Route::post('bentuk/delete', 'KoperasiController@delete_bentuk');

    Route::get('jenis', 'KoperasiController@index_jenis');
    Route::post('jenis/store', 'KoperasiController@store_jenis');
    Route::post('jenis/update', 'KoperasiController@update_jenis');
    Route::post('jenis/delete', 'KoperasiController@delete_jenis');

    Route::get('kelompok', 'KoperasiController@index_kelompok');
    Route::post('kelompok/store', 'KoperasiController@store_kelompok');
    Route::post('kelompok/update', 'KoperasiController@update_kelompok');
    Route::post('kelompok/delete', 'KoperasiController@delete_kelompok');

    Route::get('masalah', 'KoperasiController@index_masalah');
    Route::post('masalah/store', 'KoperasiController@store_masalah');
    Route::post('masalah/update', 'KoperasiController@update_masalah');
    Route::post('masalah/delete', 'KoperasiController@delete_masalah');

    Route::get('sektor', 'KoperasiController@index_sektor');
    Route::post('sektor/store', 'KoperasiController@store_sektor');
    Route::post('sektor/update', 'KoperasiController@update_sektor');
    Route::post('sektor/delete', 'KoperasiController@delete_sektor');

    // Widyaiswara Controller
    Route::get('widyaiswara', 'WidyaiswaraController@index_widyaiswara');
    Route::post('widyaiswara/store', 'WidyaiswaraController@store_widyaiswara');
    Route::post('widyaiswara/update', 'WidyaiswaraController@update_widyaiswara');
    Route::post('widyaiswara/delete', 'WidyaiswaraController@delete_widyaiswara');
    
    Route::get('statistik-peserta', 'DashboardController@statistik_index');
    Route::get('statistik-kategori', 'DashboardController@statistik_kategori_index');
    Route::get('get-data-chart', 'DashboardController@get_data_chart');
    Route::get('get-data-chart-kategori', 'DashboardController@get_data_chart_kategori');
    Route::get('statistik_per_kategori', 'DashboardController@statistik_per_kategori');
    Route::post('statistik_per_provinsi', 'DashboardController@statistik_per_provinsi');
    Route::post('statistik_per_kota', 'DashboardController@statistik_per_kota');

    Route::post('user/jadikanAdmin', 'DashboardController@jadikanAdmin');
    Route::post('user/jadikanInstruktur', 'DashboardController@jadikanInstruktur');
    Route::get('user/detail_pengambilan', 'UserController@detail_pengambilan');
    
    Route::post('instruktur/delete', 'InstructorController@deleteInstruktur');
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
    Route::post('event/upload_file', 'guest_controller\EventGuest@upload_file');
    

    // PROFILE
    Route::get('profile', [ProfileGuest::class, 'profile']);
    Route::get('data_ukm', [ProfileGuest::class, 'data_ukm_index']);
    Route::post('data_ukm/store_ukm', [ProfileGuest::class, 'store_data_ukm']);
    Route::post('data_ukm/store_pemilik', [ProfileGuest::class, 'store_data_pemilik']);
    Route::post('data_ukm/store_lain', [ProfileGuest::class, 'store_data_lain']);
    Route::get('data_koperasi', [ProfileGuest::class, 'data_koperasi_index']);
    Route::post('data_koperasi/store_data_koperasi', [ProfileGuest::class, 'store_data_koperasi']);
    Route::post('data_koperasi/store_hukum_koperasi', [ProfileGuest::class, 'store_hukum_koperasi']);
    Route::post('data_koperasi/store_anggota_koperasi', [ProfileGuest::class, 'store_anggota_koperasi']);
    Route::post('data_koperasi/store_masalah_koperasi', [ProfileGuest::class, 'store_masalah_koperasi']);
    Route::post('get-kota', [ProfileGuest::class, 'get_kota']);
    Route::post('get-kota-option', [ProfileGuest::class, 'get_kota_option']);
    Route::get('/profile/overview', [ProfileGuest::class, 'overview']);
    Route::get('profile/myebook', [ProfileGuest::class, 'ebook']);
    Route::get('profile/academic', [ProfileGuest::class, 'academic']);
    Route::get('profile/document', [ProfileGuest::class, 'document']);
    Route::get('profile/mycourses', [ProfileGuest::class, 'mycourses']);
    Route::get('profile/myevents', [ProfileGuest::class, 'myevents']);
    Route::get('profile/mysertificate', [ProfileGuest::class, 'mysertificate']);
    Route::post('profile/update', [ProfileGuest::class, 'update_profile']);
    Route::post('/profile/academic/change', [ProfileGuest::class, 'academic_change']);
    Route::post('/profile/document/change', [ProfileGuest::class, 'doc_up']);
    Route::post('profile/cekEmail', [ProfileGuest::class, 'cek_email']);
    Route::post('/update-sertif', [ProfileGuest::class, 'update_sertif']);
    Route::get('apply_instructor', 'InstructorController@apply_instructor');
    //END PROFILE
});

Route::middleware(['usersession:4,1,2'])->group(function () {
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
    Route::post('courses/edit', 'CourseController@update_course'); // open page update
    Route::get('courses/get/{id}', 'CourseController@deskripsi_get'); // get desc
    Route::get('courses/get_course_item/{id}', 'CourseController@get_course_item'); // get materi / quiz
    Route::post('courses/get_quiz', 'CourseController@send_question'); //send to another page
    Route::post('courses/update', 'CourseController@update'); // update kursus
    Route::post('courses/delete', 'CourseController@delete');
    Route::get('courses/lihat_peserta', 'CourseController@index_lihat_peserta');
    Route::get('courses/laporan_course', 'CourseController@laporan_course');

    Route::get('courses/invite', 'CourseController@invite');
    Route::post('courses/invite_individu', 'CourseController@invite_individu');
    Route::post('courses/invite_batch', 'CourseController@invite_batch');
    Route::post('courses/batalkan_undangan', 'CourseController@batalkan_undangan');

    Route::get('events', 'EventController@index');
    Route::get('events/get/{id}', 'EventController@deskripsi_get');
    Route::post('events/add', 'EventController@store');
    Route::post('events/update', 'EventController@update');
    Route::post('events/delete', 'EventController@delete');
    Route::get('events/lihat_peserta', 'EventController@index_lihat_peserta');
    Route::get('events/laporan_event', 'EventController@laporan_event');
});

//Social Media Routes (Under Progress)
// Route::get('auth/facebook', [SocialController::class, 'redirectToFacebook']);
// Route::get('auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

// Route::get('auth/instagram', [SocialController::class, 'redirectToInstagram']);
// Route::get('auth/instagram/callback', [SocialController::class, 'handleInstagramCallback']);
