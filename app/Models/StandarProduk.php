<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StandarProduk extends Model
{
    use HasFactory;
    protected $table = 'md_standar_produk';
    protected $primaryKey = 'ID';

    protected $fillable = ['NAMA_STANDAR_PRODUK'];

    public function get_all_data()
    {
        $sql = DB::select("
            SELECT
                ID, NAMA_STANDAR_PRODUK
            FROM
                md_standar_produk
        ");
        return $sql;
    }
    public function insertSP($data)
    {
        // dd($data);
        $sql = DB::insert(
            "
            INSERT INTO  md_standar_produk
                (NAMA_STANDAR_PRODUK)
            VALUES
                (?)
            ",
            [$data['NAMA_STANDAR_PRODUK']],
        );
        return $sql;
    }

    public function updateSP($data, $id)
    {
        $sql = DB::update(
            '
        UPDATE md_standar_produk
        SET NAMA_STANDAR_PRODUK = ?
        WHERE id = ?
        ',
            [$data['NAMA_STANDAR_PRODUK'], $id],
        );
        return $sql;
    }

    public function deleteSP($data){
        $sql = DB::delete("
            DELETE FROM md_standar_produk
            WHERE ID = ?
        ", [$data]);
        return $sql;
    }
}
