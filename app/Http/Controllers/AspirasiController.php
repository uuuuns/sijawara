<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AspirasiController extends Controller
{
    public function index()
    {
        $data['title'] = 'Aspirasi - SIJAWARA+';
        $data['aspirasi'] = DB::select('
            SELECT
                a.*,
                u.NAME
            FROM
                tb_aspirasi a
            LEFT JOIN user u ON
                a.ID_USER = u.ID_USER
            ORDER BY
                a.created_at DESC
        ');

        return
            view('template.header', $data) .
            view('template_admin.aspirasi', $data) .
            view('template.footer', $data);

    }
}
