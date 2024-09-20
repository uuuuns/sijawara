<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JabatanUkm extends Model
{
    use HasFactory;
    protected $table = 'md_jabatan_ukm';
    protected $primaryKey = 'ID';

    protected $fillable = ['NAMA_JABATAN_UKM'];

    public function get_all_data()
    {
        $sql = DB::select("
            SELECT
                ID, NAMA_JABATAN_UKM
            FROM
                md_jabatan_ukm
        ");
        return $sql;
    }
    public function insertJU($data)
    {
        // dd($data);
        $sql = DB::insert(
            "
            INSERT INTO  md_jabatan_ukm
                (NAMA_JABATAN_UKM)
            VALUES
                (?)
            ",
            [$data['NAMA_JABATAN_UKM']],
        );
        return $sql;
    }

    public function updateJU($data, $id)
    {
        $sql = DB::update(
            '
        UPDATE md_jabatan_ukm
        SET NAMA_JABATAN_UKM = ?
        WHERE id = ?
        ',
            [$data['NAMA_JABATAN_UKM'], $id],
        );
        return $sql;
    }

    public function deleteJU($data){
        $sql = DB::delete("
            DELETE FROM md_jabatan_ukm
            WHERE ID = ?
        ", [$data]);
        return $sql;
    }
}
