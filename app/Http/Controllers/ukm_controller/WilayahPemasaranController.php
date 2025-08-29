<?php

namespace App\Http\Controllers\ukm_controller;

use App\Http\Controllers\Controller;
use App\Models\WilayahPemasaran;
use Illuminate\Http\Request;

class WilayahPemasaranController extends Controller
{
    public function index(){
        $wilayah = new WilayahPemasaran();
        $data['title'] = "Wilayah Pemasaran";
        $data['wilayah'] = $wilayah->get_all_data();

        return
            view('template.header', $data) .
            view('template_admin/master_data/ukm/wilayah_pemasaran', $data) .
            view('template.footer', $data);

    }

    public function store(Request $req){
        $wilayah = new WilayahPemasaran();
        $data = [
            'NAMA_WILAYAH_PEMASARAN'  => strip_tags($req->input('add_nama_wilayah_pemasaran'))
        ];
        
        $wilayah->insertWP($data);
        return redirect('ukm/wilayah_pemasaran')->with(['succ_msg' => 'Successfully Add Wilayah Pemasaran']);
    }

    public function update(Request $req){
        $wilayah = new WilayahPemasaran();
        $data = [
            'ID' => $req->input('id'),
            'NAMA_WILAYAH_PEMASARAN'  => strip_tags($req->input('nama_wilayah_pemasaran'))
        ];
        
        $wilayah->updateWP($data, $data['ID']);
        return redirect('ukm/wilayah_pemasaran')->with(['succ_msg' => 'Successfully edit Wilayah Pemasaran']);
    }

    public function delete(Request $req){
        $wilayah = new WilayahPemasaran();
        $data = $req->input('id');
        
        $wilayah->deleteWP($data);
        return redirect('ukm/wilayah_pemasaran')->with(['succ_msg' => 'Successfully delete Wilayah Pemasaran']);
    }
}
