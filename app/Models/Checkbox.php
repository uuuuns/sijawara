<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkbox extends Model
{
    protected $table = 'md_checkbox';
    protected $primaryKey = 'ID_CHECKBOX';
    public $timestamps = false;

    protected $fillable = [
        'ID_SURVEI',
        'VALUE'
    ];

    public function survei()
    {
        return $this->belongsTo(SurveiMaster::class, 'ID_SURVEI');
    }
}
