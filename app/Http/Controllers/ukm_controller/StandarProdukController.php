<?php

namespace App\Http\Controllers\ukm_controller;

use App\Http\Controllers\Controller;
use App\Models\StandarProduk;
use Illuminate\Http\Request;

class StandarProdukController extends Controller
{
    //
    public function index(){
        $standar = new StandarProduk();
        $data['title'] = "Standar Produk";
        $data['standar'] = $standar->get_all_data();
        // dd($data['usaha']);
        return
            view('template.header', $data) .
            view('template_admin/master_data/ukm/standar_produk', $data) .
            view('template.footer', $data);

    }

    public function store(Request $req){
        $standar = new StandarProduk();
        $data = [
            'NAMA_STANDAR_PRODUK'  => strip_tags($req->input('add_nama_standar_produk'))
        ];
        // dd($data);
        $standar->insertSP($data);
        return redirect('ukm/standar_produk')->with(['succ_msg' => 'Successfully Add Standar Produk']);
    }

    public function update(Request $req){
        $standar = new StandarProduk();
        $data = [
            'ID' => $req->input('id'),
            'NAMA_STANDAR_PRODUK'  => strip_tags($req->input('nama_standar_produk'))
        ];
        // dd($data);
        $standar->updateSP($data, $data['ID']);
        return redirect('ukm/standar_produk')->with(['succ_msg' => 'Successfully edit Standar Produk']);
    }

    public function delete(Request $req){
        $standar = new StandarProduk();
        $data = $req->input('id');
        // dd($data);
        $standar->deleteSP($data);
        return redirect('ukm/standar_produk')->with(['succ_msg' => 'Successfully Standar Produk']);
    }
}
