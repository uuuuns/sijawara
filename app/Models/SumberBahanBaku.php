<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SumberBahanBaku extends Model
{
    use HasFactory;
    protected $table = 'md_sumber_bahanbaku';
    protected $primaryKey = 'ID';

    protected $fillable = ['NAMA_SUMBER_BAHAN_BAKU'];

    public function get_all_data()
    {
        $sql = DB::select("
            SELECT
                ID, NAMA_SUMBER_BAHAN_BAKU
            FROM
                md_sumber_bahanbaku
        ");
        return $sql;
    }
    public function insertSB($data)
    {
        // dd($data);
        $sql = DB::insert(
            "
            INSERT INTO  md_sumber_bahanbaku
                (NAMA_SUMBER_BAHAN_BAKU)
            VALUES
                (?)
            ",
            [$data['NAMA_SUMBER_BAHAN_BAKU']],
        );
        return $sql;
    }

    public function updateSB($data, $id)
    {
        $sql = DB::update(
            '
        UPDATE md_sumber_bahanbaku
        SET NAMA_SUMBER_BAHAN_BAKU = ?
        WHERE id = ?
        ',
            [$data['NAMA_SUMBER_BAHAN_BAKU'], $id],
        );
        return $sql;
    }

    public function deleteSB($data){
        $sql = DB::delete("
            DELETE FROM md_sumber_bahanbaku
            WHERE ID = ?
        ", [$data]);
        return $sql;
    }
}
