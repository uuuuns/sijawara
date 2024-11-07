<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin_index()
    {
        $data['title'] = 'Dashboard';
        if (session('user')[0]->get('ID_ROLE') == 1 || session('user')[0]->get('ID_ROLE') == 4){
            $data['total_revenue'] = DB::select("
                SELECT
                    SUM(t.TOT_BAYAR) AS TOTAL
                FROM
                    transaction t
            ");

            $data['total_course'] = DB::select("
                SELECT
                    COUNT(a.ID_ACTIVITY) AS TOTAL
                FROM
                    activity a
                WHERE
                    a.TYPE_ACTIVITY = 1
            ");

            $data['total_event'] = DB::select("
                SELECT
                    COUNT(a.ID_ACTIVITY) AS TOTAL
                FROM
                    activity a
                WHERE
                    a.TYPE_ACTIVITY = 2
            ");

            $data['total_user'] = DB::select("
                SELECT
                    COUNT(u.ID_USER) AS TOTAL
                FROM
                    user u
                WHERE
                    u.IS_DELETE = 0
            ");
        } else {
            $data['total_revenue'] = DB::select("
                SELECT
                    SUM(t.TOT_bayar) AS TOTAL
                FROM
                    transaction t
                WHERE
                    t.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
                
            ");

            $data['total_course'] = DB::select("
                SELECT
                    COUNT(a.ID_ACTIVITY) AS TOTAL
                FROM
                    activity a
                WHERE
                    a.TYPE_ACTIVITY = 1
                    AND a.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
            ");

            $data['total_event'] = DB::select("
                SELECT
                    COUNT(a.ID_ACTIVITY) AS TOTAL
                FROM
                    activity a
                WHERE
                    a.ID_USER = '" . session('user')[0]->get('ID_USER') . "'
                    AND a.TYPE_ACTIVITY = 2
            ");
        }
            $data['admin'] = true;
        return
            view('template.header', $data) .
            view('template_admin/dashboard', $data) .
            view('template.footer', $data);
    }

    public function jadikanAdmin(Request $request) {
        $id_user = $request->input('id_user');

        DB::table('user')
            ->where('ID_USER', $id_user)
            ->update(['ID_ROLE' => 4]);

        return redirect()->back();
    }
    public function jadikanInstruktur(Request $request) {
        $id_user = $request->input('id_user');

        DB::table('user')
            ->where('ID_USER', $id_user)
            ->update(['ID_ROLE' => 2]);

        return redirect()->back();
    }

    public function get_data_chart() {
        $data['register_per_month'] = DB::select("
            SELECT 
                COUNT(u.ID_USER) AS TOTAL,
                MONTHNAME(u.REG_TIME) AS MONTH
            FROM 
                user u 
            WHERE 
                u.IS_DELETE = 0 
            GROUP BY 
                MONTHNAME(u.REG_TIME)
            ORDER BY 
                MONTH(u.REG_TIME) ASC
        ");
        
        $months = [];
        $registerCounts = [];

        foreach ($data['register_per_month'] as $row) {
            $months[] = strtoupper(substr($row->MONTH, 0, 3));  // Get the first 3 characters of the month name
            $registerCounts[] = $row->TOTAL;
        }

        return response()->json([
            'months' => $months,
            'register_per_month' => $registerCounts
        ]);
    }
    public function statistik_index() {
        $data['title'] = 'Statistik';

            $data['total_user'] = DB::select("
                SELECT
                    COUNT(u.ID_USER) AS TOTAL
                FROM
                    user u
                WHERE
                    u.IS_DELETE = 0
            ");

            $data['provinsi'] = DB::select("
                SELECT
                    *
                FROM
                    md_provinsi
            ");
        return
            view('template.header', $data) .
            view('template_admin/statistik', $data) .
            view('template.footer', $data);
    }
    public function statistik_per_provinsi(Request $req) {
        $id_provinsi = $req->id_provinsi;

        if ($id_provinsi == 99) {
            DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
            $data['provinsi'] = DB::select("
                SELECT
                    p.nama_province AS PROVINSI,
                    COUNT(u.ID_USER) AS TOTAL
                FROM
                    user u
                JOIN md_provinsi p ON
                    u.ID_PROVINSI = p.id_provinsi
                WHERE
                    u.IS_DELETE != 1
                    AND u.STATUS = 1
                GROUP BY
                    u.ID_PROVINSI
                ORDER by
                    TOTAL DESC
            ");
            $chartData = [
                'labels' => [],
                'data' => [],
                'jenis_chart' => 'bar'
            ];
            
            $chartData['Total'] = array_sum(array_column($data['provinsi'], 'TOTAL'));
            
            foreach ($data['provinsi'] as $prov) {
                if ($prov->TOTAL > 0) {
                    $chartData['labels'][] = $prov->PROVINSI;   // Adding city names to labels
                    $chartData['data'][] = $prov->TOTAL;    // Adding user totals to data array
                }
            };
        } else {
            DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
            $data['provinsi'] = DB::select("
                SELECT
                    k.nama_kota AS KOTA,
                    COUNT(u.ID_USER) AS TOTAL
                FROM
                    user u
                JOIN md_provinsi p ON
                    u.ID_PROVINSI = p.id_provinsi
                JOIN md_kota k ON
                    u.ID_KOTA = k.id_kota
                WHERE
                    u.IS_DELETE != 1
                    AND u.STATUS = 1
                    AND u.ID_PROVINSI = $id_provinsi
                GROUP BY
                    u.ID_KOTA
                ORDER by
                    TOTAL DESC
            ");
            
            $chartData = [
                'labels' => [],
                'data' => [],
                'jenis_chart' => 'pie'
            ];
            
            $chartData['Total'] = array_sum(array_column($data['provinsi'], 'TOTAL'));
            
            foreach ($data['provinsi'] as $prov) {
                $chartData['labels'][] = $prov->KOTA;   // Adding city names to labels
                $chartData['data'][] = $prov->TOTAL;    // Adding user totals to data array
            }
        }
        return response()->json($chartData);
    }

    public function statistik_kategori_index() {
        $data['title'] = 'Statistik Per Kategori';

        return
            view('template.header', $data) .
            view('template_admin/statistik_kategori', $data) .
            view('template.footer', $data);
    }

    public function get_data_chart_kategori() {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $data['per_kategori'] = DB::select("
            SELECT
                k.KATEGORI,
                COUNT(o.ID_USER) AS TOTAL
            FROM
                `order` o
            LEFT JOIN activity a ON
                a.ID_ACTIVITY = o.ID_PRODUCT 
            LEFT JOIN course c ON
                c.ID_ACTIVITY = a.ID_ACTIVITY 
            LEFT JOIN kategori k ON
                k.ID_KATEGORI = c.KATEGORI
            WHERE 
                a.TYPE_ACTIVITY = 1
            GROUP BY k.ID_KATEGORI 
            ORDER BY TOTAL DESC
        ");
        $chartData = [
            'labels' => [],
            'data' => [],
        ];

        $chartData['Total'] = array_sum(array_column($data['per_kategori'], 'COUNT(o.ID_USER)'));

        foreach ($data['per_kategori'] as $kategori) {
            $chartData['labels'][] = $kategori->KATEGORI;   // Adding city names to labels
            $chartData['data'][] = $kategori->TOTAL;    // Adding user totals to data array
        }

        return response()->json($chartData);
    }
}
