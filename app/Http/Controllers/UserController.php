<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\FileUpload;

class UserController extends Controller
{
    public function index() {
        $data['title'] = "User";

        $data["user"] = DB::select("
            SELECT
                u.*,
                p.nama_province,
                k.nama_kota
            FROM
                user u
            LEFT JOIN md_provinsi p ON
                u.ID_PROVINSI = p.ID_PROVINSI
            LEFT JOIN md_kota k ON
                u.ID_KOTA = k.ID_KOTA
            WHERE
                u.IS_DELETE = 0
        ");

        $data['provinsi'] = DB::select("
            SELECT 
                *
            FROM 
                md_provinsi
            ");

        $data['admin'] = true;
        return
            view('template.header', $data) .
            view('template_admin/user', $data) .
            view('template.footer', $data);
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

        return redirect('user')->with(['succ_msg' => 'Berhasil menambahkan user baru', 'location' => 'user']);
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

        return redirect('user')->with(['succ_msg' => 'Berhasil memperbarui user', 'location' => 'user']);
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
            'JENIS_INSTANSI'=> $request->input('up_userJenisInstansi'),
            'STATUS'        => $request->input('up_userStatus'),
            'IS_DELETE'     => $request->input('up_userIsDelete'),
            'ID_PROVINSI'   => $request->input('up_userIdProvinsi'),
            'ID_KOTA'       => $request->input('up_userIdKota'),
        ];

        if ($request->hasFile('foto_profile')) {
            $user['FOTO_PROFILE'] = FileUpload::S3($request->file('foto_profile'), 'IMAGE_ACTIVITY', 'Image-Activity-' . strtotime(now()));
        }

        DB::table('user')->where('ID_USER', $request->input('up_userId'))->update($user);
        return redirect('user')->with([
            'msg' => 'Berhasil memperbarui data user '.$request->input('up_userName'),
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
            return redirect('user')->with(['msg' => 'Berhasil menghapus user', 'location' => 'user']);    
        } catch (\Throwable $e) {
            return redirect('user')->with(['msg' => 'Error'.$e, 'location' => 'user']);  
        }
    }
    public function detail_pengambilan(Request $req)
    {
        try {
            $data['title'] = "Detail Pengambilan";
            $data['nama_user'] = DB::selectOne("
                SELECT 
                    NAME 
                FROM 
                    user 
                WHERE 
                    ID_USER = '".$req->input('id_user')."'");
            $data['activities'] = DB::select("
                SELECT
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
                    o.ID_USER = '".$req->input('id_user')."'
            ");
            $data['admin'] = true;
            
            return
                view('template.header', $data) .
                view('template_admin.detail_pengambilan_user', $data) .
                view('template.footer', $data);  
        } catch (\Throwable $e) {
            return redirect('user/detail_pengambilan')->with(['msg' => 'Error'.$e, 'location' => 'user']);  
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
}
