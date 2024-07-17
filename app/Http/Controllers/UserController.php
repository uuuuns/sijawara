<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\FileUpload;

class UserController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        $data['title'] = "User";

        $data["user"] = DB::select("
            SELECT
                u.ID_USER,
                u.EMAIL,
                u.NAME,
                u.ID_ROLE,
                u.TELP,
                u.JK ,
                u.FOTO_PROFILE ,
                u.SESS_KEY ,
                u.STATUS,
                u.IS_DELETE ,
                ud.*
            FROM
                user u
            LEFT JOIN user_data ud ON   
                ud.ID_USER = u.ID_USER
            WHERE
                u.IS_DELETE = 0
        ");

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

        return redirect('user')->with(['succ_msg' => 'Successfully add new users', 'location' => 'user']);
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

        $userdata = [
            'UNIV'          => $req->input('up_univ'),
            'NIM'           => $req->input('up_nim'),
            'STUDY'         => $req->input('up_study'),
            'DEGREE'        => $req->input('up_degree'),
            'SEMESTER'      => $req->input('up_semester'),
            'IS_GRADUATED'  => $req->input('up_is_graduated')
        ];
        if (!empty($req->file('up_cv_doc'))) {
            $userdata['CV']     = FileUpload::S3($req->file('up_cv_doc'), 'DOCUMENT_CV', 'Image-Activity-' . strtotime(now()));
        }

        if (!empty($req->file('up_certi_doc'))) {
            $userdata['PORTOFOLIO']    = FileUpload::S3($req->file('up_certi_doc'), 'DOCUMENT_CERTIFICATE', 'Image-Activity-' . strtotime(now()));
        }

        if (!empty($req->file('up_portofolio_doc'))) {
            $userdata['SERTIFIKAT']    = FileUpload::S3($req->file('up_portofolio_doc'), 'DOCUMENT_PORTOFOLIO', 'Image-Activity-' . strtotime(now()));
        }

        if (!empty($req->file('up_recommend_doc'))) {
            $userdata['SURAT_RECOM']   = FileUpload::S3($req->file('up_recommend_doc'), 'DOCUMENT_RECOMMENDATION', 'Image-Activity-' . strtotime(now()));
        }

        DB::table('user')->WHERE(['ID_USER' => $req->input('up_id_user')])->update($user);
        DB::table('user_data')->WHERE(['ID_USER' => $req->input('up_id_user')])->update($userdata);

        return redirect('user')->with(['succ_msg' => 'Successfully Update User', 'location' => 'user']);
    }

    public function delete(Request $req)
    {
        $user = [
            'IS_DELETE'    => 1
        ];

        DB::table('user')->WHERE(['ID_USER' => $req->input('del_id_user')])->update($user);

        return redirect('user')->with(['succ_msg' => 'Successfully Delete User', 'location' => 'user']);
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
