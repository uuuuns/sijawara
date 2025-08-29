<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriUkm extends Model
{
    use HasFactory;
    protected $table = 'md_kategori_ukm';
    protected $primaryKey = 'ID';

    protected $fillable = ['NAMA_KATEGORI_UKM'];

    public function get_all_data()
    {
        $sql = DB::select("
            SELECT
                ID, NAMA_KATEGORI_UKM
            FROM
                md_kategori_ukm
        ");
        return $sql;
    }
    public function insertKU($data)
    {
        $sql = DB::insert(
            "
            INSERT INTO  md_kategori_ukm
                (NAMA_KATEGORI_UKM)
            VALUES
                (?)
            ",
            [$data['NAMA_KATEGORI_UKM']],
        );
        return $sql;
    }

    public function updateKU($data, $id)
    {
        $sql = DB::update(
            '
        UPDATE md_kategori_ukm
        SET NAMA_KATEGORI_UKM = ?
        WHERE id = ?
        ',
            [$data['NAMA_KATEGORI_UKM'], $id],
        );
        return $sql;
    }

    public function deleteKU($data){
        $sql = DB::delete("
            DELETE FROM md_kategori_ukm
            WHERE ID = ?
        ", [$data]);
        return $sql;
    }
}
