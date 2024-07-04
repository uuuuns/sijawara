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

class ProfileGuest extends Controller
{
    protected $user;

    public function __construct(User $genericModel)
    {
        $this->genericModel = $genericModel;
    }

    public function profile()
    {
        $data['title'] = "Personal Data";
        $user = new User();
        // $data['data_personal'] = $user->get_user(session('user')[0]['ID_USER']);
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
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

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
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

        ");
        $data['title'] = "My Ebook";
        return
            view('template.header', $data) .
            view('template_guest/profile/myebook',$data) .
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
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

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
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

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
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

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
        // $data['data_personal'] = $user->get_user(session('user')[0]['ID_USER']);
        $data['event'] = [];
        $mycourse = $user->get_my_product2();
        foreach ($mycourse as $item) {
            if ($item->DATA_CHECKING == 1) {
                array_push($data['event'], $item);
            }
        }
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

        ");
        // dd($data);
        return
            view('template.header', $data) .
            view('template_guest/profile/myevents', $data) .
            view('template.footer', $data);
    }
    public function mycourses()
    {
        $data['title'] = "Kursus Ku";
        $user = new User();
        // dd($data);
        $data['course'] = [];
        $mycourse = $user->get_my_product();
        foreach ($mycourse as $item) {
            if ($item->DATA_CHECKING == 1) {
                array_push($data['course'], $item);
            }
        }
        $data['document'] = DB::selectOne("
            SELECT user_data.*, instructor_req.STATUS
            FROM user_data
            LEFT JOIN instructor_req ON instructor_req.ID_USER = user_data.ID_USER
            WHERE user_data.ID_USER = '". session('user')[0]['ID_USER'] ."';

        ");
        // dd($data['course']);
        return
            view('template.header', $data) .
            view('template_guest/profile/mycourses', $data) .
            view('template.footer', $data);
    }
    public function update_profile(request $request)
    {
        $data = array(
            [
                'FOTO_PROFILE' => FileUpload::S3($request->file('foto_profile'), 'FOTO_PROFILE', 'Foto-Profile-' . strtotime(now())),
                'EMAIL' => $request->input('email'),
                'NAME' => $request->input('name_user'),
                'TELP' => $request->input('no_hp'),
                'JK' => $request->input('jk'),
            ]
        );
        $updateStatus = User::update_profile($data);
        if ($updateStatus) {
            $user_data = collect([
                'EMAIL' => $request->input('email'),
                'NAME' => $request->input('name_user'),
                'ID_USER' => session('user')[0]['ID_USER'],
                'ID_ROLE' => session('user')[0]['ID_ROLE'],
                'FOTO_PROFILE' => $data[0]['FOTO_PROFILE'],
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
}
