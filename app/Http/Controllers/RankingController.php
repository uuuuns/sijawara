<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RankingController extends Controller
{
    public function index()
    {
        $data['title'] = "Top 10 User Teraktif";
		DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $data['ranking'] = DB::select("
            SELECT
                u.ID_USER,
                u.NAME,
                u.EMAIL,
                u.JENIS_INSTANSI,
                u.NAMA_INSTANSI,
                CASE 
                    WHEN u.JENIS_INSTANSI = 'UKM' THEN mku.NAMA_KATEGORI_UKM
                    WHEN u.JENIS_INSTANSI = 'KOPERASI' THEN mjk.NAMA
                    WHEN u.JENIS_INSTANSI = 'KOPERASI;UKM' THEN CONCAT(mjk.NAMA, ' & ', mku.NAMA_KATEGORI_UKM)
                    WHEN u.JENIS_INSTANSI = 'UKM;KOPERASI' THEN CONCAT(mku.NAMA_KATEGORI_UKM, ' & ', mjk.NAMA)
                    ELSE u.JENIS_INSTANSI
                END AS KATEGORI,
                COUNT(o.ID_ORDER) AS TOTAL_AKTIVITAS
            FROM
                user u
            LEFT JOIN `order` o ON 
                o.ID_USER = u.ID_USER
            LEFT JOIN activity a ON 
                a.ID_ACTIVITY = o.ID_PRODUCT 
            LEFT JOIN tb_ukm tu ON 
                tu.ID_USER = u.ID_USER
            LEFT JOIN md_kategori_ukm mku ON 
                mku.ID = tu.id_kategori_ukm
            LEFT JOIN tb_koperasi tk ON 
                tk.ID_USER = u.ID_USER
            LEFT JOIN md_jenis_koperasi mjk ON 
                mjk.ID = tk.id_jenis_koperasi 
            WHERE
                u.ID_USER != 'USR_DMNb4b'
                AND a.ID_ACTIVITY IS NOT NULL
            GROUP BY
                u.ID_USER
            ORDER BY
                TOTAL_AKTIVITAS DESC
            LIMIT 10;
        ");

        return
            view('template.header', $data) .
            view('template_admin/ranking_user', $data) .
            view('template.footer', $data);
    }
    public function filter_jenis_instansi(Request $request)
    {
        try {
            if (!empty($request->jenis)) {
                $jenisInstansi = "AND u.JENIS_INSTANSI LIKE :jenisInstansi";
            } else {
                $jenisInstansi = "";
            }
            
            DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
            
            $query = "
                SELECT
                    u.ID_USER,
                    u.NAME,
                    u.EMAIL,
                    u.JENIS_INSTANSI,
                    u.NAMA_INSTANSI,
                    CASE 
                        WHEN u.JENIS_INSTANSI = 'UKM' THEN mku.NAMA_KATEGORI_UKM
                        WHEN u.JENIS_INSTANSI = 'KOPERASI' THEN mjk.NAMA
                        WHEN u.JENIS_INSTANSI = 'KOPERASI;UKM' THEN CONCAT(mjk.NAMA, ' & ', mku.NAMA_KATEGORI_UKM)
                        WHEN u.JENIS_INSTANSI = 'UKM;KOPERASI' THEN CONCAT(mku.NAMA_KATEGORI_UKM, ' & ', mjk.NAMA)
                        ELSE u.JENIS_INSTANSI
                    END AS KATEGORI,
                    COUNT(o.ID_ORDER) AS TOTAL_AKTIVITAS
                FROM
                    user u
                LEFT JOIN `order` o ON 
                    o.ID_USER = u.ID_USER
                LEFT JOIN activity a ON 
                    a.ID_ACTIVITY = o.ID_PRODUCT 
                LEFT JOIN tb_ukm tu ON 
                    tu.ID_USER = u.ID_USER
                LEFT JOIN md_kategori_ukm mku ON 
                    mku.ID = tu.id_kategori_ukm
                LEFT JOIN tb_koperasi tk ON 
                    tk.ID_USER = u.ID_USER
                LEFT JOIN md_jenis_koperasi mjk ON 
                    mjk.ID = tk.id_jenis_koperasi 
                WHERE
                    u.ID_USER != 'USR_DMNb4b'
                    AND a.ID_ACTIVITY IS NOT NULL
                    $jenisInstansi
                GROUP BY
                    u.ID_USER
                ORDER BY
                    TOTAL_AKTIVITAS DESC
                LIMIT 10
            ";
            
            // Use bindings to prevent SQL injection
            $bindings = [];
            if (!empty($request->jenis)) {
                $bindings['jenisInstansi'] = '%' . $request->jenis . '%';
            }
            
            $data['ranking'] = DB::select($query, $bindings);
            

            // Build HTML
            $html = "";
            foreach ($data['ranking'] as $key => $item) {
                $html .= "
                <tr>
                    <td>" . ($key + 1) . "</td>
                    <td>" . htmlspecialchars($item->NAME) . "</td>
                    <td>" . htmlspecialchars($item->EMAIL) . "</td>
                    <td>" . htmlspecialchars(implode(' & ', explode(';', $item->JENIS_INSTANSI))) . "</td>
                    <td>" . ($item->NAMA_INSTANSI 
                                ? htmlspecialchars($item->NAMA_INSTANSI) 
                                : '<span class="badge bg-warning">Belum Mengisi</span>') . "</td>
                    <td>" . 
                        (($item->JENIS_INSTANSI != 'KOPERASI' && $item->JENIS_INSTANSI != 'UKM' && $item->JENIS_INSTANSI != 'KOPERASI;UKM' & $item->JENIS_INSTANSI != 'UKM;KOPERASI') 
                            ? htmlspecialchars($item->JENIS_INSTANSI) 
                            : (empty($item->KATEGORI) 
                                ? '<span class="badge bg-warning">Belum Mengisi</span>' 
                                : htmlspecialchars($item->KATEGORI))) . "
                    </td>
                    <td>" . htmlspecialchars($item->TOTAL_AKTIVITAS) . "</td>
                    <td>
                        <div class=\"d-flex flex-column gap-2\">
                            <button type=\"button\" onclick=\"location.href='user/detail_pengambilan?id_user=" . htmlspecialchars($item->ID_USER) . "'\" style=\"min-width: 155px !important;\" class=\"btn btn-dark btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2\">
                                <i class=\"bx bx-list-ul font-size-16 align-middle\"></i> Lihat Aktivitas User
                            </button>
                        </div>
                    </td>
                </tr>";
            }
            
            //Get Data Kategori UKM or Koperasi
            $filterKategori = "";
            if ($request->jenis == 'UKM') {
                $filterKategori = "Filter: 
                                    <select class=\"form-control select-category\" name=\"filterKategori\" id=\"filterKategori\" onchange=\"filterKategori(this.value)\">
                                        <option value=>Pilih Kategori...</option>";
                $dataKategori = DB::select("
                    SELECT
                        *
                    FROM
                        md_kategori_ukm
                ");

                foreach ($dataKategori as $key => $item) {
                    $filterKategori .= "
                        <option value=\"".htmlspecialchars($item->ID)."\">".htmlspecialchars($item->NAMA_KATEGORI_UKM)."</option>";
                }
                $filterKategori .= "</select>";
            }else if ($request->jenis == 'KOPERASI') {
                $filterKategori = "Filter: 
                                    <select class=\"form-control select-category\" name=\"filterKategori\" id=\"filterKategori\" onchange=\"filterKategori(this.value)\">
                                        <option value=>Pilih Kategori...</option>";
                $dataKategori = DB::select("
                    SELECT
                        *
                    FROM
                        md_jenis_koperasi
                ");

                foreach ($dataKategori as $key => $item) {
                    $filterKategori .= "
                        <option value=\"".htmlspecialchars($item->ID)."\">".htmlspecialchars($item->NAMA)."</option>";
                }
                $filterKategori .= "</select>";
            }
            
            return response()->json(['html' => $html, 'filterKategori' => $filterKategori]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e
            ], 422);
        }
    }
    public function filter_kategori(Request $request)
    {
        try {
            if (!empty($request->jenis)) {
                if ($request->jenis == 'UKM' || $request->jenis == 'KOPERASI') {
                    $jenisInstansi = "AND (u.JENIS_INSTANSI LIKE '%" . $request->jenis . "%' AND " . 
                                     ($request->jenis == 'UKM' ? 'mku.ID' : 'mjk.ID') . " = '" . $request->kategori . "')";
                } else {
                    $jenisInstansi = "AND u.JENIS_INSTANSI LIKE '%" . $request->jenis . "%'";
                }
            } else {
                $jenisInstansi = ""; // No filter if $request->jenis is empty
            }
            DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
            $data['ranking'] = DB::select("
                SELECT
                    u.ID_USER,
                    u.NAME,
                    u.EMAIL,
                    u.JENIS_INSTANSI,
                    u.NAMA_INSTANSI,
                    CASE 
                        WHEN u.JENIS_INSTANSI = 'UKM' THEN mku.NAMA_KATEGORI_UKM
                        WHEN u.JENIS_INSTANSI = 'KOPERASI' THEN mjk.NAMA
                        WHEN u.JENIS_INSTANSI = 'KOPERASI;UKM' THEN CONCAT(mjk.NAMA, ' & ', mku.NAMA_KATEGORI_UKM)
                        WHEN u.JENIS_INSTANSI = 'UKM;KOPERASI' THEN CONCAT(mku.NAMA_KATEGORI_UKM, ' & ', mjk.NAMA)
                        ELSE u.JENIS_INSTANSI
                    END AS KATEGORI,
                    COUNT(o.ID_ORDER) AS TOTAL_AKTIVITAS
                FROM
                    user u
                LEFT JOIN `order` o ON 
                    o.ID_USER = u.ID_USER
                LEFT JOIN activity a ON 
                    a.ID_ACTIVITY = o.ID_PRODUCT 
                LEFT JOIN tb_ukm tu ON 
                    tu.ID_USER = u.ID_USER
                LEFT JOIN md_kategori_ukm mku ON 
                    mku.ID = tu.id_kategori_ukm
                LEFT JOIN tb_koperasi tk ON 
                    tk.ID_USER = u.ID_USER
                LEFT JOIN md_jenis_koperasi mjk ON 
                    mjk.ID = tk.id_jenis_koperasi 
                WHERE
                    u.ID_USER != 'USR_DMNb4b'
                    AND a.ID_ACTIVITY IS NOT NULL
                    ".$jenisInstansi."
                GROUP BY
                    u.ID_USER
                ORDER BY
                    TOTAL_AKTIVITAS DESC
                LIMIT 10
            ");
            // Build HTML Isi tabel
            $html = "";
            foreach ($data['ranking'] as $key => $item) {
                $html .= "
                <tr>
                    <td>" . ($key + 1) . "</td>
                    <td>" . htmlspecialchars($item->NAME) . "</td>
                    <td>" . htmlspecialchars($item->EMAIL) . "</td>
                    <td>" . htmlspecialchars(implode(' & ', explode(';', $item->JENIS_INSTANSI))) . "</td>
                    <td>" . ($item->NAMA_INSTANSI 
                                ? htmlspecialchars($item->NAMA_INSTANSI) 
                                : '<span class="badge bg-warning">Belum Mengisi</span>') . "</td>
                    <td>" . 
                        (($item->JENIS_INSTANSI != 'KOPERASI' && $item->JENIS_INSTANSI != 'UKM' && $item->JENIS_INSTANSI != 'KOPERASI;UKM' & $item->JENIS_INSTANSI != 'UKM;KOPERASI') 
                            ? htmlspecialchars($item->JENIS_INSTANSI) 
                            : (empty($item->KATEGORI) 
                                ? '<span class="badge bg-warning">Belum Mengisi</span>' 
                                : htmlspecialchars($item->KATEGORI))) . "
                    </td>
                    <td>" . htmlspecialchars($item->TOTAL_AKTIVITAS) . "</td>
                    <td>
                        <div class=\"d-flex flex-column gap-2\">
                            <button type=\"button\" onclick=\"location.href='user/detail_pengambilan?id_user=" . htmlspecialchars($item->ID_USER) . "'\" style=\"min-width: 155px !important;\" class=\"btn btn-dark btn-sm-2 w-100 fs-8 rounded waves-effect waves-light px-2\">
                                <i class=\"bx bx-list-ul font-size-16 align-middle\"></i> Lihat Aktivitas User
                            </button>
                        </div>
                    </td>
                </tr>";
            }

            return response()->json(['html' => $html]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'failure',
                'errors' => $e
            ], 422);
        }
    }

}
