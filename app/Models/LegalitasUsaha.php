<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalitasUsaha extends Model
{
    protected $table = 'md_legalitas_usaha';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    // Add the get_all_data method
    public static function get_all_data()
    {
        return self::all(); // Return all records from the md_legalitas_usaha table
    }
}
