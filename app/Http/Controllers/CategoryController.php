<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index()
    {
        $data['title'] = "Category - SIJAWARA+";

        $data["category"] = DB::select("
            SELECT
                k.*
            FROM
                kategori k
        ");
        $data['admin'] = true;
        return
            view('template.header', $data) .
            view('template_admin/category', $data) .
            view('template.footer', $data);
    }

    public function store(Request $req)
    {
        $data = [
            'KATEGORI'  => $req->input('kategori')
        ];

        DB::table('kategori')->INSERT($data);

        return redirect('kategori')->with(['succ_msg' => 'Berhasil menambahkan kategori', 'location' => 'kategori']);
    }

    public function update(Request $req)
    {
        $data = [
            'KATEGORI'  => $req->input('up_kategori')
        ];

        DB::table('kategori')->WHERE(['ID_KATEGORI' => $req->input('up_id_kategori')])->update($data);

        return redirect('kategori')->with(['succ_msg' => 'Berhasil memperbarui kategori', 'location' => 'kategori']);
    }

    public function delete(Request $req)
    {
        DB::table('kategori')->WHERE(['ID_KATEGORI' => $req->input('del_id_kategori')])->delete();

        return redirect('kategori')->with(['succ_msg' => 'Berhasil menghapus kategori', 'location' => 'kategori']);
    }
}
