<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    use HasFactory;

    // Definisikan kolom-kolom yang dapat diisi secara massal
    protected $fillable = ['EMAIL', 'TELP','NAME','JK', 'FOTO_PROFILE', 'ALAMAT'];    
    protected $table = 'user';
    protected $primaryKey = 'ID_USER';    
    public $timestamps = false;
    public function get_user($id_user)
    {
        $sql = DB::select("
            SELECT 
                *
            FROM 
                user
            WHERE 
                ID_USER = '$id_user'
        ");
        return $sql;
    }
    public function get_my_product(){
        $sql = DB::select('
        SELECT 
            `activity`.*, 
            `kategori`.`KATEGORI`, 
            `course`.`DESKRIPSI_COURSE`, 
            (
                CEIL(
                    (
                        SELECT
                            MAX(o.MAPPING_COUNT)
                        FROM
                            `order` o
                        WHERE
                            o.ID_USER = "' . session('user')[0]['ID_USER'] . '"
                            AND o.ID_PRODUCT = activity.ID_ACTIVITY
                    ) / 
                    (
                            SELECT
                            COUNT(*)
                        FROM
                            mapping_course
                        WHERE
                            mapping_course.ID_USER = "' . session('user')[0]['ID_USER'] . '"
                            AND mapping_course.ID_ACTIVITY = activity.ID_ACTIVITY
                    ) * 100
                )
            ) AS PROGRESS
        FROM 
            `activity` 
            LEFT JOIN `course` ON `course`.`ID_ACTIVITY` = `activity`.`ID_ACTIVITY` 
            LEFT JOIN `kategori` ON `kategori`.`ID_KATEGORI` = `course`.`KATEGORI` 
            LEFT JOIN `order` ON `order`.`ID_PRODUCT` = `activity`.`ID_ACTIVITY` 
        WHERE 
            `activity`.`TYPE_ACTIVITY` = 1
        AND
            `order`.`ID_USER` = "' . session('user')[0]['ID_USER'] . '"
        ');
        return $sql;
    }
    public function get_my_product2(){
        $sql = DB::select("
        SELECT 
            `activity`.*, 
            `kategori`.`KATEGORI`, 
            `course`.`DESKRIPSI_COURSE`,
                ( 
                SELECT 
                    COUNT(*) 
                FROM 
                    `order` o 
                WHERE 
                    o.ID_USER = '" . session('user')[0]['ID_USER'] . "'
                    AND o.ID_PRODUCT = `activity`.ID_ACTIVITY
                ) as DATA_CHECKING
            FROM 
                `activity` 
            LEFT JOIN `course` ON 
                `course`.`ID_ACTIVITY` = `activity`.`ID_ACTIVITY` 
            LEFT JOIN `kategori` ON 
                `kategori`.`ID_KATEGORI` = `course`.`KATEGORI` 
            WHERE 
                `activity`.`TYPE_ACTIVITY` = 2
        ");
        return $sql;
    }
    // public static function update_profile($data1, $data2,$data3,$data4)
    public static function update_profile(array $data)
    {
        // Temukan pengguna berdasarkan ID
        $user = self::find(session('user')[0]['ID_USER']);
        if ($user) {
            // Perbarui kolom yang diinginkan
            $user->EMAIL = $data[0]['EMAIL'];
            $user->NAME = $data[0]['NAME'];
            $user->TELP = $data[0]['TELP'];
            $user->JK = $data[0]['JK'];
            $user->NIK = $data[0]['NIK'];
            $user->ALAMAT = $data[0]['ALAMAT'];
            $user->TGL_LAHIR = $data[0]['TGL_LAHIR'];
            $user->TEMPAT_LAHIR = $data[0]['TEMPAT_LAHIR'];
            $user->NAMA_INSTANSI = $data[0]['NAMA_INSTANSI'];
            $user->JABATAN = $data[0]['JABATAN'];
            $user->JENIS_INSTANSI = $data[0]['JENIS_INSTANSI'];
            $user->ID_PROVINSI = $data[0]['ID_PROVINSI'];
            $user->ID_KOTA = $data[0]['ID_KOTA'];
            if($data[0]['FOTO_PROFILE'] != null){
                $user->FOTO_PROFILE = $data[0]['FOTO_PROFILE'];
            }
            return $user->save(); // Simpan perubahan ke database
        }

        return false; // Pengguna tidak ditemukan
    }
    public static function updateTableById(array $data)
    {
        // Temukan pengguna berdasarkan ID
        
        return DB::table('user_data')->where('ID_USER', session('user')[0]['ID_USER'])->update($data);
    }
    
}
