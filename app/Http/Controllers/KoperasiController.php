<?php

namespace App\Http\Controllers;

use App\Models\BentukKoperasi;
use App\Models\JenisKoperasi;
use App\Models\KelompokKoperasi;
use App\Models\MasalahKoperasi;
use App\Models\MasalanKoperasi;
use App\Models\SektorUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KoperasiController extends Controller
{
    // Bentuk Controller
    public function index_bentuk()
    {
        $data['title'] = "Bentuk Koperasi";

        $data["bentuk_koperasi"] = DB::select("
            SELECT
                bk.*
            FROM
                md_bentuk_koperasi bk
        ");   

        // Kirim data ke view
        return
        view('template_main.admin_side.etc.header', $data) .
        view('template_main.admin_side.etc.sidebar', $data) .
        view('template_main.admin_side.master_data.bentuk_koperasi', $data) .
        view('template_main.admin_side.etc.footer');
    }    
    public function store_bentuk(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('nama_bentuk')
        ];

        DB::table('md_bentuk_koperasi')->INSERT($data);

        return redirect('bentuk')->with(['succ_msg' => 'Berhasil Menambahkan Nama Bentuk', 'location' => 'bentuk']);
    }
    public function update_bentuk(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('up_bentuk')
        ];

        DB::table('md_bentuk_koperasi')->WHERE(['ID' => $req->input('up_id_bentuk')])->update($data);

        return redirect('bentuk')->with(['succ_msg' => 'Berhasil Mengubah Bentuk', 'location' => 'bentuk']);
    }
    public function delete_bentuk(Request $req)
    {
        DB::table('md_bentuk_koperasi')->WHERE(['ID' => $req->input('del_id_bentuk')])->delete();

        return redirect('bentuk')->with(['succ_msg' => 'Berhasil Menghapus Bentuk', 'location' => 'bentuk']);
    }
    
    public function index_jenis()
    {
        // Ambil semua data dari model JenisKoperasi
        $jenisKoperasi = JenisKoperasi::all();

        // Kirim data ke view
        return view('jenis_koperasi.index', ['jenisKoperasis' => $jenisKoperasi]);
    }
    public function store_jenis()
    {

    }
    public function update_jenis()
    {

    }
    public function delete_jenis()
    {

    }

    public function index_kelompok()
    {
        // Ambil semua data dari model KelompokKoperasi
        $kelompokKoperasi = KelompokKoperasi::all();

        // Kirim data ke view
        return view('kelompok_koperasi.index', ['bentukKoperasis' => $kelompokKoperasi]);
    }
    public function store_kelompok()
    {

    }
    public function update_kelompok()
    {

    }
    public function delete_kelompok()
    {

    }

    public function index_masalah()
    {
        // Ambil semua data dari model BentukKoperasi
        $masalahKoperasi = MasalahKoperasi::all();

        // Kirim data ke view
        return view('masalah_koperasi.index', ['bentukKoperasis' => $masalahKoperasi]);
    }
    public function store_masalah()
    {

    }
    public function update_masalah()
    {

    }
    public function delete_masalah()
    {

    }

    public function index_sektor()
    {
        // Ambil semua data dari model BentukKoperasi
        $sektorUsaha = SektorUsaha::all();

        // Kirim data ke view
        return view('sektor_usaha.index', ['bentukKoperasis' => $sektorUsaha]);
    }
    public function store_sektor()
    {

    }
    public function update_sektor()
    {

    }
    public function delete_sektor()
    {

    }
}
