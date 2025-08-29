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
    public function index_bentuk()
    {
        $data['title'] = "Bentuk Koperasi - SIJAWARA+";

        $data["bentuk_koperasi"] = DB::select("
            SELECT
                bk.*
            FROM
                md_bentuk_koperasi bk
        ");   
        $data['admin'] = true;

        return
            view('template.header', $data) .
            view('template_admin/master_data/bentuk_koperasi', $data) .
            view('template.footer', $data);
    }    
    public function store_bentuk(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('nama_bentuk')
        ];

        DB::table('md_bentuk_koperasi')->INSERT($data);

        return redirect('bentuk')->with(['msg' => 'Berhasil Menambahkan Nama Bentuk', 'location' => 'bentuk']);
    }
    public function update_bentuk(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('up_bentuk')
        ];

        DB::table('md_bentuk_koperasi')->WHERE(['ID' => $req->input('up_id_bentuk')])->update($data);

        return redirect('bentuk')->with(['msg' => 'Berhasil Mengubah Bentuk', 'location' => 'bentuk']);
    }
    public function delete_bentuk(Request $req)
    {
        DB::table('md_bentuk_koperasi')->WHERE(['ID' => $req->input('del_id_bentuk')])->delete();

        return redirect('bentuk')->with(['msg' => 'Berhasil Menghapus Bentuk', 'location' => 'bentuk']);
    }
    
    public function index_jenis()
    {
        $data['title'] = "Jenis Koperasi - SIJAWARA+";

        $data["jenis_koperasi"] = DB::select("
            SELECT
                jk.*
            FROM
                md_jenis_koperasi jk
        ");   
        $data['admin'] = true;

        return
            view('template.header', $data) .
            view('template_admin/master_data/jenis_koperasi', $data) .
            view('template.footer', $data);
    }
    public function store_jenis(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('jenis_koperasi')
        ];

        DB::table('md_jenis_koperasi')->INSERT($data);

        return redirect('jenis')->with(['msg' => 'Berhasil Menambahkan Nama Jenis', 'location' => 'jenis']);
    }
    public function update_jenis(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('up_jenis')
        ];

        DB::table('md_jenis_koperasi')->WHERE(['ID' => $req->input('up_id_jenis')])->update($data);

        return redirect('jenis')->with(['msg' => 'Berhasil Mengubah Jenis', 'location' => 'jenis']);
    }
    public function delete_jenis(Request $req)
    {
        DB::table('md_jenis_koperasi')->WHERE(['ID' => $req->input('del_id_jenis')])->delete();

        return redirect('jenis')->with(['msg' => 'Berhasil Menghapus Jenis', 'location' => 'jenis']);
    }

    public function index_kelompok()
    {
        $data['title'] = "Kelompok Koperasi - SIJAWARA+";

        $data["kelompok_koperasi"] = DB::select("
            SELECT
                kk.*
            FROM
                md_kelompok_koperasi kk
        ");   
        $data['admin'] = true;
        // Kirim data ke view
        return
            view('template.header', $data) .
            view('template_admin/master_data/kelompok_koperasi', $data) .
            view('template.footer', $data);
    }
    public function store_kelompok(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('kelompok_koperasi')
        ];

        DB::table('md_kelompok_koperasi')->INSERT($data);

        return redirect('kelompok')->with(['msg' => 'Berhasil Menambahkan Nama Kelompok', 'location' => 'kelompok']);
    }
    public function update_kelompok(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('up_kelompok')
        ];

        DB::table('md_kelompok_koperasi')->WHERE(['ID' => $req->input('up_id_kelompok')])->update($data);

        return redirect('kelompok')->with(['msg' => 'Berhasil Mengubah Kelompok', 'location' => 'kelompok']);
    }
    public function delete_kelompok(Request $req)
    {
        DB::table('md_kelompok_koperasi')->WHERE(['ID' => $req->input('del_id_kelompok')])->delete();

        return redirect('kelompok')->with(['msg' => 'Berhasil Menghapus Kelompok', 'location' => 'kelompok']);
    }

    public function index_masalah()
    {
        $data['title'] = "Masalah Koperasi - SIJAWARA+";

        $data["masalah_koperasi"] = DB::select("
            SELECT
                mk.*
            FROM
                md_masalah_koperasi mk
        ");   
        $data['admin'] = true;
        // Kirim data ke view
        return
            view('template.header', $data) .
            view('template_admin/master_data/masalah_koperasi', $data) .
            view('template.footer', $data);
    }
    public function store_masalah(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('masalah_koperasi')
        ];

        DB::table('md_masalah_koperasi')->INSERT($data);

        return redirect('masalah')->with(['msg' => 'Berhasil Menambahkan Nama Masalah', 'location' => 'masalah']);
    }
    public function update_masalah(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('up_masalah')
        ];

        DB::table('md_masalah_koperasi')->WHERE(['ID' => $req->input('up_id_masalah')])->update($data);

        return redirect('masalah')->with(['msg' => 'Berhasil Mengubah Masalah', 'location' => 'masalah']);
    }
    public function delete_masalah(Request $req)
    {
        DB::table('md_masalah_koperasi')->WHERE(['ID' => $req->input('del_id_masalah')])->delete();

        return redirect('masalah')->with(['msg' => 'Berhasil Menghapus Masalah', 'location' => 'masalah']);
    }

    public function index_sektor()
    {
        $data['title'] = "Sektor Usaha - SIJAWARA+";

        $data["sektor_usaha"] = DB::select("
            SELECT
                su.*
            FROM
                md_sektor_usaha su
        ");   
        $data['admin'] = true;
        
        return
            view('template.header', $data) .
            view('template_admin/master_data/sektor_usaha', $data) .
            view('template.footer', $data);
    }
    public function store_sektor(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('sektor_usaha')
        ];

        DB::table('md_sektor_usaha')->INSERT($data);

        return redirect('sektor')->with(['msg' => 'Berhasil Menambahkan Nama Sektor', 'location' => 'sektor']);
    }
    public function update_sektor(Request $req)
    {
        $data = [
            'NAMA'  => $req->input('up_sektor')
        ];

        DB::table('md_sektor_usaha')->WHERE(['ID' => $req->input('up_id_sektor')])->update($data);

        return redirect('sektor')->with(['msg' => 'Berhasil Mengubah Sektor', 'location' => 'sektor']);
    }
    public function delete_sektor(Request $req)
    {
        DB::table('md_sektor_usaha')->WHERE(['ID' => $req->input('del_id_sektor')])->delete();

        return redirect('sektor')->with(['msg' => 'Berhasil Menghapus Sektor', 'location' => 'sektor']);
    }
}
