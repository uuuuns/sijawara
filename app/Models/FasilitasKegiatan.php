<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FasilitasKegiatan extends Model
{
    use HasFactory;
    protected $table = 'md_fasilitas_kegiatan';
    protected $primaryKey = 'ID';

    protected $fillable = ['NAMA_FASILITAS_KEGIATAN'];

    public function get_all_data()
    {
        $sql = DB::select("
            SELECT
                ID, NAMA_FASILITAS_KEGIATAN
            FROM
                md_fasilitas_kegiatan
        ");
        return $sql;
    }
    public function insertFK($data)
    {
        $sql = DB::insert(
            "
            INSERT INTO  md_fasilitas_kegiatan
                (NAMA_FASILITAS_KEGIATAN)
            VALUES
                (?)
            ",
            [$data['NAMA_FASILITAS_KEGIATAN']],
        );
        return $sql;
    }

    public function updateFK($data, $id)
    {
        $sql = DB::update(
            '
        UPDATE md_fasilitas_kegiatan
        SET NAMA_FASILITAS_KEGIATAN = ?
        WHERE id = ?
        ',
            [$data['NAMA_FASILITAS_KEGIATAN'], $id],
        );
        return $sql;
    }

    public function deleteFK($data){
        $sql = DB::delete("
            DELETE FROM md_fasilitas_kegiatan
            WHERE ID = ?
        ", [$data]);
        return $sql;
    }
}
