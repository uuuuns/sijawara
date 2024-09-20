<?php

namespace App\Http\Controllers\ukm_controller;

use App\Http\Controllers\Controller;
use App\Models\MasalahUkm;
use Illuminate\Http\Request;

class MasalahUkmController extends Controller
{
    //
    public function index(){
        $masalah = new MasalahUkm();
        $data['title'] = "Fasilitas Kegiatan";
        $data['masalah'] = $masalah->get_all_data();
        // dd($data['usaha']);
        return
            view('template.header', $data) .
            view('template_admin/master_data/ukm/masalah_ukm', $data) .
            view('template.footer', $data);

    }

    public function store(Request $req){
        $masalah = new MasalahUkm();
        $data = [
            'NAMA_MASALAH_UKM'  => strip_tags($req->input('add_nama_masalah_ukm'))
        ];
        // dd($data);
        $masalah->insertMU($data);
        return redirect('ukm/masalah_ukm')->with(['succ_msg' => 'Successfully Add Masalah Ukm']);
    }

    public function update(Request $req){
        $masalah = new MasalahUkm();
        $data = [
            'ID' => $req->input('id'),
            'NAMA_MASALAH_UKM'  => strip_tags($req->input('nama_masalah_ukm'))
        ];
        // dd($data);
        $masalah->updateMU($data, $data['ID']);
        return redirect('ukm/masalah_ukm')->with(['succ_msg' => 'Successfully edit Masalah Ukm']);
    }

    public function delete(Request $req){
        $masalah = new MasalahUkm();
        $data = $req->input('id');
        // dd($data);
        $masalah->deleteMU($data);
        return redirect('ukm/masalah_ukm')->with(['succ_msg' => 'Successfully delete Masalah Ukm']);
    }
}
