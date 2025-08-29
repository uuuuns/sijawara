<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PMDK extends Model
{
    function __construct()
    {
        parent::__construct();
        DB::statement("SET foreign_key_checks = 0;");
    }

    public static function detail_pmdk($id_activity)
    {
        return DB::Select("
            SELECT
                a.*
            FROM
                activity a
            LEFT JOIN course c ON
                a.ID_ACTIVITY = c.ID_ACTIVITY
            LEFT JOIN item_course ic ON
                c.ID_COURSE = ic.ID_COURSE
            LEFT JOIN course co ON
                ic.ID_COURSE = co.ID_COURSE
            WHERE
                a.ID_ACTIVITY = 'ACT_RHSM7d5'
        ");
    }
}
