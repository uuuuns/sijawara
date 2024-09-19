<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKoperasi extends Model
{
    protected $table = 'md_jenis_koperasi';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
