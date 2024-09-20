<?php

namespace App\Http\Controllers\ukm_controller;

use App\Http\Controllers\Controller;
use App\Models\JabatanUkm;
use Illuminate\Http\Request;

class JabatanUkmController extends Controller
{
    //
    public function index(){
        $jabatan = new JabatanUkm();
        $data['title'] = "Jabatan UKM";
        $data['jabatan'] = $jabatan->get_all_data();
        // dd($data['usaha']);
        return
            view('template.header', $data) .
            view('template_admin/master_data/ukm/jabatan_ukm', $data) .
            view('template.footer', $data);

    }

    public function store(Request $req){
        $jabatan = new JabatanUkm();
        $data = [
            'NAMA_JABATAN_UKM'  => strip_tags($req->input('add_nama_jabatan_ukm'))
        ];
        // dd($data);
        $jabatan->insertJU($data);
        return redirect('ukm/jabatan_ukm')->with(['succ_msg' => 'Successfully Add Jabatan UKM']);
    }

    public function update(Request $req){
        $jabatan = new JabatanUkm();
        $data = [
            'ID' => $req->input('id'),
            'NAMA_JABATAN_UKM'  => strip_tags($req->input('nama_jabatan_ukm'))
        ];
        // dd($data);
        $jabatan->updateJU($data, $data['ID']);
        return redirect('ukm/jabatan_ukm')->with(['succ_msg' => 'Successfully edit Jabatan UKM']);
    }

    public function delete(Request $req){
        $jabatan = new JabatanUkm();
        $data = $req->input('id');
        // dd($data);
        $jabatan->deleteJU($data);
        return redirect('ukm/jabatan_ukm')->with(['succ_msg' => 'Successfully delete Jabatan UKM']);
    }
}
