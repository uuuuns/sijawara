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
            'transport' => 'smtp',
            'host' => 'smtp-relay.brevo.com',
            'port' => 587,
            'from' => ['address' => 'sijawara@gmail.com', 'name' => 'SIJAWARA'],
            'encryption' => 'tls',
            'username' => 'dbi.malang.o@gmail.com',
            'password' => '7YPLNq6KfpydDGBT',
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
        // dd($data);
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
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';

        ");
        // dd($data);
        return
            view('template.header', $data) .
            view('template_guest/profile/academic', $data) .
            view('template.footer', $data);
    }
    public function document()
    {
        $data['title'] = "Supporting Documents";
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '" . session('user')[0]['ID_USER'] . "';

        ");
        // dd($data['document']);
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
        // dd($data['document']);
        return
            view('template.header', $data) .
            view('template_guest/profile/overview', $data) .
            view('template.footer', $data);
    }
    public function myevents()
    {
        $data['title'] = "Webinar Ku";
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
    public function mycourses()
    {
        $data['title'] = "Kursus Ku";
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
                'PROVINSI' => $request->input('provinsi'),
            ]
        );
        $data[0]['FOTO_PROFILE'] = null;
        if (!empty($request->file('foto_profile'))) {
            $data[0]['FOTO_PROFILE'] = FileUpload::S3($request->file('foto_profile'), 'FOTO_PROFILE', 'Foto-Profile-' . strtotime(now()));
        }
        $updateStatus = User::update_profile($data);
        if ($updateStatus) {
            $user_data = collect([
                'EMAIL' => $request->input('email'),
                'NAME' => $request->input('name_user'),
                'ID_USER' => session('user')[0]['ID_USER'],
                'ID_ROLE' => session('user')[0]['ID_ROLE'],
                'LOGGED_IN' => TRUE
            ]);
            Session::flush();
            Session::push('user', $user_data);
        }
        return redirect('/profile');
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
        $data = [
            'IS_DOWNLOADED' => 1
        ];
        DB::table('sertifikat_activity')->where('ID_ACTIVITY', $request->id_activity)->where('ID_USER', session('user')[0]['ID_USER'])->update($data);

        // SEND EMAIL SUCCESS DOWNLOAD SERTIFIKAT
        $data['user'] = DB::selectOne('
            SELECT
                *
            FROM
                user
            WHERE
                ID_USER = "' . session('user')[0]['ID_USER'] . '"
        ');

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
            'title' => 'Selamat '.$data['user']->NAME.', Anda telah berhasil mengunduh sertifikat',
            'body'  => 'Sertifikat dari '.$data['activity']->TYPE_ACTIVITY == 1 ? 'Webinar' : 'Kursus'.' Dengan Judul '.$data['activity']->TITLE_ACTIVITY.', Sertifikat yang telah diunduh dapat dilihat di halaman profil anda dibagian SertifikatKu',
        ];
        $mail = new MailSender($details);
        $mail->subject("Sukses Download Sertifikat");
        Mail::to($data['user']->EMAIL)->send($mail);
        // END  SUCCESS DOWNLOAD SERTIFIKAT

        return response()->json(['status' => 'success']);   
    }

    public function data_ukm_index(){
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
            WHERE ID_USER = "'.session('user')[0]['ID_USER'].'"
        ');

        if ($data['data_ukm'] == null) {
            $data_ukm = [
                'ID_USER' => session('user')[0]['ID_USER'],
                'uuid' => Str::uuid()
            ];

            DB::table('tb_ukm')->insert($data_ukm);

            $data['data_ukm'] = DB::selectOne('
                SELECT
                    *
                FROM
                    tb_ukm
                WHERE ID_USER = "'.session('user')[0]['ID_USER'].'"
            ');
        }

        $data['check'] = DB::selectOne("
            SELECT 
                (
                    SUM(NULLIF(tu.nama_pemilik, '') IS NOT NULL) +
                    SUM(NULLIF(tu.nik_pemilik, '') IS NOT NULL) +
                    SUM(NULLIF(tu.phone_pemilik, '') IS NOT NULL) +
                    SUM(NULLIF(tu.jenis_kelamin_pemilik, '') IS NOT NULL) +
                    SUM(NULLIF(tu.tempat_lahir_pemilik, '') IS NOT NULL) +
                    SUM(NULLIF(tu.tanggal_lahir_pemilik, '') IS NOT NULL) +
                    SUM(NULLIF(tu.pendidikan_terakhir_pemilik, '') IS NOT NULL) +
                    SUM(NULLIF(tu.alamat_pemilik, '') IS NOT NULL)
                ) AS COUNT_DATA_PEMILIK,
                (
                    SUM(NULLIF(tu.nama_ukm, '') IS NOT NULL) +
                    SUM(NULLIF(tu.alamat_ukm, '') IS NOT NULL) +
                    SUM(NULLIF(tu.id_provinsi, '') IS NOT NULL) +
                    SUM(NULLIF(tu.id_kota, '') IS NOT NULL) +
                    SUM(NULLIF(tu.kegiatan_usaha, '') IS NOT NULL) +
                    SUM(NULLIF(tu.produk_dihasilkan, '') IS NOT NULL) +
                    SUM(NULLIF(tu.id_kategori_ukm, '') IS NOT NULL) +
                    SUM(NULLIF(tu.tahun_mulai, '') IS NOT NULL) +
                    SUM(NULLIF(tu.kapasitas_produksi, '') IS NOT NULL) +
                    SUM(NULLIF(tu.volume_usaha, '') IS NOT NULL) +
                    SUM(NULLIF(tu.tenaga_pria, '') IS NOT NULL) +
                    SUM(NULLIF(tu.tenaga_wanita, '') IS NOT NULL) +
                    SUM(NULLIF(tu.id_badan_usaha, '') IS NOT NULL) +
                    SUM(NULLIF(tu.npwp, '') IS NOT NULL) +
                    SUM(NULLIF(tu.lokasi_pemasaran, '') IS NOT NULL) +
                    SUM(NULLIF(tu.nilai_realisasi, '') IS NOT NULL) +
                    SUM(NULLIF(tu.tahun_realisasi, '') IS NOT NULL)
                ) AS COUNT_DATA_UKM
            FROM 
                tb_ukm tu 
            WHERE 
                ID_USER = '".session('user')[0]['ID_USER']."'
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

    public function store_data_ukm (Request $request) {
        try {
            $data = [
                'nama_ukm' => $request->input('namaUKM'),
                'kegiatan_usaha' => $request->input('kegiatanUsaha'),
                'produk_dihasilkan' => $request->input('produkUKM'),
                'id_kategori_ukm' => $request->input('kategoriProduk'),
                'tahun_mulai' => $request->input('tahunMemulai'),
                'kapasitas_produksi' => str_replace('.', '',$request->input('kapasitasProduksi')),
                'volume_usaha' => str_replace('.', '',$request->input('volumePerbulan')),
                'tenaga_pria' => $request->input('tenagaLaki'),
                'tenaga_wanita' => $request->input('tenagaPerempuan'),
                'id_badan_usaha' => $request->input('bentukUsaha'),
                'npwp' => $request->input('npwp'),
                'lokasi_pemasaran' => $request->input('lokasiPemasaran'),
                'nilai_realisasi' => str_replace('.', '',$request->input('nilaiRealisasi')),
                'tahun_realisasi' => $request->input('tahunRealisasi'),
                'alamat_ukm' => $request->input('alamatUsaha'),
                'id_provinsi' => $request->input('provinsi'),
                'id_kota' => $request->input('kota'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            DB::table('tb_ukm')->updateOrInsert(['ID_USER' => session('user')[0]['ID_USER']], $data);
            return redirect('data_ukm')->with('success', 'Data Pemilik UKM berhasil disimpan');
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }

    public function store_data_pemilik (Request $request) {
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
                'created_at'                    => date('Y-m-d H:i:s'),
                'updated_at'                    => date('Y-m-d H:i:s'),
            ];
            
            DB::table('tb_ukm')->updateOrInsert(['ID_USER' => session('user')[0]['ID_USER']], $data);
            return redirect('data_ukm')->with('success', 'Data Pemilik UKM berhasil disimpan');
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }
    public function store_data_lain (Request $request) {
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
                        DB::table($mapping['table'])->Insert( $data);
                    }
                }
            }

            return redirect('data_ukm')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }

    public function get_kota (Request $request) {
        $data = DB::select('
            SELECT
                *
            FROM
                md_kota
            WHERE
                id_provinsi = "'.$request->id.'"
        ');
        $html = '<label for="kota" class="form-label">Kota</label>
        <select class="form-select" name="kota" id="kota" required>
          <option disabled value="" ' . (empty($data_ukm->id_kota) ? 'selected' : '') . '>Pilih...</option>';
        foreach ($data as $item) {
            $selected = ($item->id_kota == $item->id_kota) ? 'selected' : '';
            $html .= '<option value="' . $item->id_kota . '" ' . $selected . '>' . $item->nama_kota . '</option>';
        }
        $html .= '</select>';
        return response()->json($html);
    }
}