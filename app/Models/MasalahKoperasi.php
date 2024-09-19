<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasalahKoperasi extends Model
{
    protected $table = 'md_masalah_koperasi';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
