<?php

namespace App\Http\Controllers\ukm_controller;

use App\Models\BadanUsaha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BadanUsahaController extends Controller
{
    public function index(){
        $usaha = new BadanUsaha();
        $data['title'] = "Badan Usaha";
        $data['usaha'] = $usaha->get_all_data();
        
        return
            view('template.header', $data) .
            view('template_admin/master_data/ukm/badan_usaha', $data) .
            view('template.footer', $data);

    }

    public function store(Request $req){
        $usaha = new BadanUsaha();
        $data = [
            'NAMA_BADAN_USAHA'  => strip_tags($req->input('add_nama_badan_usaha'))
        ];
        
        $usaha->insertBU($data);
        return redirect('ukm/badan_usaha')->with(['succ_msg' => 'Successfully Add Badan Usaha']);
    }

    public function update(Request $req){
        $usaha = new BadanUsaha();
        $data = [
            'ID' => $req->input('id'),
            'NAMA_BADAN_USAHA'  => strip_tags($req->input('nama_badan_usaha'))
        ];

        $usaha->updateBU($data, $data['ID']);
        return redirect('ukm/badan_usaha')->with(['succ_msg' => 'Successfully edit Badan Usaha']);
    }

    public function delete(Request $req){
        $usaha = new BadanUsaha();
        $data = $req->input('id');
        
        $usaha->deleteBU($data);
        return redirect('ukm/badan_usaha')->with(['succ_msg' => 'Successfully delete Badan Usaha']);
    }
}
