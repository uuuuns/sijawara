<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class Auth extends Controller
{
    protected $secret_key;

    public function __construct()
    {
        $this->secret_key = "niw92g6xniot7s29";
    }

    public function login()
    {
        if ($_GET["secret_key"] != $this->secret_key) {
            return response([
                "status_code"       => 403,
                "status_message"    => "Akses ditolak!"
            ], 200);
        }

        try {
            $email = strip_tags($_GET["email"]);
            $pass = $_GET["password"];

            $user = $this->checkLogin($email, $pass);

            if ($user == null) {
                return response([
                    'status_code'       => 404,
                    'status_message'    => 'Username atau password salah!',
                ], 200);
            }

            return response([
                'status_code'       => 200,
                'status_message'    => 'Selamat anda berhasil login!',
                'kode_user'         => $user['ID_USER']
            ], 200);
        } catch (Exception $exp) {
            return response([
                'status_code'       => 500,
                'status_message'    => $exp->getMessage(),
            ], 200);
        }
    }

    public function checkLogin($email, $password)
    {
        $conditions = [];
        $conditions[] = "u.EMAIL = '" . $email . "'";
        $conditions[] = "u.PASS = '" . $password . "'";

        $conditionWhere = "";
        if (!empty($conditions)) {
            $conditionWhere = "WHERE " . implode(" AND ", $conditions);
        }

        $dataLogin = (array)DB::selectOne("
            SELECT
                u.*
            FROM
                user u
            $conditionWhere
        ");

        if (!empty($dataLogin)) {
            return $dataLogin;
        }
        return false;
    }

    public function register()
    {
        if ($_GET["secret_key"] != $this->secret_key) {
            return response([
                "status_code"       => 403,
                "status_message"    => "Akses ditolak!"
            ], 200);
        }

        try {
            $nama = strip_tags($_GET["nama"]);
            $email = strip_tags($_GET["email"]);
            $jenis_instansi = strip_tags($_GET["instansi"]);
            $pass = $_GET["password"];

            $check_user = DB::table('user')
                ->where('EMAIL', $email)
                ->first();
            if (empty($check_user)) {
                $KODE_USER = $this->GenerateUniqID($nama);

                $data_user = [
                    'ID_USER'           => $KODE_USER,
                    'NAME'              => $nama,
                    'EMAIL'             => $email,
                    'JENIS_INSTANSI'    => $jenis_instansi,
                    'PASS'              => $pass,
                    'ID_ROLE'           => 3,
                    'STATUS'            => 1,
                    'REG_TIME'          => date('Y-m-d H:i:s')
                ];

                DB::table('user')->insert($data_user);

                return response([
                    'status_code'       => 200,
                    'status_message'    => 'Selamat anda berhasil registrasi!',
                    'data_user'         => $data_user
                ], 200);
            } else {
                return response([
                    'status_code'       => 409,
                    'status_message'    => 'Email sudah terdaftar, silahkan gunakan email lain!',
                ], 200);
            }
        } catch (Exception $exp) {
            return response([
                'status_code'       => 500,
                'status_message'    => $exp->getMessage(),
            ], 200);
        }
    }

    public function getDataUser()
    {
        if ($_GET["secret_key"] != $this->secret_key) {
            return response([
                "status_code"       => 403,
                "status_message"    => "Akses ditolak!"
            ], 200);
        }

        try {
            $data_user = DB::Select("
                SELECT
                    u.ID_USER,
                    u.NAME AS NAMA,
                    u.EMAIL,
                    u.TELP AS NO_TELP,
                    u.JK AS JENIS_KELAMIN,
                    u.FOTO_PROFILE,
                    u.NIK,
                    u.ID_ROLE,
                    u.ALAMAT,
                    u.TGL_LAHIR as TANGGAL_LAHIR,
                    u.TEMPAT_LAHIR,
                    u.NAMA_INSTANSI,
                    u.JABATAN,
                    u.JENIS_INSTANSI,
                    COALESCE(year(tk.tgl_badan_hukum), tu.tahun_mulai) AS TAHUN_BERDIRI,
                    u.STATUS,
                    k.nama_kota AS KOTA,
                    p.nama_province AS PROVINSI
                FROM
                    user u
                LEFT JOIN md_kota k ON
                    k.ID_KOTA = u.ID_KOTA
                LEFT JOIN md_provinsi p ON
                    p.ID_PROVINSI = k.ID_PROVINSI
                LEFT JOIN tb_koperasi tk ON
                    tk.ID_USER = u.ID_USER
                LEFT JOIN tb_ukm tu ON
                    tu.ID_USER = u.ID_USER
                WHERE
                    u.ID_ROLE = 3
                ORDER BY
                    u.NAME ASC
            ");

            return response([
                'status_code'       => 200,
                'status_message'    => 'Syncronize Berhasil!',
                'data_user'         => $data_user,
            ], 200);
        } catch (Exception $exp) {
            return response([
                'status_code'       => 500,
                'status_message'    => $exp->getMessage(),
            ], 200);
        }
    }

    public function getUserInfo()
    {
        if ($_GET["secret_key"] != $this->secret_key) {
            return response([
                "status_code"       => 403,
                "status_message"    => "Akses ditolak!"
            ], 200);
        }

        try {
            $ID_USER = strip_tags($_GET["id_user"]);

            $data_user = DB::Select("
                SELECT
                    u.ID_USER,
                    u.NAME AS NAMA,
                    u.EMAIL,
                    u.TELP AS NO_TELP,
                    u.JK AS JENIS_KELAMIN,
                    u.FOTO_PROFILE,
                    u.NIK,
                    u.ID_ROLE,
                    u.ALAMAT,
                    u.TGL_LAHIR as TANGGAL_LAHIR,
                    u.TEMPAT_LAHIR,
                    u.NAMA_INSTANSI,
                    u.JABATAN,
                    u.JENIS_INSTANSI,
                    COALESCE(year(tk.tgl_badan_hukum), tu.tahun_mulai) AS TAHUN_BERDIRI,
                    u.STATUS,
                    k.nama_kota AS KOTA,
                    p.nama_province AS PROVINSI
                FROM
                    user u
                LEFT JOIN md_kota k ON
                    k.ID_KOTA = u.ID_KOTA
                LEFT JOIN md_provinsi p ON
                    p.ID_PROVINSI = k.ID_PROVINSI
                LEFT JOIN tb_koperasi tk ON
                    tk.ID_USER = u.ID_USER
                LEFT JOIN tb_ukm tu ON
                    tu.ID_USER = u.ID_USER
                WHERE
                    u.ID_USER = ?
                ORDER BY
                    u.NAME ASC
            ",[$ID_USER]);

            return response([
                'status_code'       => 200,
                'status_message'    => 'Data Valid!',
                'info_user'         => $data_user,
            ], 200);
        } catch (Exception $exp) {
            return response([
                'status_code'       => 500,
                'status_message'    => $exp->getMessage(),
            ], 200);
        }
    }

    public function GenerateUniqID($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal  = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap  = str_replace($vocal, "", $string);
        $begin  = strtoupper(substr($scrap, 0, 4));

        do {
            $uuid = bin2hex(random_bytes(2));
            $uniqID = "USR_" . $begin . $uuid;

            $exists = DB::table('user')->where('ID_USER', $uniqID)->exists();
        } while ($exists);
        return $uniqID;
    }
}
