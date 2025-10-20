<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;

class UserData extends Controller
{
    protected $secret_key;

    public function __construct()
    {
        $this->secret_key = "niw92g6xniot7s29";
    }

    public function dataKoperasi()
    {
        if ($_GET["secret_key"] != $this->secret_key) {
            return response([
                "status_code"       => 403,
                "status_message"    => "Akses ditolak!"
            ], 200);
        }
        
        try {
            $data = DB::SelectOne("
                SELECT
                    tk.ID_USER ,
                    tk.nik AS NIK ,
                    tk.nm_koperasi AS NAMA_KOPERASI ,
                    tk.alamat_koperasi ,
                    mp.nama_province AS PROVINSI ,
                    mk.nama_kota AS KOTA ,
                    tk.phone AS NO_TELP ,
                    tk.no_badan_hukum AS NO_BADAN_HUKUM ,
                    tk.tgl_badan_hukum AS TGL_BADAN_HUKUM ,
                    tk.no_pad AS NO_PAD ,
                    tk.tgl_pad AS TGL_PAD ,
                    tk.cabang AS JUMLAH_CABANG ,
                    tk.tgl_rat AS TGL_RAT ,
                    tk.nm_ketua AS NAMA_KETUA ,
                    tk.phone_ketua AS NO_TELP_KETUA ,
                    tk.nm_sekretaris AS NAMA_SEKRETARIS ,
                    tk.phone_sekretaris AS NO_TELP_SEKRETARIS ,
                    tk.nm_bendahara AS NAMA_BENDAHARA ,
                    tk.phone_bendahara AS NO_TELP_BENDAHARA ,
                    tk.anggota_pria AS JUMLAH_ANGGOTA_PRIA ,
                    tk.anggota_wanita AS JUMLAH_ANGGOTA_WANITA ,
                    tk.manager_pria AS JUMLAH_MANAGER_PRIA ,
                    tk.manager_wanita AS JUMLAH_MANAGER_WANITA ,
                    tk.karyawan_pria AS JUMLAH_KARYAWAN_PRIA ,
                    tk.karyawan_wanita AS JUMLAH_KARYAWAN_WANITA ,
                    mbk.NAMA AS BENTUK_KOPERASI ,
                    mjk.NAMA AS JENIS_KOPERASI ,
                    mkk.NAMA AS KELOMPOK_KOPERASI ,
                    msu.NAMA AS SEKTOR_USAHA ,
                    tk.volume_usaha AS VOLUME_USAHA ,
                    tk.asset AS ASSET ,
                    muu.name AS UNIT_USAHA ,
                    tk.modal_sendiri AS MODAL_SENDIRI ,
                    tk.modal_luar AS MODAL_LUAR ,
                    tk.sisa_hasil_usaha AS SISA_HASIL_USAHA
                FROM
                    tb_koperasi tk
                LEFT JOIN md_provinsi mp ON
                    mp.id_provinsi = tk.id_provinsi
                LEFT JOIN md_kota mk ON
                    mk.id_kota = tk.id_kota
                LEFT JOIN md_bentuk_koperasi mbk ON
                    mbk.ID = tk.id_bentuk_koperasi
                LEFT JOIN md_jenis_koperasi mjk ON
                    mjk.ID = tk.id_jenis_koperasi
                LEFT JOIN md_kelompok_koperasi mkk ON
                    mkk.ID = tk.id_kelompok_koperasi
                LEFT JOIN md_sektor_usaha msu ON
                    msu.ID = tk.id_sektor_usaha
                LEFT JOIN md_unit_usaha muu ON
                    muu.ID = tk.id_unit_usaha
                WHERE
                    tk.ID_USER = ?
            ", [$_GET["id_user"]]);
            
            if ($data) {
                return response([
                    'status_code'       => 200,
                    'status_message'    => 'Data Ditemukan!',
                    'data'              => $data,
                ], 200);
            } else {
                return response([
                    'status_code'       => 404,
                    'status_message'    => 'Data tidak ditemukan!',
                ], 200);
            }
        } catch (Exception $exp) {
            return response([
                'status_code'       => 500,
                'status_message'    => $exp->getMessage(),
            ], 200);
        }
    }

    public function dataUkm()
    {
        if ($_GET["secret_key"] != $this->secret_key) {
            return response([
                "status_code"       => 403,
                "status_message"    => "Akses ditolak!"
            ], 200);
        }

        try {
            $data = DB::SelectOne("
                SELECT
                tu.nama_ukm AS NAMA_UKM ,
                tu.alamat_ukm AS ALAMAT_UKM ,
                tu.nik_pemilik AS NIK_PEMILIK ,
                tu.nama_pemilik AS NAMA_PEMILIK ,
                tu.alamat_pemilik AS ALAMAT_PEMILIK ,
                tu.tempat_lahir_pemilik AS TEMPAT_LAHIR_PEMILIK ,
                tu.tanggal_lahir_pemilik AS TANGGAL_LAHIR_PEMILIK ,
                tu.jenis_kelamin_pemilik AS JENIS_KELAMIN_PEMILIK ,
                tu.phone_pemilik AS NO_TELP_PEMILIK_UKM ,
                mp.nama_province AS PROVINSI ,
                mk.nama_kota AS KOTA ,
                tu.kegiatan_usaha AS KEGIATAN_USAHA ,
                tu.produk_dihasilkan AS PRODUK ,
                mku.NAMA_KATEGORI_UKM ,
                tu.tahun_mulai AS TAHUN_MULAI ,
                tu.kapasitas_produksi AS KAPASITAS_PRODUKSI ,
                tu.volume_usaha AS VOLUME_USAHA ,
                tu.tenaga_pria AS TENAGA_KERJA_PRIA ,
                tu.tenaga_wanita AS TENAGA_KERJA_WANITA ,
                mbu.NAMA_BADAN_USAHA ,
                tu.npwp AS NPWP ,
                tu.lokasi_pemasaran AS LOKASI_PEMASARAN,
                tu.tahun_realisasi AS TAHUN_REALISASI
                FROM
                    tb_ukm tu
                LEFT JOIN md_provinsi mp ON
                    mp.id_provinsi = tu.id_provinsi
                LEFT JOIN md_kota mk ON
                    mk.id_kota = tu.id_kota
                LEFT JOIN md_kategori_ukm mku ON
                    mku.ID = tu.id_kategori_ukm
                LEFT JOIN md_badan_usaha mbu ON
                    mbu.ID = tu.id_badan_usaha
                WHERE
                    tu.ID_USER = ?
            ",[$_GET["id_user"]]);

            if ($data) {
                return response([
                    'status_code'       => 200,
                    'status_message'    => 'Data ditemukan!',
                    'data'              => $data,
                ], 200);
            } else {
                return response([
                    'status_code'       => 404,
                    'status_message'    => 'Data tidak ditemukan!',
                ], 200);
            }
        } catch (Exception $exp) {
            return response([
                'status_code'       => 500,
                'status_message'    => $exp->getMessage(),
            ], 200);
        }
    }
}
