<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataFuzzy extends Model
{
    use HasFactory;

    protected $table = 'tbl_hitung_fuzzy';

    protected $fillable = [
        'id',
        'gas_amonia',
        'gas_metana',
        'komposisi_aman',
        'komposisi_waspada',
        'komposisi_bahaya',
        'nilai_a1',
        'nilai_a2',
        'output_deff',
        'kondisi',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
