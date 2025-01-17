<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
    public function statistik_per_kota(Request $req) {
        $kota = $req->id_kota;
    
        // Disable ONLY_FULL_GROUP_BY for the session
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
    
        // Fetch raw data from the database
        $data['kota'] = DB::select("
            SELECT
                k.nama_kota AS KOTA,
                u.JENIS_INSTANSI
            FROM
                user u
            JOIN md_provinsi p ON
                u.ID_PROVINSI = p.id_provinsi
            JOIN md_kota k ON
                u.ID_KOTA = k.id_kota
            WHERE
                u.IS_DELETE != 1
                AND u.JENIS_INSTANSI IS NOT NULL
                AND u.STATUS = 1
                AND u.ID_KOTA = $kota
        ");
    
        // Initialize arrays to process data
        $jenisInstansiTotals = [];
        $kotaName = isset($data['kota'][0]) ? $data['kota'][0]->KOTA : '';
    
        foreach ($data['kota'] as $kota) {
            // Split JENIS_INSTANSI by ";" and process each value
            $jenisInstansiList = explode(';', $kota->JENIS_INSTANSI);
    
            foreach ($jenisInstansiList as $jenisInstansi) {
                $jenisInstansi = trim($jenisInstansi); // Remove extra spaces
                if (!empty($jenisInstansi)) {
                    // Aggregate the total count for each JENIS_INSTANSI
                    if (!isset($jenisInstansiTotals[$jenisInstansi])) {
                        $jenisInstansiTotals[$jenisInstansi] = 0;
                    }
                    $jenisInstansiTotals[$jenisInstansi]++;
                }
            }
        }
    
        // Prepare chart data
        $chartData = [
            'labels' => array_keys($jenisInstansiTotals),
            'data' => array_values($jenisInstansiTotals),
            'kota' => $kotaName,
        ];
    
        return response()->json($chartData);
    }
    
    public function statistik_kategori_index() {
        $data['title'] = 'Statistik Per Kategori';
    
        $dataKursus = DB::select("
            SELECT
                a.TITLE_ACTIVITY,
                COUNT(o.ID_USER) AS Total_user,
                COUNT(CASE WHEN o.COURSE_COMPLETED = 1 THEN 1 END) AS Total_complete,
                COUNT(o.ID_USER) - COUNT(CASE WHEN o.COURSE_COMPLETED = 1 THEN 1 END) AS Total_not_complete
            FROM
                activity a 
            LEFT JOIN `order` o ON
                o.ID_PRODUCT = a.ID_ACTIVITY
            WHERE     
                a.TYPE_ACTIVITY = 1
            GROUP BY 
                a.TITLE_ACTIVITY
            HAVING 
                Total_user != 0
            ORDER BY
                Total_user DESC
            LIMIT 10
        ");
    
        // Prepare data for Chart.js
        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Total Peserta',
                    'data' => [],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Total Peserta Belum Selesai',
                    'data' => [],
                    'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                    'borderColor' => 'rgba(255, 206, 86, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Total Peserta Selesai',
                    'data' => [],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
            ]
        ];
    
        // Populate labels and datasets
        foreach ($dataKursus as $row) {
            $chartData['labels'][] = Str::limit($row->TITLE_ACTIVITY, 20);
            $chartData['datasets'][0]['data'][] = $row->Total_user;
            $chartData['datasets'][1]['data'][] = $row->Total_not_complete;
            $chartData['datasets'][2]['data'][] = $row->Total_complete;
        }
    
        $data['chartData'] = json_encode($chartData); // Encode for use in JavaScript
    
        return view('template.header', $data) .
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
            $chartData['labels'][] = $kategori->KATEGORI;
            $chartData['data'][] = $kategori->TOTAL;
        }

        return response()->json($chartData);
    }
}
