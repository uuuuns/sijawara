<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WilayahPemasaran extends Model
{
    use HasFactory;
    protected $table = 'md_wilayah_pemasaran';
    protected $primaryKey = 'ID';

    protected $fillable = ['NAMA_WILAYAH_PEMASARAN'];

    public function get_all_data()
    {
        $sql = DB::select("
            SELECT
                ID, NAMA_WILAYAH_PEMASARAN
            FROM
                md_wilayah_pemasaran
        ");
        return $sql;
    }
    public function insertWP($data)
    {
        $sql = DB::insert(
            "
            INSERT INTO  md_wilayah_pemasaran
                (NAMA_WILAYAH_PEMASARAN)
            VALUES
                (?)
            ",
            [$data['NAMA_WILAYAH_PEMASARAN']],
        );
        return $sql;
    }

    public function updateWP($data, $id)
    {
        $sql = DB::update(
            '
        UPDATE md_wilayah_pemasaran
        SET NAMA_WILAYAH_PEMASARAN = ?
        WHERE id = ?
        ',
            [$data['NAMA_WILAYAH_PEMASARAN'], $id],
        );
        return $sql;
    }

    public function deleteWP($data){
        $sql = DB::delete("
            DELETE FROM md_wilayah_pemasaran
            WHERE ID = ?
        ", [$data]);
        return $sql;
    }
}
