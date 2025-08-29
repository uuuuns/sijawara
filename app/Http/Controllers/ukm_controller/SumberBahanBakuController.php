<?php

namespace App\Http\Controllers\ukm_controller;

use App\Http\Controllers\Controller;
use App\Models\SumberBahanBaku;
use Illuminate\Http\Request;

class SumberBahanBakuController extends Controller
{
    public function index(){
        $sumber = new SumberBahanBaku();
        $data['title'] = "Sumber Bahan Baku";
        $data['sumber'] = $sumber->get_all_data();

        return
            view('template.header', $data) .
            view('template_admin/master_data/ukm/sumber_bahanbaku', $data) .
            view('template.footer', $data);

    }

    public function store(Request $req){
        $sumber = new SumberBahanBaku();
        $data = [
            'NAMA_SUMBER_BAHAN_BAKU'  => strip_tags($req->input('add_nama_sumber_bahanbaku'))
        ];
        
        $sumber->insertSB($data);
        return redirect('ukm/sumber_bahanbaku')->with(['succ_msg' => 'Successfully Add Sumber Bahan Baku']);
    }

    public function update(Request $req){
        $sumber = new SumberBahanBaku();
        $data = [
            'ID' => $req->input('id'),
            'NAMA_SUMBER_BAHAN_BAKU'  => strip_tags($req->input('nama_sumber_bahanbaku'))
        ];
        
        $sumber->updateSB($data, $data['ID']);
        return redirect('ukm/sumber_bahanbaku')->with(['succ_msg' => 'Successfully edit Sumber Bahan Baku']);
    }

    public function delete(Request $req){
        $sumber = new SumberBahanBaku();
        $data = $req->input('id');
        
        $sumber->deleteSB($data);
        return redirect('ukm/sumber_bahanbaku')->with(['succ_msg' => 'Successfully delete Sumber Bahan Baku']);
    }
}
