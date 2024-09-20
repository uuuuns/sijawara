<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasalahUkm extends Model
{
    use HasFactory;
    protected $table = 'md_masalah_ukm';
    protected $primaryKey = 'ID';

    protected $fillable = ['NAMA_MASALAH_UKM'];

    public function get_all_data()
    {
        $sql = DB::select("
            SELECT
                ID, NAMA_MASALAH_UKM
            FROM
                md_masalah_ukm
        ");
        return $sql;
    }
    public function insertMU($data)
    {
        // dd($data);
        $sql = DB::insert(
            "
            INSERT INTO  md_masalah_ukm
                (NAMA_MASALAH_UKM)
            VALUES
                (?)
            ",
            [$data['NAMA_MASALAH_UKM']],
        );
        return $sql;
    }

    public function updateMU($data, $id)
    {
        $sql = DB::update(
            '
        UPDATE md_masalah_ukm
        SET NAMA_MASALAH_UKM = ?
        WHERE id = ?
        ',
            [$data['NAMA_MASALAH_UKM'], $id],
        );
        return $sql;
    }

    public function deleteMU($data){
        $sql = DB::delete("
            DELETE FROM md_masalah_ukm
            WHERE ID = ?
        ", [$data]);
        return $sql;
    }
}
