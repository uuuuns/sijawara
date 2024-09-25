<?php

namespace App\Http\Controllers\ukm_controller;

use App\Http\Controllers\Controller;
use App\Models\LegalitasUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LegalitasUsahaController extends Controller
{
    //
    public function index()
    {
        $data['title'] = "Legalitas Usaha";

        $data["legalitas"] = DB::select("
            SELECT
                lu.*
            FROM
                md_legalitas_usaha lu
        ");   
        $data['admin'] = true;
        // Kirim data ke view
        return
            view('template.header', $data) .
            view('template_admin/master_data/ukm/legalitas_usaha', $data) .
            view('template.footer', $data);
    }   

    public function store(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('nama_legalitas_usaha')
        ];

        DB::table('md_legalitas_usaha')->INSERT($data);

        return redirect('ukm/legalitas_usaha')->with(['succ_msg' => 'Successfully Add Legalitas Usaha']);
    }

    public function update(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('up_nama_legalitas_usaha')
        ];

        DB::table('md_legalitas_usaha')->WHERE(['ID' => $req->input('up_id')])->update($data);

        return redirect('ukm/legalitas_usaha')->with(['succ_msg' => 'Successfully edit Legalitas Usaha']);
    }

    public function delete(Request $req)
    {
        DB::table('md_legalitas_usaha')->WHERE(['ID' => $req->input('del_id_legalitas')])->delete();

        return redirect('ukm/legalitas_usaha')->with(['succ_msg' => 'Successfully delete Legalitas Usaha']);
    }
    
}
