<?php

namespace App\Http\Controllers\ukm_controller;

use App\Http\Controllers\Controller;
use App\Models\KategoriUkm;
use Illuminate\Http\Request;

class KategoriUkmController extends Controller
{
    //
    public function index(){
        $kategori = new KategoriUkm();
        $data['title'] = "Kategori UKM";
        $data['kategori'] = $kategori->get_all_data();
        // dd($data['usaha']);
        return
            view('template.header', $data) .
            view('template_admin/master_data/ukm/kategori_ukm', $data) .
            view('template.footer', $data);

    }

    public function store(Request $req){
        $kategori = new KategoriUkm();
        $data = [
            'NAMA_KATEGORI_UKM'  => strip_tags($req->input('add_nama_kategori_ukm'))
        ];
        // dd($data);
        $kategori->insertKU($data);
        return redirect('ukm/kategori_ukm')->with(['succ_msg' => 'Successfully Add Kategori UKM']);
    }

    public function update(Request $req){
        $kategori = new KategoriUkm();
        $data = [
            'ID' => $req->input('id'),
            'NAMA_KATEGORI_UKM'  => strip_tags($req->input('nama_kategori_ukm'))
        ];
        // dd($data);
        $kategori->updateKU($data, $data['ID']);
        return redirect('ukm/kategori_ukm')->with(['succ_msg' => 'Successfully edit Kategori UKM']);
    }

    public function delete(Request $req){
        $kategori = new KategoriUkm();
        $data = $req->input('id');
        // dd($data);
        $kategori->deleteKU($data);
        return redirect('ukm/kategori_ukm')->with(['succ_msg' => 'Successfully delete Kategori UKM']);
    }
}
