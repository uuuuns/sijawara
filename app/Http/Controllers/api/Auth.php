<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\SsoService;
use Exception;
use Illuminate\Support\Facades\DB;

class Auth extends Controller
{
    protected $secret_key;
    protected $ssoService;

    public function __construct()
    {
        $this->secret_key = "niw92g6xniot7s29";
        $this->ssoService = new SsoService();
    }

    public function login(\Illuminate\Http\Request $request)
    {
        $secretKey = $request->input('secret_key', $_GET['secret_key'] ?? '');
        if ($secretKey != $this->secret_key) {
            return response([
                "status_code" => 403,
                "status_message" => "Akses ditolak!"
            ], 200);
        }

        try {
            $email = strip_tags($request->input('email', $_GET['email'] ?? ''));
            $pass = $request->input('password', $_GET['password'] ?? '');

            // Authenticate via SSO server
            $ssoResult = $this->ssoService->login($email, $pass);

            if (!$ssoResult['success']) {
                return response([
                    'status_code' => 404,
                    'status_message' => $ssoResult['message'] ?? 'Username atau password salah!',
                ], 200);
            }

            // Look up local user by email
            $user = (array) DB::selectOne('SELECT * FROM user WHERE EMAIL = ?', [$email]);

            if (empty($user)) {
                // Auto-create local user for valid SSO user
                $ssoData = $ssoResult['data']['data'] ?? $ssoResult['data'];
                $ssoUser = $ssoData['user'] ?? [];
                $KODE_USER = $this->GenerateUniqID($ssoUser['name'] ?? $email);
                $isAdmin = in_array($ssoUser['user_type'] ?? '', ['admin', 'pegawai']) || ($email === 'admin@diskopukm.jatimprov.go.id');

                $newUser = new \App\Models\User();
                $newUser->ID_USER = $KODE_USER;
                $newUser->NAME = $ssoUser['name'] ?? $email;
                $newUser->EMAIL = $email;
                $newUser->PASS = hash('sha256', md5($pass));
                $newUser->ID_ROLE = $isAdmin ? 1 : 3;
                $newUser->STATUS = 1;
                $newUser->IS_DELETE = 0;
                $newUser->REG_TIME = date('Y-m-d H:i:s');
                $newUser->JENIS_INSTANSI = 'UMUM';
                $newUser->save();

                $user = (array) DB::selectOne('SELECT * FROM user WHERE ID_USER = ?', [$KODE_USER]);
            }

            // Set legacy_sijawara_id on SSO user (best-effort)
            try {
                $ssoData = $ssoResult['data']['data'] ?? $ssoResult['data'];
                $ssoToken = $ssoData['access_token'] ?? null;
                if ($ssoToken) {
                    $this->ssoService->updateLegacyId($ssoToken, 'legacy_sijawara_id', $user['ID_USER']);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Failed to set legacy_sijawara_id for ' . $user['ID_USER'] . ': ' . $e->getMessage());
            }

            return response([
                'status_code' => 200,
                'status_message' => 'Selamat anda berhasil login!',
                'kode_user' => $user['ID_USER'],
                'id_role' => $user['ID_ROLE']
            ], 200);
        } catch (Exception $exp) {
            return response([
                'status_code' => 500,
                'status_message' => $exp->getMessage(),
            ], 200);
        }
    }

    public function register(\Illuminate\Http\Request $request)
    {
        $secretKey = $request->input('secret_key', $_GET['secret_key'] ?? '');
        if ($secretKey != $this->secret_key) {
            return response([
                "status_code" => 403,
                "status_message" => "Akses ditolak!"
            ], 200);
        }

        try {
            $nama = strip_tags($request->input('nama', $_GET['nama'] ?? ''));
            $email = strip_tags($request->input('email', $_GET['email'] ?? ''));
            $jenis_instansi = strip_tags($request->input('instansi', $_GET['instansi'] ?? ''));
            $pass = $request->input('password', $_GET['password'] ?? '');

            $check_user = DB::table('user')
                ->where('EMAIL', $email)
                ->first();
            if (empty($check_user)) {
                $KODE_USER = $this->GenerateUniqID($nama);

                // Also register in SSO server
                $ssoResult = $this->ssoService->register([
                    'name' => $nama,
                    'email' => $email,
                    'password' => $pass,
                    'user_type' => 'umum',
                ]);
                if (!$ssoResult['success']) {
                    \Illuminate\Support\Facades\Log::warning('SSO registration failed for ' . $email . ': ' . ($ssoResult['message'] ?? 'Unknown error'));
                } else {
                    // Set legacy_sijawara_id on SSO user
                    try {
                        $loginResult = $this->ssoService->login($email, $pass);
                        if ($loginResult['success']) {
                            $ssoToken = $loginResult['data']['data']['access_token'] ?? null;
                            if ($ssoToken) {
                                $this->ssoService->updateLegacyId($ssoToken, 'legacy_sijawara_id', $KODE_USER);
                            }
                        }
                    } catch (\Throwable $e) {
                        \Illuminate\Support\Facades\Log::warning('Failed to set legacy_sijawara_id for ' . $KODE_USER . ': ' . $e->getMessage());
                    }
                }

                $data_user = [
                    'ID_USER' => $KODE_USER,
                    'NAME' => $nama,
                    'EMAIL' => $email,
                    'JENIS_INSTANSI' => $jenis_instansi,
                    'PASS' => hash('sha256', md5($pass)),
                    'ID_ROLE' => 3,
                    'STATUS' => 1,
                    'REG_TIME' => date('Y-m-d H:i:s')
                ];

                DB::table('user')->insert($data_user);

                return response([
                    'status_code' => 200,
                    'status_message' => 'Selamat anda berhasil registrasi!',
                    'data_user' => $data_user
                ], 200);
            } else {
                return response([
                    'status_code' => 409,
                    'status_message' => 'Email sudah terdaftar, silahkan gunakan email lain!',
                ], 200);
            }
        } catch (Exception $exp) {
            return response([
                'status_code' => 500,
                'status_message' => $exp->getMessage(),
            ], 200);
        }
    }

    public function getDataUser()
    {
        if ($_GET["secret_key"] != $this->secret_key) {
            return response([
                "status_code" => 403,
                "status_message" => "Akses ditolak!"
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
                'status_code' => 200,
                'status_message' => 'Syncronize Berhasil!',
                'data_user' => $data_user,
            ], 200);
        } catch (Exception $exp) {
            return response([
                'status_code' => 500,
                'status_message' => $exp->getMessage(),
            ], 200);
        }
    }

    public function getUserInfo()
    {
        if ($_GET["secret_key"] != $this->secret_key) {
            return response([
                "status_code" => 403,
                "status_message" => "Akses ditolak!"
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
            ", [$ID_USER]);

            return response()->json([
                'status_code' => !empty($data_user) ? 200 : 404,
                'status_message' => !empty($data_user) ? 'Kode User ditemukan!' : 'Kode User tidak ditemukan!',
                'info_user' => $data_user ?? null,
            ], 200);
        } catch (Exception $exp) {
            return response()->json([
                'status_code' => 500,
                'status_message' => $exp->getMessage(),
            ], 200);
        }
    }

    public function GenerateUniqID($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap = str_replace($vocal, "", $string);
        $begin = strtoupper(substr($scrap, 0, 4));

        do {
            $uuid = bin2hex(random_bytes(2));
            $uniqID = "USR_" . $begin . $uuid;

            $exists = DB::table('user')->where('ID_USER', $uniqID)->exists();
        } while ($exists);
        return $uniqID;
    }
}
