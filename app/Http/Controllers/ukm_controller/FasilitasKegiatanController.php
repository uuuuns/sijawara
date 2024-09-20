<?php

namespace App\Http\Controllers\ukm_controller;

use App\Http\Controllers\Controller;
use App\Models\FasilitasKegiatan;
use Illuminate\Http\Request;

class FasilitasKegiatanController extends Controller
{
    //
    public function index(){
        $fasilitas = new FasilitasKegiatan();
        $data['title'] = "Fasilitas Kegiatan";
        $data['fasilitas'] = $fasilitas->get_all_data();
        // dd($data['usaha']);
        return
            view('template.header', $data) .
            view('template_admin/master_data/ukm/fasilitas_kegiatan', $data) .
            view('template.footer', $data);

    }

    public function store(Request $req){
        $fasilitas = new FasilitasKegiatan();
        $data = [
            'NAMA_FASILITAS_KEGIATAN'  => strip_tags($req->input('add_nama_fasilitas_kegiatan'))
        ];
        // dd($data);
        $fasilitas->insertFK($data);
        return redirect('ukm/fasilitas_kegiatan')->with(['succ_msg' => 'Successfully Add Fasilitas Kegiatan']);
    }

    public function update(Request $req){
        $fasilitas = new FasilitasKegiatan();
        $data = [
            'ID' => $req->input('id'),
            'NAMA_FASILITAS_KEGIATAN'  => strip_tags($req->input('nama_fasilitas_kegiatan'))
        ];
        // dd($data);
        $fasilitas->updateFK($data, $data['ID']);
        return redirect('ukm/fasilitas_kegiatan')->with(['succ_msg' => 'Successfully edit Fasilitas Kegiatan']);
    }

    public function delete(Request $req){
        $fasilitas = new FasilitasKegiatan();
        $data = $req->input('id');
        // dd($data);
        $fasilitas->deleteFK($data);
        return redirect('ukm/fasilitas_kegiatan')->with(['succ_msg' => 'Successfully delete Fasilitas Kegiatan']);
    }
}
