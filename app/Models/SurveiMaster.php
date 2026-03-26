<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveiMaster extends Model
{
    protected $table = 'md_survei';
    protected $primaryKey = 'ID_SURVEI';
    public $timestamps = false;

    protected $fillable = [
        'KATEGORI',
        'TEXT',
        'CREATED_AT',
        'UPDATED_AT',
        'CREATED_BY',
        'UPDATED_BY'
    ];

    public function checkbox()
    {
        return $this->hasMany(Checkbox::class, 'ID_SURVEI');
    }
}
