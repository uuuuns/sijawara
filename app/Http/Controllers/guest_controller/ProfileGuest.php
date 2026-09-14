<?php

namespace App\Http\Controllers\guest_controller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Mail\MailSender;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProfileGuest extends Controller
{
    protected $user;

    public function __construct(User $genericModel)
    {
        $this->genericModel = $genericModel;

        $smtpConfig = [
            'transport' => env('MAIL_MAILER'),
            'host' => env('MAIL_HOST'),
            'port' => env('MAIL_PORT'),
            'from' => ['address' => 'sijawara.uptkukm@gmail.com', 'name' => 'SIJAWARA+'],
            'encryption' => env('MAIL_ENCRYPTION'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
        ];
        config(['mail.mailers.smtp' => $smtpConfig]);
    }

    public function profile()
    {
        $data['title'] = "Personal Data";
        $user = new User();

        $data['data_personal'] = DB::selectOne("
            SELECT
                u.*
            FROM
                user u
            WHERE 
            u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';

        ");

        $data['provinsi'] = DB::select('
            SELECT
                *
            FROM
                md_provinsi
        ');
        return
            view('template.header', $data) .
            view('template_guest/profile/personal', $data) .
            view('template.footer', $data);
    }
    public function ebook()
    {
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';

        ");
        $data['data_personal'] = DB::selectOne("
            SELECT
                u.*
            FROM
                user u
            WHERE 
                u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");
        $data['title'] = "My Ebook";
        return
            view('template.header', $data) .
            view('template_guest/profile/myebook', $data) .
            view('template.footer', $data);
    }
    public function academic()
    {
        $data['title'] = "Academic Data";
        $data['academic'] = DB::selectOne("
            SELECT
                u.*
            FROM
                user_data u
            WHERE 
            u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");
        $data['data_personal'] = DB::selectOne("
            SELECT
                u.*
            FROM
                user u
            WHERE 
                u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';

        ");

        return
            view('template.header', $data) .
            view('template_guest/profile/academic', $data) .
            view('template.footer', $data);
    }
    public function document()
    {
        $data['title'] = "Supporting Documents";
        $data['document'] = DB::selectOne("
            SELECT
                user_data.*, 
                instructor_req.STATUS
            FROM
                user_data
            LEFT JOIN instructor_req ON
                instructor_req.ID_USER = user_data.ID_USER
            WHERE
                user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';

        ");

        return
            view('template.header', $data) .
            view('template_guest/profile/document', $data) .
            view('template.footer', $data);
    }
    public function overview()
    {
        $data['title'] = "Supporting Documents";
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';

        ");
        $data['data_personal'] = DB::selectOne("
            SELECT
                u.*
            FROM
                user u
            WHERE 
                u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");
        return
            view('template.header', $data) .
            view('template_guest/profile/overview', $data) .
            view('template.footer', $data);
    }
    public function myevents()
    {
        $data['title'] = "Webinar & PelatihanKu";
        $data['data_personal'] = DB::selectOne("
        SELECT
            u.*
        FROM
            user u
        WHERE 
        u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
    ");
        $user = new User();
        $data['event'] = [];
        $mycourse = $user->get_my_product2();
        foreach ($mycourse as $item) {
            if ($item->DATA_CHECKING == 1) {
                array_push($data['event'], $item);
            }
        }
        $data['document'] = DB::selectOne("
            SELECT 
                user_data.*, instructor_req.STATUS
            FROM 
                user_data
            LEFT JOIN instructor_req ON 
                instructor_req.ID_USER = user_data.ID_USER
            WHERE 
                user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';

        ");

        return
            view('template.header', $data) .
            view('template_guest/profile/myevents', $data) .
            view('template.footer', $data);
    }

    public function mykdmp()
    {
        $data['title'] = "Kursus KDMP Ku";
        $data['data_personal'] = DB::selectOne("
        SELECT
            u.*
        FROM
            user u
        WHERE 
        u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
    ");
        $user = new User();
        $data['course'] = [];
        $mycourse = $user->get_my_product3();
        foreach ($mycourse as $item) {
            array_push($data['course'], $item);
        }
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';
        ");
        return
            view('template.header', $data) .
            view('template_guest/profile/mykdmp', $data) .
            view('template.footer', $data);
    }

    public function mycourses()
    {
        $data['title'] = "Kursus Ku";
        $data['data_personal'] = DB::selectOne("
        SELECT
            u.*
        FROM
            user u
        WHERE 
        u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
    ");
        $user = new User();
        $data['course'] = [];
        $mycourse = $user->get_my_product();
        foreach ($mycourse as $item) {
            array_push($data['course'], $item);
        }
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';
        ");
        return
            view('template.header', $data) .
            view('template_guest/profile/mycourses', $data) .
            view('template.footer', $data);
    }
    public function mysertificate()
    {
        $data['title'] = "Sertifikat Ku";

        $data['sertif'] = DB::select("
            SELECT 
                s.FILE_SERTIFIKAT,
                a.TITLE_ACTIVITY,
                a.TYPE_ACTIVITY
            FROM 
                sertifikat_activity s
            LEFT JOIN activity a ON 
                a.ID_ACTIVITY = s.ID_ACTIVITY
            WHERE 
                s.ID_USER = '" . session('user')[0]['ID_USER'] . "'
                AND s.IS_DOWNLOADED = 1   
            ");

        $data['data_personal'] = DB::selectOne("
            SELECT
                u.*
            FROM
                user u
            WHERE 
            u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");

        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';
        ");
        return
            view('template.header', $data) .
            view('template_guest/profile/mysertificate', $data) .
            view('template.footer', $data);
    }
    public function update_profile(request $request)
    {
        $data = array(
            [
                'EMAIL' => $request->input('email'),
                'NAME' => $request->input('name_user'),
                'TELP' => $request->input('no_hp'),
                'JK' => $request->input('jk'),
                'ALAMAT' => $request->input('alamat'),
                'NIK' => $request->input('nik'),
                'TGL_LAHIR' => $request->input('tgl_lahir'),
                'TEMPAT_LAHIR' => $request->input('tempat_lahir'),
                'NAMA_INSTANSI' => $request->input('nama_instansi'),
                'JABATAN' => $request->input('jabatan'),
                'JENIS_INSTANSI' => $request->input('jenis_instansi'),
                'ID_PROVINSI' => $request->input('provinsi'),
                'ID_KOTA' => $request->input('kota'),
            ]
        );
        $data[0]['FOTO_PROFILE'] = null;
        if (!empty($request->file('foto_profile'))) {
            $data[0]['FOTO_PROFILE'] = FileUpload::S3($request->file('foto_profile'), 'FOTO_PROFILE', 'Foto-Profile-' . strtotime(now()));
        }
        $updateStatus = User::update_profile($data);
        if ($updateStatus) {
            $mappingInstansi = [
                'KOPERASI' => 'koperasi',
                'UKM' => 'ukm',
                'INSTANSI' => 'instansi',
                'KOPERASI;UKM' => 'koperasi_ukm',
                'UKM;KOPERASI' => 'koperasi_ukm',
                'UMUM' => 'umum',
                'KDMP' => 'kdmp'
            ];

            $joinCond = '';
            if ($mappingInstansi[$request->input('jenis_instansi')] == 'ukm') {
                $joinCond = 'LEFT JOIN tb_ukm tu ON tu.ID_USER = u.ID_USER';
            } else if ($mappingInstansi[$request->input('jenis_instansi')] == 'koperasi') {
                $joinCond = 'LEFT JOIN tb_koperasi tk ON tk.ID_USER = u.ID_USER';
            } else if ($mappingInstansi[$request->input('jenis_instansi')] == 'instansi_ukm') {
                $joinCond = 'LEFT JOIN tb_koperasi tk ON tk.ID_USER = u.ID_USER
                            LEFT JOIN tb_ukm tk ON tu.ID_USER = u.ID_USER';
            }

            // Query the database
            $data2 = DB::selectOne('
                SELECT 
                    *
                FROM 
                    `user` u
                ' . $joinCond . '
                WHERE 
                    u.ID_USER = ?
            ', [session('user')[0]['ID_USER']]);

            $is_data_complete = true;
            if ($data2) {
                foreach ($data2 as $key => $value) {
                    if (is_null($value) || $value === '') {
                        $is_data_complete = false;
                    }
                }
            }

            $user_data = collect([
                'EMAIL' => $request->input('email'),
                'NAME' => $request->input('name_user'),
                'JENIS_INSTANSI' => session('user')[0]['JENIS_INSTANSI'] ?? 'UMUM',
                'ID_USER' => session('user')[0]['ID_USER'],
                'FOTO_PROFILE' => !empty($data[0]['FOTO_PROFILE']) ? $data[0]['FOTO_PROFILE'] : (session('user')[0]['FOTO_PROFILE'] ?? null),
                'ID_ROLE' => session('user')[0]['ID_ROLE'] ?? 3,
                'IS_DATA_COMPLETE' => $is_data_complete,
                'LOGGED_IN' => TRUE
            ]);

            // Sync updated profile to SSO server (best-effort)
            $ssoToken = session('sso_token');
            try {
                $ssoService = new \App\Services\SsoService();
                $ssoProfileData = [
                    'name' => $request->input('name_user'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('no_hp'),
                    'nik' => $request->input('nik'),
                ];
                if (!empty($data[0]['FOTO_PROFILE'])) {
                    $ssoProfileData['photo'] = $data[0]['FOTO_PROFILE'];
                }

                if ($ssoToken) {
                    $ssoService->updateProfile($ssoToken, $ssoProfileData);
                } elseif (!empty($request->input('email'))) {
                    $ssoService->updateUser($request->input('email'), $ssoProfileData);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Failed to sync profile update to SSO: ' . $e->getMessage());
            }

            // Replace user in session while keeping sso_token and sso_user intact
            Session::forget('user');
            Session::put('user', [$user_data]);
        }
        return redirect('/profil');
    }
    public function academic_change(request $request)
    {
        $userId = session('user')[0]['ID_USER'];
        $data = [
            'ID_USER' => $userId,
            'UNIV' => $request->input('univ'),
            'NIM' => $request->input('nim'),
            'STUDY' => $request->input('study'),
            'DEGREE' => $request->input('degree'),
            'SEMESTER' => empty($request->input('sem')) ? 0 : $request->input('sem'),
            'IS_GRADUATED' => empty($request->input('sem')) ? 1 : 0
        ];
        $user = DB::table('user_data')->where('ID_USER', $userId)->first();
        if ($user) {
            $updated = DB::table('user_data')->where('ID_USER', $userId)->update($data);
        } else {
            $updated = DB::table('user_data')->insert($data);
        }
        // $updateStatus = User::updateTableById($data);
        return redirect('/profile/academic');
    }
    public function doc_up(request $request)
    {
        $userId = session('user')[0]['ID_USER'];
        $data = [];

        if (!empty($request->file('file_cv'))) {
            $data['CV'] = FileUpload::S3_PDF($request->file('file_cv'), 'Instructor_CV', 'Curriculum-Vitae-' . strtotime(now()));
        }
        if (!empty($request->file('file_porto'))) {
            $data['PORTOFOLIO'] = FileUpload::S3_PDF($request->file('file_porto'), 'Instructor_PORTOFOLIO', 'Portfolio-' . strtotime(now()));
        }
        if (!empty($request->file('file_cert'))) { // Remove the [] from 'file_cert'
            $data['SERTIFIKAT'] = FileUpload::S3_PDF($request->file('file_cert'), 'Instructor_CERT', 'Certificates-' . strtotime(now()));
        }
        if (!empty($request->file('file_recom'))) {
            $data['SURAT_RECOM'] = FileUpload::S3_PDF($request->file('file_recom'), 'Instructor_RECOM', 'Recommendation-Letter-' . strtotime(now()));
        }
        $user = DB::table('user_data')->where('ID_USER', $userId)->first();
        $updated = DB::table('user_data')->updateOrInsert(['ID_USER' => $userId], $data);
        // $updateStatus = User::updateTableById($data);
        return redirect('/profile/document');
    }
    public function update_sertif(request $request)
    {
        $data_update = [
            'IS_DOWNLOADED' => 1
        ];
        $data['user'] = DB::selectOne('
            SELECT
                NAME,
                EMAIL,
                TELP,
                JK,
                FOTO_PROFILE,
                NIK,
                ALAMAT,
                TGL_LAHIR,
                TEMPAT_LAHIR,
                NAMA_INSTANSI,
                JABATAN,
                JENIS_INSTANSI,
                STATUS,
                ID_KOTA,
                ID_PROVINSI
            FROM
                user
            WHERE
                ID_USER = "' . session('user')[0]['ID_USER'] . '"
        ');

        $emptyFields = [];

        if ($data['user']) {
            foreach ((array) $data['user'] as $field => $value) {
                if (is_null($value) || $value === '') {
                    $emptyFields[] = $field;
                }
            }
        }

        if (count($emptyFields) > 0) {
            return response()->json(['status' => 'error', 'message' => 'Lengkapi data profil anda terlebih dahulu', 'code' => 1, 'emptyFields' => $emptyFields]);
        }

        // if (session('user')[0]['IS_DATA_COMPLETE'] == false) {
        //     return response()->json(['status' => 'error', 'message' => 'Lengkapi data profil dan Nama Instansi Anda!!', 'code' => 1]);
        // }

        DB::table('sertifikat_activity')->where('ID_ACTIVITY', $request->id_activity)->where('ID_USER', session('user')[0]['ID_USER'])->update($data_update);

        // SEND EMAIL SUCCESS DOWNLOAD SERTIFIKAT
        $data['activity'] = DB::selectOne('
            SELECT
                *
            FROM
                activity
            WHERE
                ID_ACTIVITY = "' . $request->id_activity . '"
        ');

        $details = [
            'name'  => $data['user']->NAME,
            'title' => 'Selamat ' . $data['user']->NAME . ', Anda telah berhasil mengunduh sertifikat',
            'body'  => 'Sertifikat dari ' . $data['activity']->TYPE_ACTIVITY == 1 ? 'Webinar' : 'Kursus' . ' Dengan Judul ' . $data['activity']->TITLE_ACTIVITY . ', Sertifikat yang telah diunduh dapat dilihat di halaman profil anda dibagian SertifikatKu',
        ];
        $mail = new MailSender($details);
        $mail->subject("Sukses Download Sertifikat");
        Mail::to($data['user']->EMAIL)->send($mail);
        // END  SUCCESS DOWNLOAD SERTIFIKAT

        return response()->json(['status' => 'success']);
    }
    public function cekDataProfil($id_user, $instansi)
    {
        $mappingInstansi = [
            'KOPERASI' => 'koperasi',
            'UKM' => 'ukm',
            'INSTANSI' => 'instansi',
            'INSTANSI; UKM' => 'instansi_ukm',
            'UKM; INSTANSI' => 'instansi_ukm',
            'UMUM' => 'umum'
        ];

        $joinCond = '';
        if ($mappingInstansi[$instansi] === 'ukm') {
            $joinCond = 'LEFT JOIN tb_ukm tu ON tu.ID_USER = u.ID_USER';
        } else if ($mappingInstansi[$instansi] === 'koperasi') {
            $joinCond = 'LEFT JOIN tb_koperasi tk ON tk.ID_USER = u.ID_USER';
        } else if ($mappingInstansi[$instansi] === 'instansi_ukm') {
            $joinCond = 'LEFT JOIN tb_koperasi tk ON tk.ID_USER = u.ID_USER
                        LEFT JOIN tb_ukm tk ON tu.ID_USER = u.ID_USER';
        }

        // Query the database
        $data = DB::selectOne('
            SELECT 
                *
            FROM 
                `user` u
            ' . $joinCond . '
            WHERE 
                u.ID_USER = ?
        ', [$id_user]);

        if ($data) {
            foreach ($data as $key => $value) {
                if (is_null($value) || $value === '') {
                    if ($data->JENIS_INSTANSI === 'UKM') {
                        return "Lengkapi data profil dan data " . $data->JENIS_INSTANSI . " anda terlebih dahulu";
                    } else if ($data->JENIS_INSTANSI === 'KOPERASI') {
                        return "Lengkapi data profil dan data " . $data->JENIS_INSTANSI . " anda terlebih dahulu";
                    } else if ($data->JENIS_INSTANSI === 'INSTANSI; UKM' || $data->JENIS_INSTANSI === 'UKM; INSTANSI') {
                        return "Lengkapi data profil dan data ukm serta koperasi anda terlebih dahulu";
                    } else {
                        return "Lengkapi data profil anda terlebih dahulu";
                    }
                }
            }
        }

        return null;
    }
    public function data_ukm_index()
    {
        $data['title'] = "Data UKM";

        $data['data_personal'] = DB::selectOne("
            SELECT
                u.*
            FROM
                user u
            WHERE 
            u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");

        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';
        ");

        $data['data_ukm'] = DB::selectOne('
            SELECT
                *
            FROM
                tb_ukm
            WHERE ID_USER = "' . session('user')[0]['ID_USER'] . '"
        ');

        if ($data['data_ukm'] == null) {
            $data_ukm = [
                'ID_USER' => session('user')[0]['ID_USER'],
                'uuid' => Str::uuid(),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            DB::table('tb_ukm')->insert($data_ukm);

            $data['data_ukm'] = DB::selectOne('
                SELECT
                    *
                FROM
                    tb_ukm
                WHERE ID_USER = "' . session('user')[0]['ID_USER'] . '"
            ');
        }

        $data['check'] = DB::selectOne("
            SELECT 
                (
                    SUM(CASE WHEN tu.nama_pemilik IS NOT NULL AND tu.nama_pemilik != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.nik_pemilik IS NOT NULL AND tu.nik_pemilik != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.phone_pemilik IS NOT NULL AND tu.phone_pemilik != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.jenis_kelamin_pemilik IS NOT NULL AND tu.jenis_kelamin_pemilik != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.tempat_lahir_pemilik IS NOT NULL AND tu.tempat_lahir_pemilik != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.tanggal_lahir_pemilik IS NOT NULL AND tu.tanggal_lahir_pemilik != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.pendidikan_terakhir_pemilik IS NOT NULL AND tu.pendidikan_terakhir_pemilik != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.alamat_pemilik IS NOT NULL AND tu.alamat_pemilik != '' THEN 1 ELSE 0 END)
                ) AS COUNT_DATA_PEMILIK,
                (
                    SUM(CASE WHEN tu.nama_ukm IS NOT NULL AND tu.nama_ukm != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.alamat_ukm IS NOT NULL AND tu.alamat_ukm != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.id_provinsi IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.id_kota IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.kegiatan_usaha IS NOT NULL AND tu.kegiatan_usaha != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.produk_dihasilkan IS NOT NULL AND tu.produk_dihasilkan != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.id_kategori_ukm IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.tahun_mulai IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.kapasitas_produksi IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.volume_usaha IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.tenaga_pria IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.tenaga_wanita IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.id_badan_usaha IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.npwp IS NOT NULL AND tu.npwp != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.lokasi_pemasaran IS NOT NULL AND tu.lokasi_pemasaran != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.nilai_realisasi IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tu.tahun_realisasi IS NOT NULL THEN 1 ELSE 0 END)
                ) AS COUNT_DATA_UKM
            FROM 
                tb_ukm tu
            WHERE 
                ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");

        $masterDataTables = [
            'provinsi' => 'md_provinsi',
            'kategori_ukm' => 'md_kategori_ukm',
            'fasilitas' => 'md_fasilitas_kegiatan',
            'legalitas' => 'md_legalitas_usaha',
            'permasalahan' => 'md_masalah_ukm',
            'standart' => 'md_standar_produk',
            'sumber' => 'md_sumber_bahanbaku',
            'pemasaran' => 'md_wilayah_pemasaran',
            'badan_usaha' => 'md_badan_usaha'
        ];

        foreach ($masterDataTables as $key => $table) {
            $data[$key] = DB::table($table)->get()->toArray();
        }

        $dataForUpdate = [
            'tb_bahan_baku_ukm' => 'tb_bahan_baku_ukm',
            'tb_fasilitas_ukm' => 'tb_fasilitas_ukm',
            'tb_legalitas_ukm' => 'tb_legalitas_ukm',
            'tb_permasalahan_ukm' => 'tb_permasalahan_ukm',
            'tb_standart_ukm' => 'tb_standart_ukm',
            'tb_pemasaran_ukm' => 'tb_pemasaran_ukm',
        ];

        foreach ($dataForUpdate as $key => $table) {
            $data[$key] = DB::table($table)->where('id_ukm', $data['data_ukm']->id_ukm)->get()->toArray();
        }

        return
            view('template.header', $data) .
            view('template_guest.profile.data_ukm', $data) .
            view('template.footer', $data);
    }
    public function store_data_ukm(Request $request)
    {
        try {
            $data = [
                'nama_ukm' => $request->input('namaUKM'),
                'kegiatan_usaha' => $request->input('kegiatanUsaha'),
                'produk_dihasilkan' => $request->input('produkUKM'),
                'id_kategori_ukm' => $request->input('kategoriProduk'),
                'tahun_mulai' => $request->input('tahunMemulai'),
                'kapasitas_produksi' => str_replace('.', '', $request->input('kapasitasProduksi')),
                'volume_usaha' => str_replace('.', '', $request->input('volumePerbulan')),
                'tenaga_pria' => $request->input('tenagaLaki'),
                'tenaga_wanita' => $request->input('tenagaPerempuan'),
                'id_badan_usaha' => $request->input('bentukUsaha'),
                'npwp' => $request->input('npwp'),
                'lokasi_pemasaran' => $request->input('lokasiPemasaran'),
                'nilai_realisasi' => str_replace('.', '', $request->input('nilaiRealisasi')),
                'tahun_realisasi' => $request->input('tahunRealisasi'),
                'alamat_ukm' => $request->input('alamatUsaha'),
                'id_provinsi' => $request->input('provinsi'),
                'id_kota' => $request->input('kota'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            DB::table('tb_ukm')->updateOrInsert(['ID_USER' => session('user')[0]['ID_USER']], $data);
            return redirect('data_ukm')->with('success', 'Data Pemilik UKM berhasil disimpan');
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e
            ], 422);
        }
    }
    public function store_data_pemilik(Request $request)
    {
        try {
            $data = [
                'ID_USER'                       => session('user')[0]['ID_USER'],
                'nama_pemilik'                  => $request->input('namaPemilik'),
                'nik_pemilik'                   => $request->input('nikPemilik'),
                'phone_pemilik'                 => $request->input('telpPemilik'),
                'jenis_kelamin_pemilik'         => $request->input('jenisKelaminPemilik'),
                'tempat_lahir_pemilik'          => $request->input('tempatLahirPemilik'),
                'tanggal_lahir_pemilik'         => $request->input('tanggalLahirPemilik'),
                'pendidikan_terakhir_pemilik'   => $request->input('pendidikanTerakhirPemilik'),
                'alamat_pemilik'                => $request->input('alamatPemilik'),
                'updated_at'                    => date('Y-m-d H:i:s'),
            ];

            DB::table('tb_ukm')->updateOrInsert(['ID_USER' => session('user')[0]['ID_USER']], $data);
            return redirect('data_ukm')->with('success', 'Data Pemilik UKM berhasil disimpan');
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e
            ], 422);
        }
    }
    public function store_data_lain(Request $request)
    {
        try {
            $get_id_ukm = DB::selectOne('
                SELECT
                    id_ukm
                FROM
                    tb_ukm
                WHERE
                    ID_USER = "' . session('user')[0]['ID_USER'] . '"
            ')->id_ukm;

            // Mapping the input fields to their respective tables and columns
            $dataMappings = [
                'sumberBahanBaku' => ['table' => 'tb_bahan_baku_ukm', 'column' => 'id_bahan_baku'],
                'fasilitas' => ['table' => 'tb_fasilitas_ukm', 'column' => 'id_fasilitas'],
                'legalitasUsaha' => ['table' => 'tb_legalitas_ukm', 'column' => 'id_legalitas_usaha'],
                'permasalahan' => ['table' => 'tb_permasalahan_ukm', 'column' => 'id_permasalahan'],
                'standarisasiProduk' => ['table' => 'tb_standart_ukm', 'column' => 'id_standarisasi_produk'],
                'wilayahPemasaran' => ['table' => 'tb_pemasaran_ukm', 'column' => 'id_pemasaran'],
            ];

            // Helper function to handle insert or update
            foreach ($dataMappings as $inputField => $mapping) {
                if (!empty($request->$inputField)) {
                    DB::table($mapping['table'])->where(['id_ukm' => $get_id_ukm])->delete();
                    foreach ($request->$inputField as $value) {
                        $data = [
                            'uuid' => Str::uuid(),
                            'id_ukm' => $get_id_ukm,
                            $mapping['column'] => $value,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        DB::table($mapping['table'])->Insert($data);
                    }
                }
            }

            return redirect('data_ukm')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e
            ], 422);
        }
    }
    public function get_kota(Request $request)
    {
        $id_kota = $request->id_kota;
        $data = DB::select('
            SELECT
                *
            FROM
                md_kota
            WHERE
                id_provinsi = "' . $request->id . '"
        ');
        $html = '<label for="kota" class="form-label">Kota</label>
                <select class="form-select" name="kota" id="kota" required>
                <option disabled value="" ' . (empty($id_kota) ? 'selected' : '') . '>Pilih...</option>';
        foreach ($data as $item) {
            $selected = ($item->id_kota == $id_kota) ? 'selected' : '';
            $html .= '<option value="' . $item->id_kota . '" ' . $selected . '>' . $item->nama_kota . '</option>';
        }
        $html .= '</select>';
        return response()->json($html);
    }
    public function data_koperasi_index()
    {
        $data['title'] = "Data Koperasi";

        $data['data_personal'] = DB::selectOne("
            SELECT
                u.*
            FROM
                user u
            WHERE 
            u.ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");

        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';
        ");

        $data['data_koperasi'] = DB::selectOne('
            SELECT
                *
            FROM
                tb_koperasi
            WHERE ID_USER = "' . session('user')[0]['ID_USER'] . '"
        ');

        if ($data['data_koperasi'] == null) {
            $data_koperasi = [
                'ID_USER' => session('user')[0]['ID_USER'],
                'uuid' => Str::uuid(),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            DB::table('tb_koperasi')->insert($data_koperasi);

            $data['data_koperasi'] = DB::selectOne('
                SELECT
                    *
                FROM
                    tb_koperasi
                WHERE ID_USER = "' . session('user')[0]['ID_USER'] . '"
            ');
        }

        $data['check'] = DB::selectOne("
            SELECT
                (
                    SUM(CASE WHEN tk.nik IS NOT NULL AND tk.nik != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.nm_koperasi IS NOT NULL AND tk.nm_koperasi != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.phone IS NOT NULL AND tk.phone != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.alamat_koperasi IS NOT NULL AND tk.alamat_koperasi != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.id_provinsi IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.id_kota IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.id_bentuk_koperasi IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.id_jenis_koperasi IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.id_kelompok_koperasi IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.id_sektor_usaha IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.volume_usaha IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.asset IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.id_unit_usaha IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.modal_sendiri IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.modal_luar IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.sisa_hasil_usaha IS NOT NULL THEN 1 ELSE 0 END)
                ) AS COUNT_DATA_KOPERASI,
                (
                    SUM(CASE WHEN tk.no_badan_hukum IS NOT NULL AND tk.no_badan_hukum != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.tgl_badan_hukum IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.no_pad IS NOT NULL AND tk.no_pad != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.tgl_pad IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.status IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.cabang IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.tgl_rat IS NOT NULL THEN 1 ELSE 0 END)
                ) AS COUNT_DATA_HUKUM,
                (
                    SUM(CASE WHEN tk.nm_ketua IS NOT NULL AND tk.nm_ketua != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.phone_ketua IS NOT NULL AND tk.phone_ketua != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.nm_sekretaris IS NOT NULL AND tk.nm_sekretaris != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.phone_sekretaris IS NOT NULL AND tk.phone_sekretaris != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.nm_bendahara IS NOT NULL AND tk.nm_bendahara != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.phone_bendahara IS NOT NULL AND tk.phone_bendahara != '' THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.anggota_pria IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.anggota_wanita IS NOT NULL THEN 1 ELSE 0 END) + 
                    SUM(CASE WHEN tk.manager_pria IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.manager_wanita IS NOT NULL THEN 1 ELSE 0 END) + 
                    SUM(CASE WHEN tk.karyawan_pria IS NOT NULL THEN 1 ELSE 0 END) +
                    SUM(CASE WHEN tk.karyawan_wanita IS NOT NULL THEN 1 ELSE 0 END)
                ) AS COUNT_DATA_PENGURUS
            FROM 
                tb_koperasi tk 
            WHERE 
                ID_USER = '" . session('user')[0]['ID_USER'] . "'
        ");

        $masterDataTables = [
            'provinsi' => 'md_provinsi',
            'bentuk_koperasi' => 'md_bentuk_koperasi',
            'jenis_koperasi' => 'md_jenis_koperasi',
            'kelompok_koperasi' => 'md_kelompok_koperasi',
            'sektor_usaha' => 'md_sektor_usaha',
            'unit_usaha' => 'md_unit_usaha',
            'kategori_ukm' => 'md_kategori_ukm',
            'permasalahan' => 'md_masalah_koperasi',
        ];

        foreach ($masterDataTables as $key => $table) {
            $data[$key] = DB::table($table)->get()->toArray();
        }

        $dataForUpdate = [
            'tb_masalah_koperasi' => 'tb_masalah_koperasi',
        ];

        foreach ($dataForUpdate as $key => $table) {
            $data[$key] = DB::table($table)->where('koperasi_id', $data['data_koperasi']->id)->get()->toArray();
        }
        return
            view('template.header', $data) .
            view('template_guest.profile.data_koperasi', $data) .
            view('template.footer', $data);
    }
    public function store_data_koperasi(Request $request)
    {
        try {
            $data = [
                'nm_koperasi' => $request->input('namaKoperasi'),
                'nik' => $request->input('nikKoperasi'),
                'phone' => $request->input('telpKoperasi'),
                'alamat_koperasi' => $request->input('alamatKoperasi'),
                'id_provinsi' => $request->input('provinsi'),
                'id_bentuk_koperasi' => $request->input('bentukKoperasi'),
                'id_jenis_koperasi' => $request->input('jenisKoperasi'),
                'id_kelompok_koperasi' => $request->input('kelompokKoperasi'),
                'id_sektor_usaha' => $request->input('sektorUsaha'),
                'volume_usaha' => str_replace('.', '', $request->input('volumePerbulan')),
                'asset' => str_replace('.', '', $request->input('asset')),
                'id_unit_usaha' => $request->input('UnitUsaha'),
                'modal_sendiri' => str_replace('.', '', $request->input('modalSendiri')),
                'modal_luar' => str_replace('.', '', $request->input('modalLuar')),
                'sisa_hasil_usaha' => str_replace('.', '', $request->input('sisaHasilUsaha')),
                'id_kota' => $request->input('kota'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            DB::table('tb_koperasi')->updateOrInsert(['ID_USER' => session('user')[0]['ID_USER']], $data);
            return redirect('data_koperasi')->with('success', 'Data Koperasi berhasil disimpan');
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e
            ], 422);
        }
    }
    public function store_hukum_koperasi(Request $request)
    {
        try {
            $data = [
                'no_badan_hukum' => $request->input('noBadanHukum'),
                'tgl_badan_hukum' => $request->input('tglBadanHukum'),
                'no_pad' => $request->input('noPAD'),
                'tgl_pad' => $request->input('tglPAD'),
                'status' => $request->input('status'),
                'cabang' => $request->input('jmlKantorCabang'),
                'tgl_rat' => $request->input('tglRAT'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            DB::table('tb_koperasi')->updateOrInsert(['ID_USER' => session('user')[0]['ID_USER']], $data);
            return redirect('data_koperasi')->with('success', 'Data Koperasi berhasil disimpan');
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e
            ], 422);
        }
    }
    public function store_anggota_koperasi(Request $request)
    {
        try {
            $data = [
                'nm_ketua' => $request->input('namaKetua'),
                'phone_ketua' => $request->input('noHPKetua'),
                'nm_sekretaris' => $request->input('namaSekre'),
                'phone_sekretaris' => $request->input('noHPSekre'),
                'nm_bendahara' => $request->input('namaBendahara'),
                'phone_bendahara' => $request->input('noHPBendahara'),
                'anggota_pria' => $request->input('jmlAnggotaPria'),
                'anggota_wanita' => $request->input('jmlAnggotaWanita'),
                'manager_pria' => $request->input('jmlManajerPria'),
                'manager_wanita' => $request->input('jmlManajerWanita'),
                'karyawan_pria' => $request->input('jmlKaryawanPria'),
                'karyawan_wanita' => $request->input('jmlKaryawanWanita'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            DB::table('tb_koperasi')->updateOrInsert(['ID_USER' => session('user')[0]['ID_USER']], $data);
            return redirect('data_koperasi')->with('success', 'Data Koperasi berhasil disimpan');
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e
            ], 422);
        }
    }

    public function store_masalah_koperasi(Request $request)
    {
        try {
            $get_id_koperasi = DB::selectOne('
                SELECT
                    id
                FROM
                    tb_koperasi
                WHERE
                    ID_USER = "' . session('user')[0]['ID_USER'] . '"
            ')->id;
            if (!empty($request->permasalahan)) {
                DB::table('tb_masalah_koperasi')->where(['koperasi_id' => $get_id_koperasi])->delete();
                foreach ($request->permasalahan as $value) {
                    $data = [
                        'uuid' => Str::uuid(),
                        'koperasi_id' => $get_id_koperasi,
                        'masalah_koperasi_id' => $value,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    DB::table('tb_masalah_koperasi')->Insert($data);
                }
            }

            return redirect('data_koperasi')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e
            ], 422);
        }
    }
    public function cek_email(Request $request)
    {
        $email = $request->email;
        $id_user = session('user')[0]['ID_USER'];

        $email_old = DB::selectOne('
            SELECT
                email
            FROM
                user
            WHERE
                ID_USER = "' . $id_user . '"
        ')->email;

        if ($email == $email_old) {
            return response()->json(['status' => 'success']);
        }

        $check_email = DB::selectOne('
            SELECT
                email
            FROM
                user
            WHERE
                email = "' . $email . '" 
                AND ID_USER != "' . $id_user . '"
        ');

        if ($check_email) {
            return response()->json(['status' => 'error', 'message' => 'Email sudah digunakan', 'code' => 1]);
        } else {
            return response()->json(['status' => 'success']);
        }
    }
    public function get_kota_option(Request $request)
    {
        $id_kota = $request->id_kota == 'null' || empty($request->id_kota) ? '' : 'AND id_kota = "' . $request->id_kota . '"';
        $data = DB::select('
            SELECT
                *
            FROM
                md_kota
            WHERE
                id_provinsi = "' . $request->id . '"
                ' . $id_kota . '
        ');
        return response()->json($data);
    }
}
