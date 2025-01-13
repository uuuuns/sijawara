<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InstructorController extends Controller
{
    public function index()
    {
        $data['title'] = "Instruktur";

        $data["instructor"] = DB::select("
        SELECT 
            u.*
        FROM 
            user u
        WHERE 
            u.ID_ROLE = 2
        ");
        $data['admin'] = true;
        return
            view('template.header', $data) .
            view('template_admin/instructor', $data) .
            view('template.footer', $data);
    }

    public function apply_instructor()
    {
        if (empty(Session::get('user'))) {
            redirect('keluar');
        }
        $data = [
            'ID_USER' => Session::get('user')[0]['ID_USER'],
            'STATUS' => 0
        ];
        DB::table('instructor_req')->insert($data);
        return redirect('profil')->with(['succ_msg' => 'Berhasil melamar sebagai instruktur, menunggu Admin untuk mengkonfirmasi', 'location' => 'profile']);
    }

    public function accept(Request $req)
    {
        $accept = [
            'STATUS' => 1
        ];

        DB::table('instructor_req')->WHERE(['ID_USER' => $req->input('acc_id_instructor')])->update($accept);
        DB::table('user')->WHERE(['ID_USER' => $req->input('acc_id_instructor')])->update(['ID_ROLE' => 2]);
        return redirect('instruktur')->with(['succ_msg' => 'Berhasil memperbarui data', 'location' => 'instructor']);
    }

    public function decline(Request $req)
    {
        $decline = [
            'STATUS' => 2
        ];

        DB::table('instructor_req')->WHERE(['ID_USER' => $req->input('dec_id_instructor')])->update($decline);

        return redirect('instruktur')->with(['succ_msg' => 'Berhasil memperbarui data', 'location' => 'instructor']);
    }

    public function deleteInstruktur(Request $req)
    {
        try {
            $user = [
                'ID_ROLE'    => 3
            ];
            DB::table('user')->WHERE(['ID_USER' => $req->input('del_id_user')])->update($user);
            return redirect('instruktur')->with(['msg' => 'Berhasil menjadikan user biasa', 'location' => 'instructor']);
        } catch (\Throwable $e) {
            return redirect('instruktur')->with(['msg' => 'Error' . $e, 'location' => 'instructor']);
        }
    }
}
