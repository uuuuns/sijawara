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
}
