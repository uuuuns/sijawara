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

Route::get('/', 'GuestController@index');

//KURSUS GUEST
Route::get('kursus', 'guest_controller\CourseGuest@index');
Route::get('kursus/search', 'guest_controller\CourseGuest@SearchCourse');
Route::get('kursus/category', 'guest_controller\CourseGuest@getFilterByKat');
Route::get('kursus/info/{any}', 'guest_controller\CourseGuest@infoCourse');
//END KURSUS GUEST

//EVENT GUEST
Route::get('webinar', 'guest_controller\EventGuest@index');
Route::get('webinar/search', 'guest_controller\EventGuest@searchEvent');
Route::get('webinar/detail', 'guest_controller\EventGuest@detailEvent');
Route::get('webinar/detail/{any}', 'guest_controller\EventGuest@detailEvent');
//END EVENT GUEST

//KDMP GUEST`
Route::get('kdmp', 'guest_controller\KdmpGuest@index');
Route::get('kdmp/search', 'guest_controller\KdmpGuest@SearchCourse');
Route::get('kdmp/info/{any}', 'guest_controller\KdmpGuest@infoCourse');

//END KDMP GUEST

Route::get('masuk', 'AuthController@login');
Route::post('masuk/authentication', 'AuthController@login_authentication');

Route::get('daftar', 'AuthController@register');
Route::post('register/store', 'AuthController@store');

Route::get('keluar', 'AuthController@logout');

Route::get('ganti_kata_sandi', 'AuthController@gantiSandi');
Route::post('submit_sandi', 'AuthController@submitSandi');

//FORGOT PASS
Route::get('lupa-katasandi', 'AuthController@forgot_password');
Route::post('lupakatasandi', 'AuthController@get_password');
Route::post('gantikatasandi', 'AuthController@change_password');
// Route::post('lupakatasandi', 'AuthController@forgot_password_send');
// Route::get('reset-katasandi', 'AuthController@forgot_password_reset');
// Route::post('resetkatasandi', 'AuthController@resetPassword');
//END FORGOT PASS

//VERIFICATION ACCOUNT
Route::get('verifikasi/confirm', 'AuthController@verifAccount');
//VERIFICATION ACCOUNT
Route::get('verifikasi/{any}', 'guest_controller\SertificateGuest@verifSertif');

Route::get('404', 'GuestController@notfound')->name('notfound');

//SERTIFIKAT
Route::get('sertifikat', 'guest_controller\SertificateGuest@generate');

// 1 Admin
Route::middleware(['usersession:4,1'])->group(function () {
    // Route::get('ebook', 'EbookController@index');
    // Route::post('ebook/store', 'EbookController@store');
    // Route::post('ebook/update', 'EbookController@update');
    // Route::post('ebook/delete', 'EbookController@delete');

    // Route::get('promo', 'PromoController@index');
    // Route::post('promo/store', 'PromoController@store');
    // Route::post('promo/update', 'PromoController@update');
    // Route::post('promo/delete', 'PromoController@delete');

    Route::get('kategori', 'CategoryController@index');
    Route::post('kategori/store', 'CategoryController@store');
    Route::post('kategori/update', 'CategoryController@update');
    Route::post('kategori/delete', 'CategoryController@delete');

    Route::get('pengguna', 'UserController@index');
    Route::post('pengguna/store', 'UserController@store');
    Route::post('pengguna/update', 'UserController@update_profile');
    Route::post('pengguna/delete', 'UserController@delete');
    Route::post('pengguna/jadikanAdmin', 'UserController@jadikanAdmin');
    Route::post('pengguna/batalkanAdmin', 'UserController@batalkanAdmin');
    Route::post('pengguna/jadikanInstruktur', 'UserController@jadikanInstruktur');
    Route::post('pengguna/batalkanInstruktur', 'UserController@batalkanInstruktur');
    Route::get('pengguna/detail_pengambilan', 'UserController@detail_pengambilan');
    Route::get('pengguna/filter_ukm', 'UserController@filter_ukm');
    Route::get('pengguna/filter_koperasi', 'UserController@filter_koperasi');

    Route::get('pengguna/ajax/paper-view', 'UserController@filter_user');

    Route::get('pengguna/reporting/ukm', 'UserController@laporan_ukm');
    Route::get('pengguna/reporting/koperasi', 'UserController@laporan_koperasi');

    Route::get('instruktur', 'InstructorController@index');
    Route::post('instruktur/accept', 'InstructorController@accept');
    Route::post('instruktur/decline', 'InstructorController@decline');
    Route::post('instruktur/delete', 'InstructorController@deleteInstruktur');

    Route::get('pengaturan', 'SettingController@index');
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

    Route::post('user/jadikanAdmin', 'UserController@jadikanAdmin');
    Route::post('user/jadikanInstruktur', 'UserController@jadikanInstruktur');
    Route::get('user/detail_pengambilan', 'UserController@detail_pengambilan');
    
    Route::post('instruktur/delete', 'InstructorController@deleteInstruktur');

    //ranking user
    Route::get('ranking', 'RankingController@index');
    Route::post('ranking/filter_jenis_instansi', 'RankingController@filter_jenis_instansi');
    Route::post('ranking/filter_kategori', 'RankingController@filter_kategori');

    //Aspirasi
    Route::get('aspirasi', 'AspirasiController@index');
});

//2 INSTRUKTUR
Route::middleware(['usersession:2'])->group(function () {
    // Route::get('profile','guest_controller\ProfileGuest@index');
});

// 3 USER
Route::middleware(['usersession:4,3,2,1'])->group(function () {
    //KDMP
    Route::get('kdmp/detail/{any}', 'guest_controller\KdmpGuest@detailCourse');
    Route::post('kdmp/item/mapping', 'guest_controller\KdmpGuest@getMappingCourse');
    Route::post('kdmp/item', 'guest_controller\KdmpGuest@getDetailItemCourse');
    Route::post('kdmp/quiz/evaluation', 'guest_controller\KdmpGuest@QuizEvaluation');
    Route::post('kdmp/add', 'guest_controller\KdmpGuest@add_event');
    Route::post('kdmp/detail/addkomen', 'SocialController@addkomen');

    //COURSE
    Route::get('kursus/detail/{any}', 'guest_controller\CourseGuest@detailCourse');
    Route::post('kursus/item/mapping', 'guest_controller\CourseGuest@getMappingCourse');
    Route::post('kursus/item', 'guest_controller\CourseGuest@getDetailItemCourse');
    Route::post('kursus/quiz/evaluation', 'guest_controller\CourseGuest@QuizEvaluation');
    Route::post('kursus/add', 'guest_controller\CourseGuest@add_event');
    Route::post('kursus/detail/addkomen', 'SocialController@addkomen');

    Route::get('kursus/aspirasi-kursus', 'guest_controller\CourseGuest@AspirasiKursus');
    Route::post('kursus/store_aspirasi', 'guest_controller\CourseGuest@storeAspirasi');
    //END COURSE

    Route::post('webinar/add', 'guest_controller\EventGuest@add_event');
    Route::post('webinar/upload_file', 'guest_controller\EventGuest@upload_file');

    // DATA UKM
    Route::get('data_ukm', 'guest_controller\ProfileGuest@data_ukm_index'); // [ProfileGuest::class, 'data_ukm_index']
    Route::post('data_ukm/store_ukm', 'guest_controller\ProfileGuest@store_data_ukm'); // [ProfileGuest::class, 'store_data_ukm']
    Route::post('data_ukm/store_pemilik', 'guest_controller\ProfileGuest@store_data_pemilik'); // [ProfileGuest::class, 'store_data_pemilik']
    Route::post('data_ukm/store_lain', 'guest_controller\ProfileGuest@store_data_lain'); // [ProfileGuest::class, 'store_data_lain']

    // DATA KOPERASI
    Route::get('data_koperasi', 'guest_controller\ProfileGuest@data_koperasi_index'); // [ProfileGuest::class, 'data_koperasi_index']
    Route::post('data_koperasi/store_data_koperasi', 'guest_controller\ProfileGuest@store_data_koperasi'); // [ProfileGuest::class, 'store_data_koperasi']
    Route::post('data_koperasi/store_hukum_koperasi', 'guest_controller\ProfileGuest@store_hukum_koperasi'); // [ProfileGuest::class, 'store_hukum_koperasi']
    Route::post('data_koperasi/store_anggota_koperasi', 'guest_controller\ProfileGuest@store_anggota_koperasi'); // [ProfileGuest::class, 'store_anggota_koperasi']
    Route::post('data_koperasi/store_masalah_koperasi', 'guest_controller\ProfileGuest@store_masalah_koperasi'); // [ProfileGuest::class, 'store_masalah_koperasi']
    Route::post('get-kota', 'guest_controller\ProfileGuest@get_kota'); // [ProfileGuest::class, 'get_kota']
    Route::post('get-kota-option', 'guest_controller\ProfileGuest@get_kota_option'); // [ProfileGuest::class, 'get_kota_option']

    // PROFILE
    Route::get('profil', 'guest_controller\ProfileGuest@profile'); // [ProfileGuest::class, 'profile']
    Route::get('profil/overview', 'guest_controller\ProfileGuest@overview'); // [ProfileGuest::class, 'overview']
    Route::get('profil/myebook', 'guest_controller\ProfileGuest@ebook'); // [ProfileGuest::class, 'ebook']
    Route::get('profil/academic', 'guest_controller\ProfileGuest@academic'); // [ProfileGuest::class, 'academic']
    Route::get('profil/document', 'guest_controller\ProfileGuest@document'); // [ProfileGuest::class, 'document']
    Route::get('profil/kdmpku', 'guest_controller\ProfileGuest@mykdmp');
    Route::get('profil/kursusku', 'guest_controller\ProfileGuest@mycourses'); // [ProfileGuest::class, 'mycourses
    Route::get('profil/webinarku', 'guest_controller\ProfileGuest@myevents'); // [ProfileGuest::class, 'myevents']
    Route::get('profil/sertifikatku', 'guest_controller\ProfileGuest@mysertificate'); // [ProfileGuest::class, 'mysertificate']
    Route::post('profil/update', 'guest_controller\ProfileGuest@update_profile'); // [ProfileGuest::class, 'update_profile']
    Route::post('profil/academic/change', 'guest_controller\ProfileGuest@academic_change'); //[ProfileGuest::class, 'academic_change']
    Route::post('profil/document/change', 'guest_controller\ProfileGuest@doc_up'); // [ProfileGuest::class, 'doc_up']
    Route::post('profil/cekEmail', 'guest_controller\ProfileGuest@cek_email'); // [ProfileGuest::class, 'cek_email']
    Route::post('update-sertif', 'guest_controller\ProfileGuest@update_sertif'); // [ProfileGuest::class, 'update_sertif']
    Route::get('apply_instructor', 'InstructorController@apply_instructor');
    //END PROFILE
});

Route::middleware(['usersession:4,1,2'])->group(function () {
    Route::get('dashboard', 'DashboardController@admin_index');

    // kursus
    Route::get('kursus-admin', 'CourseController@index');
    Route::get('kursus-admin/add', 'CourseController@add_course');
    Route::get('kursus-admin/add_materi/{id}', 'CourseController@add_materi');
    Route::get('kursus-admin/add_quiz/{id}/{no_quiz}', 'CourseController@add_quiz')->name('add_quiz');
    Route::get('kursus-admin/add_question/{id}/{index}', 'CourseController@add_question')->name('add_question');
    Route::post('kursus-admin/edit', 'CourseController@update_course'); // open page update
    Route::get('kursus-admin/get/{id}', 'CourseController@deskripsi_get'); // get desc
    Route::get('kursus-admin/get_course_item/{id}', 'CourseController@get_course_item'); // get materi / quiz
    Route::post('kursus-admin/get_quiz', 'CourseController@send_question'); //send to another page

    Route::post('kursus-admin/store', 'CourseController@store'); // store kursus
    Route::post('kursus-admin/update', 'CourseController@update'); // update kursus
    Route::post('kursus-admin/delete', 'CourseController@delete'); // delete kursus

    Route::get('kursus-admin/lihat_peserta', 'CourseController@index_lihat_peserta');
    Route::get('kursus-admin/laporan_course', 'CourseController@laporan_course');

    Route::get('kursus-admin/invite', 'CourseController@invite');
    Route::post('kursus-admin/invite_individu', 'CourseController@invite_individu');
    Route::post('kursus-admin/invite_batch', 'CourseController@invite_batch');
    Route::post('kursus-admin/batalkan_undangan', 'CourseController@batalkan_undangan');

    // kdmp
    Route::get('kdmp-admin', 'KdmpController@index');
    Route::get('kdmp-admin/add', 'KdmpController@add_course');
    Route::get('kdmp-admin/add_materi/{id}', 'KdmpController@add_materi');
    Route::get('kdmp-admin/add_quiz/{id}/{no_quiz}', 'KdmpController@add_quiz')->name('add_quiz_kdmp');
    Route::get('kdmp-admin/add_question/{id}/{index}', 'KdmpController@add_question')->name('add_question');
    Route::post('kdmp-admin/edit', 'KdmpController@update_course'); // open page update
    Route::get('kdmp-admin/get/{id}', 'KdmpController@deskripsi_get'); // get desc
    Route::get('kdmp-admin/get_course_item/{id}', 'KdmpController@get_course_item'); // get materi / quiz
    Route::post('kdmp-admin/get_quiz', 'KdmpController@send_question'); //send to another page

    Route::post('kdmp-admin/store', 'KdmpController@store'); // store kursus
    Route::post('kdmp-admin/update', 'KdmpController@update'); // update kursus
    Route::post('kdmp-admin/delete', 'KdmpController@delete'); // delete kursus

    Route::get('kdmp-admin/lihat_peserta', 'KdmpController@index_lihat_peserta');
    Route::get('kdmp-admin/laporan_course', 'KdmpController@laporan_course');

    Route::get('kdmp-admin/invite', 'KdmpController@invite');
    Route::post('kdmp-admin/invite_individu', 'KdmpController@invite_individu');
    Route::post('kdmp-admin/invite_batch', 'KdmpController@invite_batch');
    Route::post('kdmp-admin/batalkan_undangan', 'KdmpController@batalkan_undangan');

    // webinar
    Route::get('webinar-admin', 'EventController@index');
    Route::get('webinar-admin/get/{id}', 'EventController@deskripsi_get');
    Route::post('webinar-admin/add', 'EventController@store');
    Route::post('webinar-admin/update', 'EventController@update');
    Route::post('webinar-admin/delete', 'EventController@delete');
    Route::get('webinar-admin/lihat_peserta', 'EventController@index_lihat_peserta');
    Route::get('webinar-admin/laporan_event', 'EventController@laporan_event');
});

//Social Media Routes (Under Progress)
// Route::get('auth/facebook', [SocialController::class, 'redirectToFacebook']);
// Route::get('auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

// Route::get('auth/instagram', [SocialController::class, 'redirectToInstagram']);
// Route::get('auth/instagram/callback', [SocialController::class, 'handleInstagramCallback']);