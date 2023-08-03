<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanFuzzy extends Model
{
    use HasFactory;

    protected $table = 'tbl_aturan_fuzzy';

    protected $fillable = [
        'variabel1',
        'variabel2',
        'konklusi',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
