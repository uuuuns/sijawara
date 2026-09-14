<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SsoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Mail\MailSender;
use Exception;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected $ssoService;

    public function __construct()
    {
        $this->ssoService = new SsoService();

        $smtpConfig = [
            'transport' => env('MAIL_MAILER'),
            'host' => env('MAIL_HOST'),
            'port' => env('MAIL_PORT'),
            'from' => ['address' => 'sijawara.uptkukm@gmail.com', 'name' => 'SIJAWARA+'],
            'encryption' => env('MAIL_ENCRYPTION'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
        ];
        config(['mail.mailers.smtp' => $smtpConfig]);
    }

    public function login()
    {
        // Already authenticated locally, send to dashboard
        if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 1) {
            return redirect('dashboard');
        } else if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 2) {
            return redirect('/');
        } else if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 3) {
            return redirect('/');
        } else if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 4) {
            return redirect('dashboard');
        }

        // Local login is deprecated. Redirect to SSO login.
        $ssoUrl = rtrim(env('SSO_URL', 'http://localhost:9000'), '/');
        return redirect($ssoUrl . '/login');
    }

    public function login_authentication(Request $req)
    {
        $email = $req->input('email');
        $password = $req->input('password');

        // Authenticate via SSO server
        $ssoResult = $this->ssoService->login($email, $password);

        if (!$ssoResult['success']) {
            return redirect()->back()->with('msg_auth', $ssoResult['message'] ?? 'Email atau Password Salah');
        }

        $ssoData = $ssoResult['data']['data'];
        $ssoUser = $ssoData['user'];
        $ssoToken = $ssoData['access_token'];

        // Look up local user by email
        $auth = DB::selectOne('SELECT * FROM user WHERE EMAIL = ?', [$email]);

        if ($auth == null) {
            // SSO login succeeded but no local user — create local user
            $KODE_USER = $this->GenerateUniqID($ssoUser['name'] ?? $email);
            $isAdmin = in_array($ssoUser['user_type'] ?? '', ['admin', 'pegawai']) || (($ssoUser['email'] ?? '') === 'admin@diskopukm.jatimprov.go.id');

            $localUser = new User();
            $localUser->ID_USER = $KODE_USER;
            $localUser->NAME = $ssoUser['name'] ?? $email;
            $localUser->EMAIL = $email;
            $localUser->PASS = hash('sha256', md5($password));
            $localUser->ID_ROLE = $isAdmin ? 1 : 3;
            $localUser->STATUS = 1;
            $localUser->IS_DELETE = 0;
            $localUser->REG_TIME = date('Y-m-d H:i:s');
            $localUser->JENIS_INSTANSI = 'UMUM';
            $localUser->save();

            $auth = DB::selectOne('SELECT * FROM user WHERE ID_USER = ?', [$KODE_USER]);

            // Set legacy_sijawara_id on SSO user
            try {
                $this->ssoService->updateLegacyId($ssoToken, 'legacy_sijawara_id', $KODE_USER);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Failed to set legacy_sijawara_id for ' . $KODE_USER . ': ' . $e->getMessage());
            }
        }

        if ($auth->STATUS == 0) {
            return redirect()->back()->with('resp_msg', 'Tidak bisa masuk, akun anda belum diverifikasi, harap periksa email anda');
        }
        if (isset($auth->IS_DELETE) && $auth->IS_DELETE == 1) {
            return redirect()->back()->with('error_msg', 'Tidak bisa masuk, akun anda telah di ban. Hubungi admin untuk informasi lebih lanjut');
        }

        // Check data completeness
        $mappingInstansi = [
            'KOPERASI' => 'koperasi',
            'UKM' => 'ukm',
            'INSTANSI' => 'instansi',
            'KOPERASI;UKM' => 'koperasi_ukm',
            'UKM;KOPERASI' => 'koperasi_ukm',
            'UMUM' => 'umum',
            'KDMP' => 'kdmp',
            'ADMIN' => 'admin',
        ];

        $jenisInstansi = $auth->JENIS_INSTANSI ?? 'UMUM';
        $joinCond = '';
        $instansiKey = $mappingInstansi[$jenisInstansi] ?? 'umum';
        if ($instansiKey == 'ukm') {
            $joinCond = 'LEFT JOIN tb_ukm tu ON tu.ID_USER = u.ID_USER';
        } else if ($instansiKey == 'koperasi') {
            $joinCond = 'LEFT JOIN tb_koperasi tk ON tk.ID_USER = u.ID_USER';
        } else if ($instansiKey == 'koperasi_ukm') {
            $joinCond = 'LEFT JOIN tb_koperasi tk ON tk.ID_USER = u.ID_USER
                        LEFT JOIN tb_ukm tu ON tu.ID_USER = u.ID_USER';
        }

        $data = DB::selectOne('SELECT * FROM `user` u ' . $joinCond . ' WHERE u.ID_USER = ?', [$auth->ID_USER]);

        $is_data_complete = true;
        if ($data) {
            foreach ($data as $key => $value) {
                if (is_null($value) || $value === '') {
                    $is_data_complete = false;
                }
            }
        }

        // Update last login time
        DB::table('user')->where('EMAIL', $email)->update(['LOG_TIME' => date('Y-m-d H:i:s')]);

        // Build session data — same structure as before for backward compatibility
        $user_data = collect([
            'ID_USER' => $auth->ID_USER,
            'NAME' => $auth->NAME,
            'JENIS_INSTANSI' => ($auth->ID_ROLE == 1 || $auth->ID_ROLE == 4) ? 'ADMIN' : ($auth->JENIS_INSTANSI ?? 'UMUM'),
            'ID_ROLE' => $auth->ID_ROLE,
            'FOTO_PROFILE' => $auth->FOTO_PROFILE,
            'EMAIL' => $auth->EMAIL,
            'IS_DATA_COMPLETE' => ($auth->ID_ROLE == 1 || $auth->ID_ROLE == 4) ? true : $is_data_complete,
            'LOGGED_IN' => true,
        ]);

        // Clear any previous user session before setting new session
        Session::forget(['user', 'sso_token', 'sso_user']);
        Session::put('user', [$user_data]);

        // Store SSO token in session for later use (logout, API calls)
        Session::put('sso_token', $ssoToken);
        Session::put('sso_user', $ssoUser);

        // Set legacy_sijawara_id on SSO user (best-effort)
        try {
            $this->ssoService->updateLegacyId($ssoToken, 'legacy_sijawara_id', $auth->ID_USER);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Failed to set legacy_sijawara_id for ' . $auth->ID_USER . ': ' . $e->getMessage());
        }

        // Log activity to SSO server
        $this->ssoService->logActivity($ssoToken, 'access_app', 'User login ke aplikasi SIJAWARA+', $req->ip(), $req->userAgent());

        // Redirect based on role
        if ($auth->ID_ROLE == 1 || $auth->ID_ROLE == 4) {
            return redirect('dashboard');
        } elseif ($auth->ID_ROLE == 3) {
            // Check if must change password
            if (isset($ssoData['must_change_password']) && $ssoData['must_change_password']) {
                return redirect('ganti_kata_sandi');
            }
            return redirect('/');
        } else {
            return redirect('/');
        }
    }

    public function sso_transfer(Request $req)
    {
        $token = $req->input('sso_token');
        if (!$token) {
            return redirect('masuk')->with('error_msg', 'SSO Token tidak ditemukan');
        }

        $ssoResult = $this->ssoService->getUser($token);

        if (!$ssoResult['success']) {
            return redirect('masuk')->with('error_msg', 'SSO Token tidak valid');
        }

        $ssoUser = $ssoResult['data'];
        $legacyId = $ssoUser['legacy_sijawara_id'] ?? null;
        $email = !empty($ssoUser['email']) ? trim($ssoUser['email']) : null;
        $nik = !empty($ssoUser['nik']) ? trim($ssoUser['nik']) : null;

        // Look up local user hierarchically: legacy_sijawara_id -> email -> nik
        $auth = null;
        if (!empty($legacyId)) {
            $auth = DB::selectOne('SELECT * FROM user WHERE ID_USER = ?', [$legacyId]);
        }
        if (!$auth && !empty($email)) {
            $auth = DB::selectOne('SELECT * FROM user WHERE EMAIL = ?', [$email]);
        }
        if (!$auth && !empty($nik)) {
            $auth = DB::selectOne('SELECT * FROM user WHERE NIK = ? OR EMAIL = ?', [$nik, $nik]);
        }

        if ($auth == null) {
            // SSO login succeeded but no local user — create local user
            $userName = !empty($ssoUser['name']) ? $ssoUser['name'] : (!empty($email) ? $email : ($nik ?: 'User SSO'));
            $userEmail = !empty($email) ? $email : (($nik ?: 'user_' . time()) . '@sso.local');
            $KODE_USER = $this->GenerateUniqID($userName);
            $isAdmin = in_array($ssoUser['user_type'] ?? '', ['admin', 'pegawai']) || ($userEmail === 'admin@diskopukm.jatimprov.go.id');

            $localUser = new \App\Models\User();
            $localUser->ID_USER = $KODE_USER;
            $localUser->NAME = $userName;
            $localUser->EMAIL = $userEmail;
            if (!empty($nik)) {
                $localUser->NIK = $nik;
            }
            if (!empty($ssoUser['phone'])) {
                $localUser->TELP = $ssoUser['phone'];
            }
            $localUser->PASS = hash('sha256', md5(\Illuminate\Support\Str::random(12)));
            $localUser->ID_ROLE = $isAdmin ? 1 : 3; // 1 for admin/pegawai, 3 for general user
            $localUser->STATUS = 1;
            $localUser->IS_DELETE = 0;
            $localUser->REG_TIME = date('Y-m-d H:i:s');

            // Parse instansi from SSO user_type
            $userType = $ssoUser['user_type'] ?? 'umum';
            $jenisInstansi = 'UMUM';
            if ($userType == 'koperasi') {
                $jenisInstansi = 'KOPERASI';
            } elseif ($userType == 'ukm') {
                $jenisInstansi = 'UKM';
            }

            $localUser->JENIS_INSTANSI = $jenisInstansi;
            $localUser->save();

            $auth = DB::selectOne('SELECT * FROM user WHERE ID_USER = ?', [$KODE_USER]);

            // Set legacy_sijawara_id on SSO user
            try {
                $this->ssoService->updateLegacyId($token, 'legacy_sijawara_id', $KODE_USER);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Failed to set legacy_sijawara_id for ' . $KODE_USER . ': ' . $e->getMessage());
            }
        } else {
            // If local user exists but legacy_sijawara_id on SSO was not set yet, update it
            if (empty($ssoUser['legacy_sijawara_id'])) {
                try {
                    $this->ssoService->updateLegacyId($token, 'legacy_sijawara_id', $auth->ID_USER);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::warning('Failed to set legacy_sijawara_id for ' . $auth->ID_USER . ': ' . $e->getMessage());
                }
            }
        }

        if ($auth->STATUS == 0) {
            return redirect('masuk')->with('resp_msg', 'Tidak bisa masuk, akun anda belum diverifikasi');
        }
        if (isset($auth->IS_DELETE) && $auth->IS_DELETE == 1) {
            return redirect('masuk')->with('error_msg', 'Tidak bisa masuk, akun anda telah di ban');
        }

        // Check data completeness for koperasi/ukm
        $mappingInstansi = [
            'KOPERASI' => 'koperasi',
            'UKM' => 'ukm',
            'INSTANSI' => 'instansi',
            'KOPERASI;UKM' => 'koperasi_ukm',
            'UKM;KOPERASI' => 'koperasi_ukm',
            'UMUM' => 'umum',
            'KDMP' => 'kdmp',
            'ADMIN' => 'admin',
        ];

        $jenisInstansi = $auth->JENIS_INSTANSI ?? 'UMUM';
        $joinCond = '';
        $instansiKey = $mappingInstansi[$jenisInstansi] ?? 'umum';
        if ($instansiKey == 'ukm') {
            $joinCond = 'LEFT JOIN tb_ukm tu ON tu.ID_USER = u.ID_USER';
        } else if ($instansiKey == 'koperasi') {
            $joinCond = 'LEFT JOIN tb_koperasi tk ON tk.ID_USER = u.ID_USER';
        } else if ($instansiKey == 'koperasi_ukm') {
            $joinCond = 'LEFT JOIN tb_koperasi tk ON tk.ID_USER = u.ID_USER
                        LEFT JOIN tb_ukm tu ON tu.ID_USER = u.ID_USER';
        }

        $data = DB::selectOne('SELECT * FROM `user` u ' . $joinCond . ' WHERE u.ID_USER = ?', [$auth->ID_USER]);

        $is_data_complete = true;
        if ($data) {
            foreach ($data as $key => $value) {
                if (is_null($value) || $value === '') {
                    $is_data_complete = false;
                }
            }
        }

        // Update last login time
        DB::table('user')->where('ID_USER', $auth->ID_USER)->update(['LOG_TIME' => date('Y-m-d H:i:s')]);

        // Build session data
        $user_data = collect([
            'ID_USER' => $auth->ID_USER,
            'NAME' => $auth->NAME,
            'JENIS_INSTANSI' => ($auth->ID_ROLE == 1 || $auth->ID_ROLE == 4) ? 'ADMIN' : ($auth->JENIS_INSTANSI ?? 'UMUM'),
            'ID_ROLE' => $auth->ID_ROLE,
            'FOTO_PROFILE' => $auth->FOTO_PROFILE,
            'EMAIL' => $auth->EMAIL,
            'IS_DATA_COMPLETE' => ($auth->ID_ROLE == 1 || $auth->ID_ROLE == 4) ? true : $is_data_complete,
            'LOGGED_IN' => true,
        ]);

        // Clear any previous session to avoid session stacking
        Session::forget(['user', 'sso_token', 'sso_user']);
        Session::put('user', [$user_data]);

        // Store SSO token in session
        Session::put('sso_token', $token);
        Session::put('sso_user', $ssoUser);

        // Log access activity to SSO server
        $this->ssoService->logActivity($token, 'access_app', 'User mengakses aplikasi SIJAWARA+ via SSO', $req->ip(), $req->userAgent());

        // Check must_change_password flag from SSO
        if (!empty($ssoUser['must_change_password'])) {
            return redirect('ganti_kata_sandi');
        }

        // Redirect based on role
        if ($auth->ID_ROLE == 1 || $auth->ID_ROLE == 4) {
            return redirect('dashboard');
        } else {
            return redirect('/');
        }
    }

    public function gantiSandi()
    {
        $data["title"] = "Ganti Kata Sandi";

        if (!session("user")) {
            return redirect('masuk');
        }

        return
            view('template.header', $data) .
            view('auth.gantiSandi') .
            view('template.footer', $data);
    }

    public function submitSandi(Request $req)
    {
        try {
            $ssoToken = session('sso_token');
            $currentPassword = $req->input('current_password');
            $newPassword = $req->input('password');

            if (!$ssoToken) {
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Sesi SSO tidak ditemukan. Silakan login ulang.'
                ], 200);
            }

            // Change password on SSO server
            $ssoResult = $this->ssoService->changePassword($ssoToken, $currentPassword, $newPassword);

            if (!$ssoResult['success']) {
                return response()->json([
                    'status_code' => 400,
                    'message' => $ssoResult['message'] ?? 'Gagal mengganti kata sandi di SSO.'
                ], 200);
            }

            // Also update local DB for backward compatibility
            $hash_password = hash('sha256', md5($newPassword));
            DB::table("user")->where("ID_USER", session("user")[0]["ID_USER"])->update(["PASS" => $hash_password]);

            // Clear must_change_password token if exists
            DB::table("token")->where("ID_USER", session("user")[0]["ID_USER"])->update(["TYPE" => 0]);

            return response()->json([
                'status_code' => 200,
                'message' => 'Kata sandi berhasil diperbarui!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function register()
    {
        // Already authenticated locally, send to dashboard / home
        if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 1) {
            return redirect('dashboard');
        } else if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 2) {
            return redirect('/');
        } else if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 3) {
            return redirect('/');
        } else if (!empty(session('user')[0]['ID_ROLE']) && session('user')[0]['ID_ROLE'] == 4) {
            return redirect('dashboard');
        }

        // Local registration is deprecated. Redirect to SSO register.
        $ssoUrl = rtrim(env('SSO_URL', 'http://localhost:9000'), '/');
        return redirect($ssoUrl . '/register');
    }

    public function store(Request $req)
    {
        $check_user = DB::table('user')
            ->where('EMAIL', $req->input('email'))
            ->first();
        if (empty($check_user)) {
            $KODE_USER = $this->GenerateUniqID($req->input('name'));

            $user_type = strtolower($req->input('jenis_instansi'));

            // Also register in SSO server
            $ssoResult = $this->ssoService->register([
                'name' => $req->input('name'),
                'email' => $req->input('email'),
                'password' => $req->input('password'),
                'user_type' => $user_type,
            ]);
            // SSO registration is best-effort — don't block local registration
            if (!$ssoResult['success']) {
                \Illuminate\Support\Facades\Log::warning('SSO registration failed for ' . $req->input('email') . ': ' . ($ssoResult['message'] ?? 'Unknown error'));
                return redirect('daftar')->with('error_msg', $ssoResult['message'] ?? 'Pendaftaran SSO gagal. Silakan coba lagi.');
            } else {
                // Set legacy_sijawara_id on SSO user
                try {
                    $loginResult = $this->ssoService->login($req->input('email'), $req->input('password'));
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

            try {
                $User = new User();
                $User->ID_USER = $KODE_USER;
                $User->NAME = $req->input('name');
                $User->EMAIL = $req->input('email');
                $User->PASS = hash('sha256', md5($req->input('password')));
                $User->ID_ROLE = 3;
                $User->STATUS = 1;
                $User->IS_DELETE = 0;
                $User->REG_TIME = date('Y-m-d H:i:s');
                $User->JENIS_INSTANSI = $req->input('jenis_instansi');
                $User->save();
            } catch (\Throwable $e) {
                return redirect('daftar')->with('error_msg', 'Gagal menyimpan data pengguna: ' . $e->getMessage());
            }

            // SAVE TOKEN
            $token_key = bin2hex(random_bytes(32));
            $formDataToken = [
                'ID_USER' => $KODE_USER,
                'KEY' => $token_key,
                'TYPE' => 2,
                'STATUS' => 0,
                'LOG_TIME' => date('Y-m-d H:i:s'),
            ];
            DB::table('token')->insert($formDataToken);

            return redirect('masuk')->with('succ_msg', 'Anda Berhasil Mendaftar!');
        } else {
            return redirect('daftar')->with('error_msg', 'Email Telah Digunakan!');
        }
    }

    // not using brevo
    // public function verifAccount(Request $req)
    // {
    //     $getToken = DB::selectOne('
    //         SELECT
    //             *
    //         FROM
    //             token
    //         WHERE
    //             `KEY` = "' . $req->input('token') . '"
    //     ');
    //     if (empty($getToken)) {
    //         return redirect('masuk')->with('error_msg', 'Akun anda tidak terdaftar, Silahkan mendaftar terlebih dahulu!');
    //     }

    //     $status = DB::selectOne('
    //         SELECT
    //             STATUS,
    //             ID_USER
    //         FROM
    //             user
    //         WHERE
    //             ID_USER = "' . $getToken->ID_USER . '"
    //     ');

    //     if ($status->STATUS != 1) {
    //         // ACTIVATE USER 
    //         DB::table('user')->where('ID_USER', '=', $getToken->ID_USER)->update(['STATUS' => 1]);
    //     }

    //     return redirect('masuk')->with('succ_msg', 'Akun anda telah aktif, silahkan masuk!');
    // }

    public function logout(Request $request)
    {
        $ssoToken = Session::get('sso_token');

        Session::forget(['user', 'sso_token', 'sso_user']);
        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $ssoUrl = rtrim(env('SSO_URL', 'http://localhost:9000'), '/');

        // Redirect to SSO single-logout endpoint — SSO server revokes token,
        // destroys web session, then redirects to /login
        $sloUrl = $ssoUrl . '/slo' . ($ssoToken ? '?token=' . urlencode($ssoToken) : '');
        return redirect($sloUrl);
    }

    public function forgot_password(Request $req)
    {
        // Redirect to SSO server forgot password
        $ssoUrl = rtrim(env('SSO_URL', 'http://localhost:9000'), '/');
        return redirect($ssoUrl . '/forgot-password');
    }

    public function get_password(Request $req)
    {
        try {
            $email = $req->input('email');

            $user_data = DB::selectOne('
                SELECT
                    u.ID_USER
                FROM
                    user u
                WHERE
                    u.EMAIL = ?
                AND
                    u.ID_ROLE = 3

            ', [$email]);

            $Password = $this->GenerateUniqPassword();
            $hashPassword = hash('sha256', md5($Password));

            DB::beginTransaction();

            if ($user_data) {
                $token_key = bin2hex(random_bytes(32));
                $formDataToken = [
                    'KEY' => $token_key,
                    'TYPE' => 1,
                    'STATUS' => 0,
                    'LOG_TIME' => date('Y-m-d H:i:s'),
                ];
                DB::table('token')->updateOrInsert(['ID_USER' => $user_data->ID_USER], $formDataToken);
                DB::table("user")->where(["EMAIL" => $email])->update(["PASS" => $hashPassword]);
            }

            DB::commit();

            return response()->json([
                'status_code' => 200,
                'status_message' => "Berhasil Mereset Password!",
                'data' => $Password
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status_code' => 500,
                'status_message' => $e->getMessage()
            ]);
        }
    }

    public function change_password(Request $req)
    {
        try {
            $ssoToken = session('sso_token');
            $currentPassword = $req->input('passwordOld');
            $newPassword = $req->input('password');

            if (!$ssoToken) {
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Sesi SSO tidak ditemukan. Silakan login ulang.'
                ]);
            }

            // Change password on SSO server
            $ssoResult = $this->ssoService->changePassword($ssoToken, $currentPassword, $newPassword);

            if (!$ssoResult['success']) {
                return response()->json([
                    'status_code' => 400,
                    'message' => $ssoResult['message'] ?? 'Kata Sandi Lama Tidak Sesuai!'
                ]);
            }

            // Also update local DB for backward compatibility
            $hash_password = hash('sha256', md5($newPassword));
            DB::table("user")->where("ID_USER", session("user")[0]["ID_USER"])->update(["PASS" => $hash_password]);

            return response()->json([
                'status_code' => 200,
                'message' => 'Berhasil Mengganti Kata Sandi!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message' => $e->getMessage()
            ]);
        }
    }

    // public function forgot_password_send(Request $req)
    // {
    //     $data['title'] = 'Forgot Password Check Email';
    //     if (!empty(session('user')[0]['EMAIL'])) {
    //         $data['email'] = session('user')[0]['EMAIL'];
    //     } else {
    //         $data['email'] = $req->input('email');
    //     }

    //     $user_data = DB::selectOne('
    //         SELECT
    //             ID_USER
    //         FROM
    //             user
    //         WHERE
    //             EMAIL = "' . $data['email'] . '"
    //     ');

    //     if (empty($user_data)) {
    //         return redirect('lupa-katasandi')->with('resp_msg', 'Email tidak ditemukan di sistem kami. Harap daftar terlebih dahulu');
    //     }

    //     $checking_token = DB::selectOne('
    //         SELECT
    //             `KEY`
    //         FROM
    //             token
    //         WHERE
    //             ID_USER = "' . $user_data->ID_USER . '"
    //             AND TYPE = 2
    //     ');

    //     if (empty($checking_token)) {
    //         $token_key = bin2hex(random_bytes(32));
    //         $formDataToken = [
    //             'ID_USER' => $user_data->ID_USER,
    //             'KEY' => $token_key,
    //             'TYPE' => 2,
    //             'STATUS' => 0,
    //             'LOG_TIME' => date('Y-m-d H:i:s'),
    //         ];
    //         DB::table('token')->insert($formDataToken);
    //     } else {
    //         $token_key = bin2hex(random_bytes(32));
    //         $formDataToken = [
    //             'KEY' => $token_key,
    //             'LOG_TIME' => date('Y-m-d H:i:s'),
    //         ];
    //         DB::table('token')->where('ID_USER', $user_data->ID_USER)->update($formDataToken);
    //     }

    //     $details = [
    //         'title' => 'Oh snap you forgot your password',
    //         'body' => "Jangan khawatir, tekan link dibawah untuk menyetel ulang password.",
    //         'link' => url('reset-katasandi?token=' . $token_key),
    //         'button' => 'Setel Ulang Password'
    //     ];

    //     $mail = new MailSender($details);
    //     $mail->subject("Reset Password");
    //     Mail::to($req->input('email'))->send($mail);

    //     return view('template.header', $data) .
    //         view('auth.forgot_password_confirm', $data) .
    //         view('template.footer', $data);
    // }

    // public function forgot_password_reset(Request $req)
    // {
    //     $data['title'] = 'Reset Password - SIJAWARA+';
    //     $data['token'] = DB::table('token')
    //         ->where('token.KEY', '=', $req->input('token'))
    //         ->first();

    //     if (!empty($data['token'])) {
    //         $dbtimestamp = strtotime($data['token']->LOG_TIME);
    //         if (time() - $dbtimestamp > 1 * 300) {
    //             return redirect('lupa-katasandi')->with('resp_msg', "Token anda sudah kadaluarsa.");
    //         }
    //     } else {
    //         return redirect('lupa-katasandi')->with('resp_msg', "Token tidak ditemukan di sistem.");
    //     }
    //     return view('template.header', $data) .
    //         view('auth.reset_password', $data) .
    //         view('template.footer', $data);
    // }

    // public function resetPassword(Request $req)
    // {
    //     $formDataReset = [
    //         'PASS' => hash('sha256', md5($req->input('password'))),
    //         'migrations' => 1
    //     ];

    //     DB::table('user')->where('ID_USER', '=', $req->input('id_user'))->update($formDataReset);

    //     return redirect('masuk')->with('resp_sts', 'success')->with('succ_msg', 'Akun password anda berhasil di setel ulang.');
    // }


    public function GenerateUniqPassword()
    {
        $pin = '';
        for ($i = 0; $i < 7; $i++) {
            do {
                $digit = random_int(0, 9);
            } while ($i > 0 && $digit == (int) $pin[$i - 1]);
            $pin .= $digit;
        }

        return $pin;
    }
    public function GenerateUniqID($var)
    {
        $string = preg_replace('/[^a-z]/i', '', $var);
        $vocal = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", " ");
        $scrap = str_replace($vocal, "", $string);
        $begin = substr($scrap, 0, 4);
        $uniqid = strtoupper($begin);
        return "USR_" . $uniqid . substr(md5(time()), 0, 3);
    }
}
