<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PromoController extends Controller
{
    public function index()
    {
        $data['title'] = "Promo";

        $data["promo"] = DB::select("
            SELECT
                p.*
            FROM
                promo p
        ");

        return
            view('template.header', $data) .
            view('template_admin/promo', $data) .
            view('template.footer', $data);
    }

    public function store(Request $req)
    {
        $data = [
            'PROMO_NAME'    => $req->input('promo_name'),
            'AMMOUNT'       => $req->input('discount'),
            'EXP_DATE'      => $req->input('exp_date'),
            'LOG_TIME'      => date('Y-m-d H:i:s')
        ];

        DB::table('promo')->insert($data);

        return redirect('promo')->with('succ_msg', 'Berhasil menambahkan promo baru');
    }

    public function update(Request $req)
    {
        $data = [
            'PROMO_NAME'    => $req->input('up_promo_name'),
            'AMMOUNT'       => $req->input('up_discount'),
            'EXP_DATE'      => $req->input('up_exp_date'),
            'LOG_TIME'      => date('Y-m-d H:i:s')
        ];

        DB::table('promo')->WHERE('ID_PROMO', '=', $req->input('up_id_promo'))->update($data);

        return redirect('promo')->with('succ_msg', 'Berhasil memperbarui promo');
    }

    public function delete(Request $req)
    {

        DB::table('promo')->WHERE('ID_PROMO', '=', $req->input('id_promo'))->delete();

        return redirect('promo')->with('succ_msg', 'Berhasil memperbarui promo');
    }
}
