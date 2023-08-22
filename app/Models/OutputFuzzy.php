<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutputFuzzy extends Model
{
    use HasFactory;

    protected $table = 'tbl_data_gas';

    protected $fillable = [
        'gas_amonia',
        'gas_metana',
        'komposisi_aman',
        'komposisi_waspada',
        'komposisi_bahaya',
        'nilai_a',
        'nilai_a',
        'output_deff',
        'kondisi',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
