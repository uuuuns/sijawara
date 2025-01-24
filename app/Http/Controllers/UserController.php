<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\FileUpload;
use App\Models\Laporan;

class UserController extends Controller
{
    public function index()
    {
        $data['title'] = "User";

        $data['provinsi'] = DB::select("
            SELECT 
                *
            FROM 
                md_provinsi
            ");

        $data['admin'] = true;

        return
            view('template.header', $data) .
            view('template_admin.user.user', $data) .
            view('template.footer', $data);
    }

    public function filter_user(Request $req)
    {
        $query = DB::table('user as u')
            ->leftJoin('md_provinsi as p', 'u.ID_PROVINSI', '=', 'p.ID_PROVINSI')
            ->leftJoin('md_kota as k', 'u.ID_KOTA', '=', 'k.ID_KOTA')
            ->leftJoin('tb_koperasi as ko', 'ko.ID_USER', '=', 'u.ID_USER')
            ->leftJoin('tb_ukm as tu', 'tu.ID_USER', '=', 'u.ID_USER')
            ->leftJoin('md_sektor_usaha as su', 'ko.id_sektor_usaha', '=', 'su.ID')
            ->leftJoin('md_kategori_ukm as ku', 'tu.id_kategori_ukm', '=', 'ku.ID')
            ->select('u.*', 'p.nama_province', 'k.nama_kota')
            ->where('u.IS_DELETE', 0);
        
        if ($req->input('JENIS_INSTANSI') != 'ALL') {
            $query->where('u.JENIS_INSTANSI', $req->input('JENIS_INSTANSI'));
        }

        if ($req->input('USAHA') != 'ALL') {
            if ($req->input('JENIS_INSTANSI') == 'UKM') {
                $query->where('tu.id_kategori_ukm', $req->input('USAHA'));
            } elseif ($req->input('JENIS_INSTANSI') == 'KOPERASI') {
                $query->where('ko.id_sektor_usaha', $req->input('USAHA'));
            }
        }

        $data['user'] = $query->get();

        return view('template_admin.user.paper_ajax', $data);
    }

    public function store(Request $req)
    {
        $user = [
            'ID_USER'       => $this->GenerateUniqID('USR', $req->input('name')),
            'NAME'          => $req->input('name'),
            'EMAIL'         => $req->input('email'),
            'PASS'          => hash('sha256', md5($req->input('password'))),
            'ID_ROLE'       => 2,
            'TELP'          => $req->input('contact'),
            'JK'            => $req->input('jk'),
            'FOTO_PROFILE'  => FileUpload::S3($req->file('foto_profile'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now())),
            'STATUS'        => 1
        ];

        $userdata = [
            'ID_USER'       => $user['ID_USER'],
            'UNIV'          => $req->input('univ'),
            'NIM'           => $req->input('nim'),
            'STUDY'         => $req->input('study'),
            'DEGREE'        => $req->input('degree'),
            'SEMESTER'      => $req->input('semester'),
            'IS_GRADUATED'  => $req->input('is_graduated')
        ];

        if (!empty($req->file('cv_doc'))) {
            $userdata['CV']             = FileUpload::S3($req->file('cv_doc'), 'DOCUMENT_CV', 'Image-Activity-' . strtotime(now()));
        }

        if (!empty($req->file('certi_doc'))) {
            $userdata['PORTOFOLIO']     = FileUpload::S3($req->file('certi_doc'), 'DOCUMENT_CERTIFICATE', 'Image-Activity-' . strtotime(now()));
        }

        if (!empty($req->file('portofolio_doc'))) {
            $userdata['SERTIFIKAT']     = FileUpload::S3($req->file('portofolio_doc'), 'DOCUMENT_PORTOFOLIO', 'Image-Activity-' . strtotime(now()));
        }

        if (!empty($req->file('recommend_doc'))) {
            $userdata['SURAT_RECOM']    = FileUpload::S3($req->file('recommend_doc'), 'DOCUMENT_RECOMMENDATION', 'Image-Activity-' . strtotime(now()));
        }

        DB::table('user')->INSERT($user);
        DB::table('user_data')->INSERT($userdata);

        return redirect('pengguna')->with(['succ_msg' => 'Berhasil menambahkan user baru', 'location' => 'user']);
    }

    public function update(Request $req)
    {
        $user = [
            'NAME'          => $req->input('up_name'),
            'EMAIL'         => $req->input('up_email'),
            'TELP'          => $req->input('up_contact'),
            'JK'            => $req->input('up_jk'),
        ];

        if (!empty($req->input('up_foto_profile'))) {
            $user['FOTO_PROFILE'] = FileUpload::S3($req->file('up_foto_profile'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now()));
        }

        DB::table('user')->WHERE(['ID_USER' => $req->input('up_id_user')])->update($user);

        return redirect('pengguna')->with(['succ_msg' => 'Berhasil memperbarui user', 'location' => 'user']);
    }
    public function update_profile(Request $request)
    {
        $user = [
            'NAME'          => $request->input('up_userName'),
            'EMAIL'         => $request->input('up_userEmail'),
            'TELP'          => $request->input('up_userTelp'),
            'JK'            => $request->input('up_userJK'),
            'NIK'           => $request->input('up_userNIK'),
            'ALAMAT'        => $request->input('up_userAlamat'),
            'TGL_LAHIR'     => $request->input('up_userTglLahir'),
            'TEMPAT_LAHIR'  => $request->input('up_userTempatLahir'),
            'NAMA_INSTANSI' => $request->input('up_userInstansi'),
            'JABATAN'       => $request->input('up_userJabatan'),
            'JENIS_INSTANSI' => $request->input('up_userJenisInstansi'),
            'STATUS'        => $request->input('up_userStatus'),
            'IS_DELETE'     => $request->input('up_userIsDelete'),
            'ID_PROVINSI'   => $request->input('up_userIdProvinsi'),
            'ID_KOTA'       => $request->input('up_userIdKota'),
        ];

        if ($request->hasFile('foto_profile')) {
            $user['FOTO_PROFILE'] = FileUpload::S3($request->file('foto_profile'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now()));
        }

        DB::table('user')->where('ID_USER', $request->input('up_userId'))->update($user);
        return redirect('pengguna')->with([
            'msg' => 'Berhasil memperbarui data user ' . $request->input('up_userName'),
            'location' => 'user',
        ]);
    }

    public function delete(Request $req)
    {
        try {
            $user = [
                'IS_DELETE'    => 1
            ];
            DB::table('user')->WHERE(['ID_USER' => $req->input('del_id_user')])->update($user);
            return redirect('pengguna')->with(['msg' => 'Berhasil menghapus user', 'location' => 'user']);
        } catch (\Throwable $e) {
            return redirect('pengguna')->with(['msg' => 'Error' . $e, 'location' => 'user']);
        }
    }
    public function detail_pengambilan(Request $req)
    {
        try {
            $data['title'] = "Detail Pengambilan";
            $data['nama_user'] = DB::selectOne("
                SELECT 
                    NAME,
                    JENIS_INSTANSI,
                    NAMA_INSTANSI 
                FROM 
                    user
                WHERE 
                    ID_USER = '" . $req->input('id_user') . "'");
            $data['activities'] = DB::select("
                SELECT
                    a.ID_ACTIVITY ,
                    a.TITLE_ACTIVITY ,
                    o.LOG_TIME ,
                    u.NAME ,
                    a.TYPE_ACTIVITY 
                FROM
                    activity a 
                LEFT JOIN `order` o ON   
                    o.ID_PRODUCT  = a.ID_ACTIVITY 
                LEFT JOIN user u ON   
                    o.ID_USER  = u.ID_USER 
                WHERE
                    o.ID_USER = '" . $req->input('id_user') . "'
            ");
            $data['admin'] = true;

            return
                view('template.header', $data) .
                view('template_admin.detail_pengambilan_user', $data) .
                view('template.footer', $data);
        } catch (\Throwable $e) {
            return redirect('pengguna/detail_pengambilan')->with(['msg' => 'Error' . $e, 'location' => 'user']);
        }
    }

    public function GenerateUniqID($first, $var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "ACT_" . $uniqid . substr(md5(time()), 0, 3);
    }

    public function jadikanAdmin(Request $request)
    {
        $id_user = $request->input('id_user');
        DB::table('user')
            ->where('ID_USER', $id_user)
            ->update(['ID_ROLE' => 4]);

        return redirect()->back();
    }

    public function jadikanInstruktur(Request $request)
    {
        $id_user = $request->input('id_user');
        DB::table('user')
            ->where('ID_USER', $id_user)
            ->update(['ID_ROLE' => 2]);

        return redirect()->back();
    }

    public function filter_ukm()
    {
        $kelompok_ukm = DB::Select("
            SELECT
                *
            FROM
                md_kategori_ukm
        ");
        
        return $kelompok_ukm;
    }

    public function filter_koperasi()
    {
        $sektor_usaha = DB::Select("
            SELECT
                *
            FROM
                md_sektor_usaha
        ");

        return $sektor_usaha;
    }

    public function laporan_ukm()
    {
        set_time_limit(300);

        $ukm = DB::select("
            SELECT
                u.NIK,
                u.NAME,
                u.EMAIL,
                u.TELP,
                u.JK,
                u.ALAMAT,
                u.JABATAN,
                mp_peserta.nama_province AS nama_provinsi_peserta,
                mk_peserta.nama_kota AS nama_kota_peserta,
                mp_pemilik.nama_province AS nama_provinsi_pemilik,
                mk_pemilik.nama_kota AS nama_kota_pemilik,
                k.NAMA_KATEGORI_UKM,
                b.NAMA_BADAN_USAHA,
                tu.*
            FROM 
                user u
            LEFT JOIN tb_ukm tu ON
                tu.ID_USER = u.ID_USER
            LEFT JOIN md_kategori_ukm k ON
                tu.id_kategori_ukm = k.ID
            LEFT JOIN md_badan_usaha b ON
                tu.id_badan_usaha = b.ID
            LEFT JOIN md_provinsi mp_peserta ON
                mp_peserta.ID_PROVINSI = u.ID_PROVINSI
            LEFT JOIN md_kota mk_peserta ON
                mk_peserta.ID_KOTA = u.ID_KOTA
            LEFT JOIN md_provinsi mp_pemilik ON
                mp_pemilik.ID_PROVINSI = tu.ID_PROVINSI
            LEFT JOIN md_kota mk_pemilik ON
                mk_pemilik.ID_KOTA = tu.ID_KOTA
            WHERE
                u.IS_DELETE = 0
            AND
                u.JENIS_iNSTANSI LIKE '%UKM%';
        ");

        $laporanService = app(Laporan::class);
        $filePath = $laporanService->laporan_ukm($ukm);

        return response()->json([
            'success' => true,
            'file_url' => secure_asset('reporting/' . $filePath),
        ]);
    }

    public function laporan_koperasi()
    {
        set_time_limit(300);

        $koperasi = DB::select("
            SELECT
                u.NIK,
                u.NAME,
                u.EMAIL,
                u.TELP,
                u.JK,
                u.ALAMAT,
                u.JABATAN,
                mp_peserta.nama_province AS nama_provinsi_peserta,
                mk_peserta.nama_kota AS nama_kota_peserta,
                mp_pemilik.nama_province AS nama_provinsi_pemilik,
                mk_pemilik.nama_kota AS nama_kota_pemilik,
                bk.NAMA AS NAMA_BENTUK_KOPERASI,
                jk.NAMA AS NAMA_JENIS_KOPERASI,
                kk.NAMA AS NAMA_KELOMPOK_KOPERASI,
                su.NAMA AS NAMA_SEKTOR_USAHA,
                uu.name AS NAMA_UNIT_USAHA,
                ko.*
            FROM
                user u
            LEFT JOIN tb_koperasi ko ON
                ko.ID_USER = u.ID_USER
            LEFT JOIN md_bentuk_koperasi bk ON
                ko.id_bentuk_koperasi = bk.ID
            LEFT JOIN md_jenis_koperasi jk ON
                ko.id_jenis_koperasi = jk.ID
            LEFT JOIN md_kelompok_koperasi kk ON
                ko.id_kelompok_koperasi = kk.ID
            LEFT JOIN md_sektor_usaha su ON
                ko.id_sektor_usaha = su.ID
            LEFT JOIN md_unit_usaha uu ON
                ko.id_unit_usaha = uu.ID
            LEFT JOIN md_provinsi mp_peserta ON
                mp_peserta.ID_PROVINSI = u.ID_PROVINSI
            LEFT JOIN md_kota mk_peserta ON
                mk_peserta.ID_KOTA = u.ID_KOTA
            LEFT JOIN md_provinsi mp_pemilik ON
                mp_pemilik.ID_PROVINSI = ko.ID_PROVINSI
            LEFT JOIN md_kota mk_pemilik ON
                mk_pemilik.ID_KOTA = ko.ID_KOTA
            WHERE
                u.IS_DELETE = 0
            AND
                u.JENIS_iNSTANSI like '%KOPERASI%'
        ");

        $laporanService = app(Laporan::class);
        $filePath = $laporanService->laporan_koperasi($koperasi);

        return response()->json([
            'success' => true,
            'file_url' => secure_asset('reporting/' . $filePath),
        ]);
    }
}
