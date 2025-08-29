<?php

namespace App\Models;

use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BadanUsaha extends Model
{
    use HasFactory;
    protected $table = 'md_badan_usaha';
    protected $primaryKey = 'ID';

    protected $fillable = ['NAMA_BADAN_USAHA'];

    public function get_all_data()
    {
        $sql = DB::select("
            SELECT
                ID, NAMA_BADAN_USAHA
            FROM
                md_badan_usaha
        ");
        return $sql;
    }
    public function insertBU($data)
    {
        $sql = DB::insert(
            "
            INSERT INTO  md_badan_usaha
                (NAMA_BADAN_USAHA)
            VALUES
                (?)
            ",
            [$data['NAMA_BADAN_USAHA']],
        );
        return $sql;
    }

    public function updateBU($data, $id)
    {
        $sql = DB::update(
            '
        UPDATE md_badan_usaha
        SET NAMA_BADAN_USAHA = ?
        WHERE id = ?
        ',
            [$data['NAMA_BADAN_USAHA'], $id],
        );
        return $sql;
    }

    public function deleteBU($data){
        $sql = DB::delete("
            DELETE FROM md_badan_usaha
            WHERE ID = ?
        ", [$data]);
        return $sql;
    }
}
